<?php

include_once 'mcc.db.class.inc';

function mcc_common_upload_qb() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('upload_qb_sheet');
    return theme('syllabus_upload_form_template', $vars);
}

function upload_qb_sheet($form, &$form_state) {
    _add_datatable_resources();
    $form = array();
    $mccDB = new MCCdb();
    global $user;
    if(_isFacultyOnly()) {
        $subjects = _getFacultyCourses(null, true);
        $vars['uploaded_questions'] = $mccDB->getQuestions(null, false, null, $subjects);
    } else
        $vars['uploaded_questions'] = $mccDB->getQuestions();
//  pretty_print($uploaded_questions, 0);
    $form['r1'] = array(
        '#markup' => '<div class="row">'
    );
    $form['r1c1'] = array(
        '#markup' => '<div class="col col-md-5">'
    );
    $form['qb_csv'] = array(
        '#type' => 'managed_file',
        '#title' => t('Upload CSV File'),
        '#upload_location' => 'public://mcc_syllabus/',
        '#default_value' => NULL,
        '#theme' => 'syllabus_pdf_thumb_upload',
        '#progress_indicator' => 'throbber',
        '#progress_message' => 'Uploading ...',
        '#upload_validators' => array(
            'file_validate_extensions' => array('csv'),
            'file_validate_size' => array(5 * 1024 * 1024),
            'file_validate_name' => array('uploaded_qb_custom_validator')
        )
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );
    $form['r1c1End'] = array(
        '#markup' => '</div>'
    );
    $form['r1c2'] = array(
        '#markup' => '<div class="col col-md-7">'
    );
    $instruction_video = drupal_get_path('module', 'mcc_common') . '/instructions.webm';
    $instruction_video_url = '<a target="_blank" style="display:inline; text-decoration:underline" class="" href="' . file_create_url($instruction_video) . '">Video Instruction <i class="fa fa-external-link"></i></i></a>';
    $csv_blank_file = drupal_get_path('module', 'mcc_common') . '/MCC_QuestionBank_ Blank.csv';
    $csv_blank_file_url = '<a style="width:25%" class="btn btn-success btn-rounded btn-outline waves-effect waves-light" href="' . file_create_url($csv_blank_file) . '">Download</a>';
    $csv_sample_file = drupal_get_path('module', 'mcc_common') . '/MCC_QuestionBank_Sample.csv';
    $csv_sample_file_url = '<a style="width:25%" class="btn btn-success btn-rounded btn-outline waves-effect waves-light" href="' . file_create_url($csv_sample_file) . '">Download</a>';
    $csv_g_doc_url = '<a target="_blank" style="display:inline; text-decoration:underline" class="" href="https://docs.google.com/spreadsheets/d/1n1yHcqo5XytJY-4rHjAvtrv8JqQTMjdIdsmA7xAffOM/edit">Here <i class="fa fa-external-link"></i></i></a>';
    $form['r1c2Inst'] = array(
        '#markup' => '<div class="card card-outline-primary m-b-20 white-box"><div class="card-block">'
        . '<ul class="common-list">'
        . '<li>1. Create your Question Bank ' . $csv_g_doc_url . ' ' . $instruction_video_url . '</li>'
        . '<li>2. Or you can download below csv file and update the file and upload it.</li>'
        . '<li>3. Sample CSV file ' . $csv_sample_file_url . '</li>'
        . '<li>4. Blank CSV file ' . $csv_blank_file_url . '</li>'
        . '</ul>'
        . '</div>'
        . '</div>'
    );
    $form['r1c2End'] = array(
        '#markup' => '</div>'
    );
    $form['r1End'] = array(
        '#markup' => '</div>'
    );

    $form['uploaded_question'] = array(
        '#markup' => '<div id="uploaded_question_div">' . theme('list_uploaded_qb_template', $vars) . '</div>',
    );

    return $form;
}

function uploaded_qb_custom_validator(stdClass $file) {
    db_query("DELETE FROM {file_managed} WHERE uri = '$file->destination'");
}

function upload_qb_sheet_submit($form, &$form_state) {
    $submitted_values = $form_state['values'];
    $file = file_load($submitted_values['qb_csv']);

    ini_set('auto_detect_line_endings', TRUE);
    $csv_uri = file_create_url($file->uri);
//  echo $csv_uri;

    $handle = fopen($csv_uri, 'r');
    $row = fgetcsv($handle);
    $columns = array();
    $rows = array();
    foreach ($row as $i => $header) {
        $columns[$i] = trim($header);
    }

    while ($row = fgetcsv($handle)) {
        $record = array();
        foreach ($row as $i => $field) {
            $record[] = mb_convert_encoding($field, "HTML-ENTITIES", "UTF-8");
        }
        $rows[] = $record;
    }
    fclose($handle);

    if (!empty($rows)) {
        if (isset($_SESSION['uploaded_qb']))
            unset($_SESSION['uploaded_qb']);

        $_SESSION['uploaded_qb'] = $rows;
        drupal_goto('syllabus/uploaded-qb');
    }
    drupal_set_message('Error Occurs!', 'error');
}

function mcc_common_uploaded_qb() {
    if (!empty($_SESSION['uploaded_qb'])) {
        drupal_set_message('Save the form to upload questions');

        $vars['entry_form'] = drupal_get_form('qb_entry_form', $_SESSION['uploaded_qb']);
//    if (isset($_SESSION['uploaded_qb']))
//      unset($_SESSION['uploaded_qb']);
        return theme('syllabus_entry_form_template', $vars);
    } else {
        drupal_goto('syllabus/upload-qb');
    }
}

function qb_entry_form($form, &$form_state, $uploaded_qb = array()) {
//  pretty_print($uploaded_qb);
    $courses = array();
    if (_isFacultyOnly()) {
        $courses = _getFacultyCourses();
    }
    $form = array();
    $form['#tree'] = TRUE;
    $form['form_markup'] = array(
        '#markup' => '<div class="white-box">'
    );
    foreach ($uploaded_qb as $key => $qb) {
        if (_isFacultyOnly()) {
            $current_sub = decode_entities(_format_string($qb[0]));
            $index = array_search($current_sub, array_column($courses, 'course_code'));
            if ($index === false)
                continue;
        }
        $form['question_fieldset'][$key] = array(
            '#type' => 'container',
            '#tree' => true,
            '#prefix' => '<div class="row question-box">',
            '#suffix' => '</div>'
        );
        if (!empty($qb[8])) {
            $form['question_fieldset'][$key]['id'] = array(
                '#type' => 'hidden',
                '#multiple' => true,
                '#value' => decode_entities(_format_string($qb[8])),
            );
        }
        $form['question_fieldset'][$key]['question'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 255, 'size' => '100%'),
            '#default_value' => decode_entities(_format_string($qb[2])),
            '#title' => 'Question',
            '#prefix' => '<div class="col-md-12">',
            '#suffix' => '</div>'
        );
        $form['question_fieldset'][$key]['answerMarkUp'] = array(
            '#markup' => '<h4 style="padding-left:6px; font-weight: bold">Answers</h4>'
        );
        $form['question_fieldset'][$key]['answer1'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 255, 'size' => '100%'),
            '#theme_wrappers' => array(),
            '#default_value' => decode_entities(_format_string($qb[3])),
            '#title' => 'Answer 1',
            '#prefix' => '<div class="col-md-12">',
            '#suffix' => '</div>'
        );
        $form['question_fieldset'][$key]['answer2'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 255, 'size' => '100%'),
            '#theme_wrappers' => array(),
            '#default_value' => decode_entities(_format_string($qb[4])),
            '#title' => 'Answer 2',
            '#prefix' => '<div class="col-md-12">',
            '#suffix' => '</div>'
        );
        $form['question_fieldset'][$key]['answer3'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 255, 'size' => '100%'),
            '#theme_wrappers' => array(),
            '#default_value' => decode_entities(_format_string($qb[5])),
            '#title' => 'Answer 3',
            '#prefix' => '<div class="col-md-12">',
            '#suffix' => '</div>'
        );
        $form['question_fieldset'][$key]['answer4'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 255, 'size' => '100%'),
            '#theme_wrappers' => array(),
            '#default_value' => decode_entities(_format_string($qb[6])),
            '#title' => 'Answer 4',
            '#prefix' => '<div class="col-md-12">',
            '#suffix' => '</div>'
        );
        $form['question_fieldset'][$key]['sub_code'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 60, 'size' => 20),
            '#default_value' => decode_entities(_format_string($qb[0])),
            '#title' => 'Subject Code',
            '#prefix' => '<div class="col-md-4">',
            '#suffix' => '</div>'
        );
        $form['question_fieldset'][$key]['module_no'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 60, 'size' => 20),
            '#default_value' => decode_entities(_format_string($qb[1])),
            '#title' => 'Module Number',
            '#prefix' => '<div class="col-md-4">',
            '#suffix' => '</div>'
        );
        $form['question_fieldset'][$key]['right_answer'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#attributes' => array('maxlength' => 60, 'size' => 20),
            '#default_value' => decode_entities(_format_string($qb[7])),
            '#title' => 'Correct Answer',
            '#prefix' => '<div class="col-md-4">',
            '#suffix' => '</div>'
        );
    }
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save'),
    );
    $form['form_markup_end'] = array(
        '#markup' => '</div>'
    );
    return $form;
}

function qb_entry_form_submit($form, &$form_state) {
    $submitted_values = $form_state['values'];
    $mccdb = new MCCdb();
    $courses = array();
    if (_isFacultyOnly()) {
        $courses = _getFacultyCourses();
    }

    if (!empty($submitted_values['question_fieldset'])) {
        $questions = $submitted_values['question_fieldset'];
        foreach ($questions as $question) {
            $answers = array();
            $answers[1] = check_plain($question['answer1']);
            $answers[2] = check_plain($question['answer2']);
            $answers[3] = check_plain($question['answer3']);
            $answers[4] = check_plain($question['answer4']);
            $question['answers'] = serialize($answers);
//            pretty_print($question);
            if (_isFacultyOnly()) {
                $current_sub = $question['sub_code'];
                $index = array_search($current_sub, array_column($courses, 'course_code'));
                if ($index === false)
                    continue;
            }
            $mccdb->setQuestion($question);
        }
    }
    if (isset($_SESSION['uploaded_qb']))
        unset($_SESSION['uploaded_qb']);
    drupal_set_message('Saved Successfully.');
    drupal_goto('syllabus/upload-qb');
}

function mcc_common_uploaded_qb_edit($id) {
    $mccdb = new MCCdb();
    $question = $mccdb->getQuestionById($id);
    if (empty($question)) {
        drupal_set_message('Question Not Found', 'error');
        drupal_goto('syllabus/upload-qb');
    }
    $vars['entry_form'] = drupal_get_form('qb_entry_form', $question);
    return theme('syllabus_entry_form_template', $vars);
}

function mcc_common_uploaded_qb_delete($id) {
    $mccdb = new MCCdb();
    $mccdb->delQuestionById($id);
    drupal_set_message('Deleted Successfully.');
    drupal_goto('syllabus/upload-qb');
}

function mcc_common_exam($sub_code, $ajax) {
    $mccdb = new MCCdb();
    $q_limit = $mccdb::MCC_QB_NUMBER_OF_QUESTION;
    $params = arg();
    $sub_module = NULL;
    if(!empty($params[4])) {
        $sub_module = $params[4];
    }
    if ($ajax) {
        ctools_include('ajax');
        ctools_include('modal');
        $questions = $mccdb->getQuestions($sub_code, TRUE, $q_limit, array(), $sub_module);
        $form_state = array(
            'ajax' => TRUE,
            'title' => $sub_code . ' Exam',
            'questions' => $questions,
            'course_code' => $sub_code,
            'module' => $sub_module,
        );
        $output = ctools_modal_form_wrapper('exam_form', $form_state);

        if (!empty($form_state['ajax_commands'])) {
            $output = $form_state['ajax_commands'];
        }

        print ajax_render($output);
        drupal_exit();
    }
}

function exam_form($form, &$form_state) {
    $form = array();
    $form['questions']['#tree'] = true;
    foreach ($form_state['questions'] as $question) {
        $options = array();
        $options = $question['answers'];
        $form['questions'][$question['id']] = array(
            '#title' => $question['question'],
            '#type' => 'radios',
            '#options' => $options,
        );
    }
    $form['module'] = array(
        '#type' => 'hidden',
        '#value' => $form_state['module']
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => 'Submit Your Answer'
    );
    return $form;
}

function exam_form_submit($form, &$form_state) {
    global $user;
    $submmitted_values = $form_state['values'];
    $answer_matched = 0;
    if (!empty($submmitted_values['questions'])) {
        $total_question = 0;
        $total_question = count($submmitted_values['questions']);
        foreach ($submmitted_values['questions'] as $key => $val) {
            if (!empty($form_state['questions'][$key]['right_answer'])) {
                if ($val == $form_state['questions'][$key]['right_answer'])
                    $answer_matched++;
            }
        }
        $percentage = 0;
        $percentage = floatval(($answer_matched / $total_question) * 100);
    }
    $data = array();
    $data['user_id'] = $user->uid;
    $data['score'] = $percentage;
    $data['course_code'] = $form_state['course_code'];
    $data['module'] = $form_state['module'];
    $months_mapping = _session_to_months_mapping();
    $current_month = date('F');
    $current_session = '';
    foreach($months_mapping as $key=>$session) {
        if(in_array($current_month, $session)) {
            $current_session = $key;
            break;
        }
    }
    $data['session'] = $current_session;
    $data['year'] = date('Y');
//  watchdog('MCC', $answer_matched);
    $mccdb = new MCCdb();
    $mccdb->setCourseResult($data);
    drupal_set_message('Answer Submitted. Your Score - '.round($percentage,2).'%');
    if (!empty($form_state['ajax'])) {
//        $form_state['ajax_commands'][] = ctools_ajax_command_reload();
        $form_state['ajax_commands'][] = ctools_ajax_command_redirect('/syllabus/my-courses-result');
    }
}
