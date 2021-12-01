<?php

include_once 'mcc.db.class.inc';

function mcc_common_upload_syllabus_by_type() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('upload_form');
    return theme('syllabus_upload_form_template', $vars);
}

function upload_form($form, &$form_state) {
    $syllabus_doc_default = null;
    $form = array();
    $mccDB = new MCCdb();

    $form['syllabus_type'] = array(
        '#type' => 'select',
        '#options' => $mccDB->_get_syllabus_type(),
        '#required' => TRUE,
        '#title' => 'Select Syllabus Type',
    );

    $form['syllabus_docx'] = array(
        '#type' => 'managed_file',
        '#title' => t('Upload Docs - Allowed Extensions: DOCX'),
        '#upload_location' => 'public://mcc_syllabus/',
        '#default_value' => $syllabus_doc_default,
        '#theme' => 'syllabus_pdf_thumb_upload',
        '#progress_indicator' => 'throbber',
        '#progress_message' => 'Uploading ...',
        '#upload_validators' => array(
            'file_validate_extensions' => array('docx'),
            'file_validate_size' => array(5 * 1024 * 1024),
            'file_validate_name' => array()
        )
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );

    return $form;
}

function file_validate_name(stdClass $file) {
    db_query("DELETE FROM {file_managed} WHERE uri = '$file->destination'");
    $file->filename = str_replace('docx', 'zip', $file->filename);
    $file->destination = str_replace('docx', 'zip', $file->destination);
//  pretty_print($file);
    db_query("DELETE FROM {file_managed} WHERE uri = '$file->destination'");
}

function upload_form_submit($form, &$form_state) {
    set_time_limit(0);
    $file_id = $form_state['values']['syllabus_docx'];
    $file = file_load($file_id);
    $file_path = file_create_url($file->uri);
    $sUploadedFile = $file_path;
    $zipFilePath = $GLOBALS['_SERVER']['DOCUMENT_ROOT'] . '/sites/default/files/mcc_syllabus/' . $file->filename;
    $zip = new ZipArchive; // creating object of ZipArchive class.
    $zip->open($zipFilePath);
    $aFileName = explode('.', $file->filename);
    $sDirectoryName = current($aFileName);
    $default_folder = 'public://mcc_syllabus/' . $sDirectoryName;
    if (!is_dir("$default_folder")) {
        file_prepare_directory($default_folder, FILE_CREATE_DIRECTORY);
    }
    $zip->extractTo($default_folder);
    $default_folder = file_create_url($default_folder);
    $reader = new XMLReader();
    $reader->open("$default_folder/word/document.xml");

    $found_heading1 = false;
    $search_heading1 = true;
    $found_heading2 = false;
    $search_heading2 = false;
    $found_heading3 = false;
    $search_heading3 = false;
    $search_listParagraph = false;

    $dept = NULL;
    $heading3 = NULL;
    $sub_i = 0;
    $subj_details = array();
    $subj_details1 = array();

    while ($reader->read()) {
        if ($reader->nodeType == 1) {
            $node = $reader->expand();
            if ($node->localName == 'p') {
                foreach ($node->childNodes as $childNode) {
                    if ('pPr' == $childNode->localName) {
                        foreach ($childNode->childNodes as $grandChildNode) {
                            if ($grandChildNode->localName == 'pStyle') {
                                $pStyleVal = $grandChildNode->attributes->getNamedItem("val")->nodeValue;
                                if ($pStyleVal == 'Heading1' && $search_heading1) {
//                  pretty_print($node->textContent);
                                    $title = strtolower($node->textContent);
                                    if (strpos($title, 'introduction') === false &&
                                        strpos($title, 'appendix') === false &&
                                        strpos($title, 'materials') === false &&
                                        strpos($title, 'ভূমিকা') === false &&
                                        strpos($title, 'পরিশিষ্ট') === false) {
                                        $search_heading1 = false;
                                        $search_heading2 = true;
                                        $search_heading3 = false;
                                        $search_listParagraph = false;

                                        $dept = mb_convert_encoding($node->textContent, "HTML-ENTITIES", "UTF-8");
                                        $dept = ucwords(strtolower(trim(str_replace('SYLLABUS', '', $dept))));
                                        $dept = ucwords(strtolower(trim(str_replace('সিলেবাস', '', $dept))));
                                        $sub_i = 0;
                                    } else {
                                        $search_heading2 = false;
                                        $search_heading3 = false;
                                        $search_listParagraph = false;
                                    }
                                }
                                if ($pStyleVal == 'Heading2' && $search_heading2) {
                                    $search_heading1 = false;
                                    $search_heading2 = false;
                                    $search_heading3 = true;
                                    $search_listParagraph = false;
                                    $sub_i++;
                                    $subject_name_str = mb_convert_encoding($node->textContent, "HTML-ENTITIES", "UTF-8");
                                    $subject_array = explode(':', $subject_name_str);
                                    $codes_array = explode(' ', $subject_array[0]);
                                    $dept_code_suffix = '';
                                    if (trim($form_state['values']['syllabus_type']) == 'bangla') {
                                        $dept_code_suffix = 'b';
                                    }
                                    $subj_details[$dept]['dept_code'] = trim($codes_array[0]) . $dept_code_suffix;
                                    $subj_details[$dept]['syllabus_type'] = trim($form_state['values']['syllabus_type']);
                                    $subj_details[$dept][$sub_i]['name'] = trim($subject_array[1]);
                                    $subj_details[$dept][$sub_i]['code'] = trim($codes_array[1]);
                                }
                                if ($pStyleVal == 'Heading3' && $search_heading3) {
                                    $search_heading1 = false;
                                    $search_heading2 = false;
                                    $search_heading3 = true;
                                    $search_listParagraph = true;
                                    $heading3 = trim($node->textContent);
                                }
                                if ($pStyleVal == 'ListParagraph' && $search_listParagraph) {
                                    $search_heading1 = true;
                                    $search_heading2 = true;
                                    $search_heading3 = true;
                                    $search_listParagraph = true;
                                    if (!empty($heading3)) {
                                        $t1 = utf8_encode($heading3);
//                    echo $heading3.' <=> '.$t1.'<br/>';
                                        // bangla to english array index
                                        // janar bishoygulo
                                        if (strpos($t1, "à¦à¦¾à¦¨à¦¾à¦° à¦¬à¦¿à¦·à§à¦à§à¦²à§") !== false) {
                                            $heading3 = 'Learning Objectives';
                                        }
                                        // course-er bishoybostu
                                        if (strpos($t1, "à¦à§à¦°à§à¦¸à§à¦° à¦¬à¦¿à¦·à§à¦¬à¦¸à§à¦¤à§") !== false) {
                                            $heading3 = 'Course Contents';
                                        }
                                        if (strpos($t1, "Contents") !== false) {
                                            $heading3 = 'Course Contents';
                                        }
                                        // text materials
                                        if (strpos($t1, "à¦à§à¦à§à¦¸à¦ à¦®à§à¦¯à¦¾à¦à§à¦°à¦¿à§à¦¾à¦²") !== false) {
                                            $heading3 = 'Text Materials';
                                        }
                                        // reference materials
                                        if (strpos($t1, "à¦°à§à¦«à¦¾à¦°à§à¦¨à§à¦¸ à¦®à§à¦¯à¦¾à¦à§à¦°à¦¿à§à¦¾à¦²") !== false) {
                                            $heading3 = 'Reference Materials';
                                        }
                                        $subj_details[$dept][$sub_i][$heading3][] = mb_convert_encoding($node->textContent, "HTML-ENTITIES", "UTF-8");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
//  pretty_print($subj_details);
    if (!empty($_SESSION['syllabus_data_by_type']))
        unset($_SESSION['syllabus_data_by_type']);
    $_SESSION['syllabus_data_by_type'] = $subj_details;
    drupal_set_message("Successfully Parsed.");
    $redirect_url = '/syllabus/parse-syllabus-by-type/';
    drupal_goto($redirect_url);
}

function mcc_common_parse_syllabus_by_type() {
    $subj_details = $_SESSION['syllabus_data_by_type'];
    $vars['entry_form'] = drupal_get_form('syllabus_entry_form_auto', $subj_details);
    return theme('syllabus_entry_form_template', $vars);
}

function syllabus_entry_form_auto($form, &$form_state, $input_data) {
//  pretty_print($input_data, 0);
    $form = array();
    $form['#tree'] = TRUE;
    $dept_count = 1;
    foreach ($input_data as $dept_key => $dept_val) {
        $form['dept_fieldset'][$dept_key] = array(
            '#type' => 'container',
            '#prefix' => '<div id="dept-container-wrapper-' . $dept_count . '" class="row syllabus-dept-box">'
            . '<div class="col-md-12"><span class="syllabus-dept-name">Department ' . $dept_count++ . '</span></div>',
            '#suffix' => '</div>',
            '#tree' => true
        );
//    pretty_print(_format_string($dept_key));
        $form['dept_fieldset'][$dept_key]['dept_name'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#default_value' => decode_entities(_format_string($dept_key)),
            '#title' => 'Deparment Name', // . _format_string($dept_key),
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        );
        $form['dept_fieldset'][$dept_key]['syllabus_type'] = array(
            '#type' => 'hidden',
            '#multiple' => true,
            '#value' => decode_entities($dept_val['syllabus_type'])
        );
        $form['dept_fieldset'][$dept_key]['dept_short_code'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#default_value' => decode_entities($dept_val['dept_code']),
            '#title' => 'Deparment Short Code',
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        );
        $subj_count = 1;
        foreach ($dept_val as $key => $subject_details) {
            if (!is_int($key))
                continue;
            $sub_box_class = 'syllabus-sub-box-odd';
            if ($key % 2 == 0)
                $sub_box_class = 'syllabus-sub-box-even';
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key] = array(
                '#type' => 'container',
                '#prefix' => '<div class="subject-container-wrapper-' . $dept_count . '-' . $subj_count . '">'
                . '<div class="col-md-12 ' . $sub_box_class . '"><span>Subject ' . $subj_count . '</span></div>',
                '#suffix' => '</div>',
                '#tree' => true
            );
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_name'] = array(
                '#type' => 'textfield',
                '#multiple' => true,
                '#default_value' => decode_entities(_format_string($subject_details['name'])),
                '#title' => 'Subject Name',
                '#prefix' => '<div class="col-md-6">',
                '#suffix' => '</div>'
            );
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_code'] = array(
                '#type' => 'textfield',
                '#multiple' => true,
                '#default_value' => decode_entities(_format_string($subject_details['code'])),
                '#title' => 'Subject Code',
                '#prefix' => '<div class="col-md-6">',
                '#suffix' => '</div>'
            );
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_lo_mp'] = array(
                '#markup' => '<div class="col-md-12"><div class="syllabus-textarea"><b>Learning Objectives</b></div></div>'
            );
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_lo'] = array(
                '#type' => 'textarea',
                '#theme_wrappers' => array(),
                '#multiple' => true,
                '#default_value' => decode_entities(_format_string(str_replace('<br/>', PHP_EOL, implode('<br/>', $subject_details['Learning Objectives'])))),
                '#title' => 'Subject Learning Objectives',
                '#prefix' => '<div class="col-md-12"><div class="syllabus-textarea">',
                '#suffix' => '</div></div>'
            );
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_cc_mp'] = array(
                '#markup' => '<div class="col-md-12"><div class="syllabus-textarea"><b>Course Content</b></div></div>'
            );
            foreach ($subject_details['Course Contents'] as $cc_key => $cc) {
                $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_cc'][$cc_key] = array(
                    '#type' => 'textarea',
                    '#format' => 'full_html',
                    '#theme_wrappers' => array(),
                    '#multiple' => true,
                    '#default_value' => decode_entities($cc),
                    '#title' => 'Module ' . $cc_key,
                    '#prefix' => '<div class="col-md-12"><div class="syllabus-textarea">',
                    '#suffix' => '</div></div>'
                );
            }
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['text_mp'] = array(
                '#markup' => '<div class="col-md-12"><div class="syllabus-textarea"><b>Text Materials</b></div></div>'
            );
            foreach ($subject_details['Text Materials'] as $text_key => $text_mat) {
                $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['text'][$text_key] = array(
                    '#type' => 'textfield',
                    '#theme_wrappers' => array(),
                    '#multiple' => true,
                    '#default_value' => decode_entities(_format_string($text_mat)),
                    '#size' => 128,
                    '#maxlength' => 255,
                    '#title' => 'Text Material',
                    '#prefix' => '<div class="col-md-12"><div class="syllabus-text-mat">',
                    '#suffix' => '</div></div>'
                );
            }
            $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['ref_mp'] = array(
                '#markup' => '<div class="col-md-12"><div class="syllabus-textarea"><b>Reference Materials</b></div></div>'
            );
            foreach ($subject_details['Reference Materials'] as $ref_key => $ref_mat) {
                $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['ref'][$ref_key] = array(
                    '#type' => 'textfield',
                    '#theme_wrappers' => array(),
                    '#multiple' => true,
                    '#default_value' => decode_entities(_format_string($ref_mat)),
                    '#size' => 128,
                    '#maxlength' => 255,
                    '#title' => 'Reff Material',
                    '#prefix' => '<div class="col-md-12"><div class="syllabus-ref-mat">',
                    '#suffix' => '</div></div>'
                );
            }
            $subj_count++;
        }
    }

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );
    return $form;
}

function syllabus_entry_form_auto_submit($form, &$form_state, $input_data) {
    $url_param = '';
    $lang = '';
    $syllabus_type_submitted = '';

    $submitted_data = $form_state['values']['dept_fieldset'];
//  pretty_print($submitted_data);
    foreach ($submitted_data as $key => $value) {
        if (!empty($value['syllabus_type'])) {
            $syllabus_type_submitted = $value['syllabus_type'];
            break;
        }
    }
    if (empty($syllabus_type_submitted))
        drupal_goto(404);

    $mccdb = new MCCdb();
    $mccdb->deleteMaterialsBySyllabusType($syllabus_type_submitted);
    $mccdb->deleteModulesMaterialsBySyllabusType($syllabus_type_submitted);
    $mccdb->deleteModulesBySyllabusType($syllabus_type_submitted);
    $mccdb->deleteSubjsBySyllabusType($syllabus_type_submitted);
    $mccdb->deleteDeptsBySyllabusType($syllabus_type_submitted);

    foreach ($submitted_data as $key => $value) {
        $dept_name = addslashes($value['dept_name']);
        $dept_shortcode = $value['dept_short_code'];
        $syllabus_type = $value['syllabus_type'];
        $dept = $mccdb->getDeparmentByNameCodeSyllabusType($dept_name, $dept_shortcode, $syllabus_type, 'OR');
        $dept_array = array();
        $dept_array['name'] = $dept_name;
        $dept_array['shortcode'] = $dept_shortcode;
        $dept_array['syllabus_type'] = $syllabus_type;
        if (!empty($dept)) {
            $dept = array_pop($dept);
            $dept_array['id'] = $dept->id;
        }
        $dept_id = $mccdb->setDepartmentSyllabusType($dept_array);
        if (empty($dept_id))
            continue;
        foreach ($value as $dept_key => $dept_val) {
            if (is_array($dept_val)) {
                foreach ($dept_val as $sub_key => $sub_val) {
                    //pretty_print($sub_val);
                    $subj_array = array();
                    $subj_array['name'] = addslashes($sub_val['subject_name']);
                    $subj_array['code'] = $sub_val['subject_code'];
                    $subj_array['syllabus_type'] = $syllabus_type;
                    $subj_array['dept_id'] = $dept_id;
                    $subj_array['learning_objectives'] = (addslashes($sub_val['subject_lo']));

                    $subj = $mccdb->getSubjectByNameCodeSyllabusType($subj_array['name'], $subj_array['code'], 'AND', $dept_id);
                    if (!empty($subj)) {
                        $subj = array_pop($subj);
                        $subj_array['id'] = $subj->id;
                    }
                    $subj_id = $mccdb->setSubjectSyllabusType($subj_array);
                    if (empty($subj_id))
                        continue;
                    if (is_array($sub_val['subject_cc'])) {
                        foreach ($sub_val['subject_cc'] as $cc_key => $cc_val) {
                            if (!empty($cc_val)) {
                                $text_array = array();
                                $text_array['name'] = 'Module ' . ($cc_key + 1);
                                $text_array['sub_id'] = $subj_id;
                                $text_array['module_details'] = $cc_val;
                                $text_array['syllabus_type'] = $syllabus_type;
//                pretty_print($text_array);
                                $mccdb->setModulesSyllabusType($text_array);
                            }
                        }
                    }
                    if (is_array($sub_val['text'])) {
                        foreach ($sub_val['text'] as $text_key => $text_val) {
                            if (!empty($text_val)) {
                                $text_array = array();
                                $text_array['name'] = addslashes($text_val);
                                $text_array['sub_id'] = $subj_id;
                                $text_array['text_or_ref'] = 'text';
                                $text_array['serial'] = $text_key;
                                $text_array['syllabus_type'] = $syllabus_type;
                                $text = $mccdb->getMaterialsByNameSujectSyllabusType($text_array['name'], $text_array['sub_id']);
                                if (!empty($text)) {
                                    $text = array_pop($text);
                                    $text_array['id'] = $text->id;
                                }
                                $mccdb->setMaterialsSyllabusType($text_array);
                            }
                        }
                    }
                    if (is_array($sub_val['ref'])) {
                        foreach ($sub_val['ref'] as $ref_key => $ref_val) {
                            if (!empty($ref_val)) {
                                $ref_array = array();
                                $ref_array['name'] = addslashes($ref_val);
                                $ref_array['sub_id'] = $subj_id;
                                $ref_array['text_or_ref'] = 'ref';
                                $ref_array['serial'] = $ref_key;
                                $ref_array['syllabus_type'] = $syllabus_type;
                                $ref = $mccdb->getMaterialsByNameSujectSyllabusType($ref_array['name'], $ref_array['sub_id']);
                                if (!empty($ref)) {
                                    $ref = array_pop($ref);
                                    $ref_array['id'] = $ref->id;
                                }
                                $mccdb->setMaterialsSyllabusType($ref_array);
                            }
                        }
                    }
                }
            }
        }
    }
    drupal_goto('/syllabus/academic-syllabus-by-type/' . $syllabus_type_submitted);
}

function mcc_common_syllabus_by_type($syllabus_type) {
    $url_param = '';
    global $user;
    if (empty($user->uid))
        drupal_goto(404);
    $vars['edit_permission'] = false;
//    if ($syllabus_type == 'general' && !user_access('inspect syllabus')) {
//        drupal_goto(404);
//    }
    if (user_access('create syllabus')) {
        $vars['edit_permission'] = true;
    }
    $mccdb = new MCCdb();
    drupal_set_title(ucwords(str_replace('_', ' ', $syllabus_type)) . ' Syllabus');
    $academic_syllabus = $mccdb->getDepartmentsSyllabusType($syllabus_type);
//  pretty_print($academic_syllabus);
    $vars['academic_syllabus'] = $academic_syllabus;
    return theme('syllabus_by_type_list_template', $vars);
}

function mcc_common_syllabus_brief_by_type($syllabus_type) {
    $url_param = '';
    global $user;
    if (empty($user->uid))
        drupal_goto(404);
//    if ($syllabus_type == 'general' && !user_access('inspect syllabus')) {
//        drupal_goto(404);
//    }
    $mccdb = new MCCdb();
    $academic_syllabus = $mccdb->getDepartmentsSyllabusType($syllabus_type);
    $syllabus_types = $mccdb->_get_syllabus_type();
    if (!empty($syllabus_types[$syllabus_type])) {
        drupal_set_title('Introduction to ' . $syllabus_types[$syllabus_type]);
    }
    $vars['academic_syllabus'] = $academic_syllabus;
    return theme('syllabus_by_type_brief_list_template', $vars);
}

function mcc_common_subject_details_by_syllabus_type($sub_id) {
    ctools_include('modal');
    ctools_modal_add_js();
    _add_pdf_js();
    global $user;
    if (empty($user->uid))
        drupal_goto(404);
    $mccdb = new MCCdb();
    $sub_details = $mccdb->getSubjectByIdSyllabusType($sub_id, 2);
    $modules_array = $mccdb->getModulesBySubjSyllabusType($sub_id);
//    pretty_print($modules_array);
    if (!empty($sub_details)) {
        $sub_details = array_pop($sub_details);
        $is_allowed_to_access_books = true;
        if ($sub_details['subject']['syllabus_type'] == 'general') {
            $is_allowed_to_access_books = false;
            if (user_access('inspect syllabus'))
                $is_allowed_to_access_books = true;
        }
        $vars['is_allowed_to_access_books'] = $is_allowed_to_access_books;
        $sub_full_code = '';
        $sub_materials_folder = $sub_details['subject']['dept_code'] . '-' . $sub_details['subject']['code'];
        $audio_video_materials_folder = str_replace('b-', '-', $sub_materials_folder);
        $mainPath = $mccdb::MCC_EDU_AUDIO_VIDEO_URI_SYLLABUS_TYPE . '/' . $audio_video_materials_folder . '/';
        $uploaed_audio_video = $mccdb->getFilesByURI($mainPath . '%');
        $vars['uploaed_audio_video'] = $uploaed_audio_video;
        $mainTextMatPath = $mccdb::MCC_EDU_MATERIALS_URI_SYLLABUS_TYPE . '/' . $sub_materials_folder . '/text/';
        $uploaded_text = $mccdb->getFilesByURI($mainTextMatPath . '%');
        $vars['uploaded_text'] = $uploaded_text;
        $mainRefMatPath = $mccdb::MCC_EDU_MATERIALS_URI_SYLLABUS_TYPE . '/' . $sub_materials_folder . '/ref/';
        $uploaded_ref = $mccdb->getFilesByURI($mainRefMatPath . '%');
        $vars['uploaded_ref'] = $uploaded_ref;
        $vars['dept'] = '';
        $vars['module_materials'] = $mccdb->getModulesMaterialsBySubjSyllabusType($sub_materials_folder);
//    echo $sub_materials_folder;
//    pretty_print($vars['module_materials']);
        if (!empty($sub_details['subject']['code']) && !empty($sub_details['subject']['dept_code'])) {
            $sub_full_code = $sub_details['subject']['dept_code'] . '-' . $sub_details['subject']['code'];
            if (!empty($sub_full_code)) {
                $vars['subject_questions'] = $mccdb->getQuestions($sub_full_code);
                $vars['course_result'] = $mccdb->getCourseResult($user->uid, $sub_full_code);
//        pretty_print($vars['subject_questions']);
                ctools_include('modal');
                ctools_modal_add_js();
                $vars['subject_has_questions'] = $mccdb->checkIfSubjectHasQuestionBank($sub_full_code);
                $vars['sub_full_code'] = $sub_full_code;
                $vars['active_modules'] = $mccdb->getModuleActiveInactive($sub_full_code);
            }
        }
        if (!empty($sub_details['subject']['dept_code'])) {
            $dept = $mccdb->getDeparmentByNameCodeSyllabusType(NULL, trim($sub_details['subject']['dept_code']), $sub_details['subject']['syllabus_type']);
            if (!empty($dept))
                $vars['dept'] = array_pop($dept);
        }
        drupal_set_title($sub_details['subject']['code'] . ' ' . $sub_details['subject']['name']);
        $mccdb->getModulesMaterialsBySubjSyllabusType($sub_materials_folder);
    }
    $vars['sub_details'] = $sub_details;
    $vars['module_count'] = count($modules_array);
    $vars['module_active_inactive_form'] = drupal_get_form('module_active_inactive_form', count($modules_array), $sub_full_code, $sub_id);
//  $vars['lang'] = $url_param;
    return theme('syllabus_by_type_subject_details_template', $vars);
}

function module_active_inactive_form($form, &$form_state, $total_module, $course_code, $sub_id) {
    $form = array();
    $form['modules']['#tree'] = true;
    $mccdb = new MCCdb();
    $saved = $mccdb->getModuleActiveInactive($course_code);
//    pretty_print($saved, 0);
    for ($m_count = 1; $m_count <= $total_module; $m_count++) {
        $options = array();
        $options = $question['answers'];
        $form['modules'][$m_count]['module'] = array(
            '#title' => 'Module ' . $m_count,
            '#type' => 'checkbox',
            '#default_value' => !empty($saved[$m_count])?1:0
        );
        $class_date_default = !empty($saved[$m_count]['active_date'])?format_date($saved[$m_count]['active_date'], 'custom', 'Y-m-d'):format_date(REQUEST_TIME, 'custom', 'Y-m-d');
        $form['modules'][$m_count]['active_date'] = array(
            '#type' => 'date_select',
            '#title' => t(''),
            '#date_format' => 'Y-m-d',
            '#default_value' => $class_date_default,
            '#value' => $class_date_default,
            '#date_year_range' => '0:+1',
            '#date_type' => DATE_FORMAT_DATE,
            '#date_timezone' => date_default_timezone(),
            '#date_increment' => 1,
        );
    }
    $form['course_code'] = array(
        '#type' => 'hidden',
        '#value' => $course_code
    );
    $form['sub_id'] = array(
        '#type' => 'hidden',
        '#value' => $sub_id
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => 'Set'
    );
    return $form;
}

function module_active_inactive_form_submit($form, &$form_state) {
    $submitted_data = $form_state['values'];
    
    $mccdb = new MCCdb();
    if (!empty($submitted_data['modules'])) {
        $mccdb->delModuleActiveInactive($submitted_data['course_code']);
        foreach ($submitted_data['modules'] as $key => $val) {
            if (!empty($val['module'])) {
                $data = array();
                $data['course_code'] = $submitted_data['course_code'];
                $data['module'] = $key;
                $data['active_date'] = strtotime($val['active_date']['year'].'-'.$val['active_date']['month'].'-'.$val['active_date']['day'].' 00:01:00');
//                pretty_print($data,0);
                $id = $mccdb->setModuleActiveInactive($data);
                if(!empty($id)) {
                    drupal_set_message('Module Active/ Inactive Saved Properly.', 'status', FALSE);
                }
            }
        }
    }
//    pretty_print($submitted_data);
}

function mcc_common_edit_department_by_type($dept_id) {
    global $user;
    if (empty($user->uid))
        drupal_goto(404);
    $mccdb = new MCCdb();
    $department_details = $mccdb->getDeparmentByIdSyllabusType($dept_id, 3);

    $vars['entry_form'] = drupal_get_form('syllabus_entry_form_edit', $department_details);
    return theme('syllabus_entry_form_template', $vars);
}

function syllabus_entry_form_edit($form, &$form_state, $input_data) {
//  pretty_print($input_data);
    $form = array();
    $form['#tree'] = TRUE;
    $form['dept_fieldset'] = array(
        '#type' => 'container',
        '#prefix' => '<div id="dept-container-wrapper-1" class="row syllabus-dept-box">'
        . '<div class="col-md-12"><span class="syllabus-dept-name">Update ' . $input_data['name'] . '</span></div>',
        '#suffix' => '</div>',
        '#tree' => true
    );
    $form['dept_fieldset']['dept_name'] = array(
        '#type' => 'textfield',
        '#default_value' => $input_data['name'],
        '#title' => 'Deparment Name',
        '#description' => 'If you want to delete this Deparment from the system, leave '
        . 'this field blank. All the subjects and materials associated with this department '
        . 'will be deleted',
        '#prefix' => '<div class="col-md-6">',
        '#suffix' => '</div>'
    );
    $form['dept_fieldset']['dept_id'] = array(
        '#type' => 'hidden',
        '#default_value' => $input_data['id'],
    );
    $form['dept_fieldset']['syllabus_type'] = array(
        '#type' => 'hidden',
        '#default_value' => $input_data['syllabus_type'],
    );
    $form['dept_fieldset']['dept_short_code'] = array(
        '#type' => 'textfield',
        '#default_value' => $input_data['code'],
        '#title' => 'Deparment Short Code',
        '#prefix' => '<div class="col-md-6">',
        '#suffix' => '</div>'
    );
    $subj_count = 1;
    foreach ($input_data['subjects'] as $key => $subject_details) {
        //pretty_print($subject_details);
        if (!is_int($key))
            continue;
        $sub_box_class = 'syllabus-sub-box-odd';
        if ($key % 2 == 0)
            $sub_box_class = 'syllabus-sub-box-even';
        $form['dept_fieldset']['subj_fieldset'][$key] = array(
            '#type' => 'container',
            '#prefix' => '<div class="subject-container-wrapper-1">'
            . '<div class="col-md-12 ' . $sub_box_class . '"><span>Subject ' . $subj_count . '</span></div>',
            '#suffix' => '</div>',
            '#tree' => true
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['subject_id'] = array(
            '#type' => 'hidden',
            '#default_value' => $subject_details['subject']['id'],
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['syllabus_type'] = array(
            '#type' => 'hidden',
            '#default_value' => $subject_details['subject']['syllabus_type'],
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['subject_name'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#default_value' => $subject_details['subject']['name'],
            '#title' => 'Subject Name',
            '#description' => 'If you want to delete this Subject from the system, leave '
            . 'this field blank. All the materials associated with this subject '
            . 'will be deleted',
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['subject_code'] = array(
            '#type' => 'textfield',
            '#multiple' => true,
            '#default_value' => $subject_details['subject']['code'],
            '#title' => 'Subject Code',
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['subject_lo_mp'] = array(
            '#markup' => '<div class="col-md-12"><div class="syllabus-textarea"><b>Learning Objectives</b></div></div>'
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['subject_lo'] = array(
            '#type' => 'textarea',
            '#multiple' => true,
            '#default_value' => strip_tags(_format_string($subject_details['subject']['learning_objectives'])),
            '#title' => 'Subject Learning Objectives',
            '#prefix' => '<div class="col-md-12"><div class="syllabus-textarea">',
            '#suffix' => '</div></div>'
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['subject_lo_details'] = array(
            '#type' => 'textarea',
            '#multiple' => true,
            '#default_value' => strip_tags(_format_string($subject_details['subject']['learning_objectives_details'])),
            '#title' => 'Subject Learning Objectives Details',
            '#prefix' => '<div class="col-md-12"><div class="syllabus-textarea">',
            '#suffix' => '</div></div>'
        );
        $form['dept_fieldset']['subj_fieldset'][$key]['subject_cc_mp'] = array(
            '#markup' => '<div class="col-md-12"><div class="syllabus-textarea"><b>Course Content</b></div></div>'
        );
        foreach ($subject_details['subject']['course_contents'] as $cc_key => $cc) {
            $form['dept_fieldset']['subj_fieldset'][$key]['course_contents'][$cc['module']['id']] = array(
                '#type' => 'textarea',
                '#format' => 'full_html',
                '#multiple' => true,
                '#default_value' => strip_tags(_format_string($cc['module']['module_details'])),
                '#title' => $cc['module']['name'],
                '#prefix' => '<div class="col-md-12"><div class="syllabus-textarea">',
                '#suffix' => '</div></div>'
            );
        }
        $form['dept_fieldset']['subj_fieldset'][$key]['text_mp'] = array(
            '#markup' => '<div class="col-md-12"><div class="syllabus-textarea">'
            . '<b>Text Materials</b> (To delete any text, simply leave the field blank)</div></div>'
        );
        foreach ($subject_details['subject']['text'] as $text_key => $text_mat) {
            $form['dept_fieldset']['subj_fieldset'][$key]['text'][$text_mat['material']['id']] = array(
                '#type' => 'textfield',
                '#multiple' => true,
                '#default_value' => $text_mat['material']['name'],
                '#size' => 128,
                '#maxlength' => 255,
                '#description' => 'To delete this text material, simply leave the field blank',
                '#prefix' => '<div class="col-md-12"><div class="syllabus-text-mat">',
                '#suffix' => '</div></div>'
            );
        }
        $form['dept_fieldset']['subj_fieldset'][$key]['ref_mp'] = array(
            '#markup' => '<div class="col-md-12"><div class="syllabus-textarea">'
            . '<b>Reference Materials</b> (To delete any refernece, simply leave the field blank)</div></div>'
        );
        foreach ($subject_details['subject']['ref'] as $ref_key => $ref_mat) {
            $form['dept_fieldset']['subj_fieldset'][$key]['ref'][$ref_mat['material']['id']] = array(
                '#type' => 'textfield',
                '#multiple' => true,
                '#default_value' => $ref_mat['material']['name'],
                '#size' => 128,
                '#maxlength' => 255,
                '#description' => 'To delete this refernece, simply leave the field blank',
                '#prefix' => '<div class="col-md-12"><div class="syllabus-ref-mat">',
                '#suffix' => '</div></div>'
            );
        }
        $subj_count++;
    }

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );
    return $form;
}

function syllabus_entry_form_edit_submit($form, &$form_state) {
    //pretty_print($form_state['values']);
    $submitted_data = $form_state['values']['dept_fieldset'];
//  pretty_print($submitted_data);
    $mccdb = new MCCdb();
    $dept_array = array();
    $dept_array['name'] = addslashes(trim($submitted_data['dept_name']));
    $dept_array['shortcode'] = $submitted_data['dept_short_code'];
    $dept_array['id'] = $submitted_data['dept_id'];
    $dept_array['syllabus_type'] = $submitted_data['syllabus_type'];
    $delSubs = false;
    if (empty($dept_array['name'])) {
        $mccdb->delDeptByIdSyllabusType($dept_array['id'], $lang);
        $delSubs = true;
    } else {
        $dept_id = $mccdb->setDepartmentSyllabusType($dept_array);
    }
    if (!empty($dept_id) || $delSubs) {
        foreach ($submitted_data['subj_fieldset'] as $key => $value) {
            $delMats = false;
            $delMods = false;
            $subj_array = array();
            $subj_array['name'] = addslashes(trim($value['subject_name']));

            if (empty($subj_array['name']) || $delSubs) {
                $mccdb->delSubjectByIdSyllabusType($value['subject_id'], $lang);
                $delMats = true;
                $delMods = true;
            } else {
                $subj_array['code'] = trim($value['subject_code']);
                $subj_array['syllabus_type'] = trim($value['syllabus_type']);
                $subj_array['dept_id'] = $dept_id;
                $subj_array['learning_objectives'] = addslashes($value['subject_lo']);
                $subj_array['learning_objectives_details'] = addslashes($value['subject_lo_details']);
                $subj_array['id'] = $value['subject_id'];
                $subj_id = $mccdb->setSubjectSyllabusType($subj_array);
            }
            //pretty_print($subj_array, 0);      
            if (is_array($value['course_contents'])) {
                $cc_count = 0;
                foreach ($value['course_contents'] as $cc_key => $cc_val) {
                    $text_array = array();
                    $text_array['module_details'] = (trim($cc_val));
                    $text_array['id'] = $cc_key;
                    if (!empty($text_array['id'])) {
                        if (empty($text_array['module_details']) || $delMods) {
                            $mccdb->delModuleByIdSyllabusType($id, $lang);
                        } else {
                            //$text_array['name'] = 'Module ' . ($cc_count+1);
                            $text_array['sub_id'] = $subj_id;
                            $mccdb->setModulesSyllabusType($text_array);
                        }
                    }
                }
            }
            if (is_array($value['text'])) {
                $text_count = 1;
                foreach ($value['text'] as $text_key => $text_val) {
                    $text_array = array();
                    $text_array['name'] = addslashes(trim($text_val));
                    $text_array['id'] = $text_key;
                    if (!empty($text_array['id'])) {
                        if (empty($text_array['name']) || $delMats) {
                            $mccdb->delMaterialByIdSyllabusType($text_key);
                        } else {
                            $text_array['sub_id'] = $subj_id;
                            $text_array['text_or_ref'] = 'text';
                            $text_array['serial'] = $text_count++;
                            $mccdb->setMaterialsSyllabusType($text_array);
                        }
                    }
                }
            }
            if (is_array($value['ref'])) {
                $text_count = 1;
                foreach ($value['ref'] as $text_key => $text_val) {
                    $text_array = array();
                    $text_array['name'] = addslashes(trim($text_val));
                    $text_array['id'] = $text_key;
                    if (!empty($text_array['id'])) {
                        if (empty($text_array['name']) || $delMats) {
                            $mccdb->delMaterialByIdSyllabusType($text_key);
                        } else {
                            $text_array['sub_id'] = $subj_id;
                            $text_array['text_or_ref'] = 'ref';
                            $text_array['serial'] = $text_count++;
                            $mccdb->setMaterialsSyllabusType($text_array);
                        }
                    }
                }
            }
        }
    }
    drupal_set_message('Updated Successfully');
}

function mcc_common_upload_module_materials() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }

    $vars['instruction'] = 'Upload Module\'s Materials';
    $vars['upload_form'] = drupal_get_form('module_content_upload_form');
    return theme('syllabus_upload_form_template', $vars);
}

function module_content_upload_form($form, &$form_state) {
    _add_datatable_resources();
    $form = array();
    $mccdb = new MCCdb();
    global $base_url;
    $mainPath = $mccdb::MCC_EDU_MODULE_MATERIALS_URI_SYLLABUS_TYPE;
    $uploaed_materials = $mccdb->getFilesByURI($mainPath . '%');
    $vars['uploaed_materials'] = $uploaed_materials;
    $vars['module_content'] = true;
    $vars['remove_materials_url'] = '/syllabus/remove-module-content/';
    $form['syllabus_type'] = array(
        '#type' => 'select',
        '#options' => $mccdb->_get_syllabus_type(),
        '#required' => TRUE,
        '#title' => 'Select Syllabus Type',
        '#ajax' => array(
            'callback' => 'get_subjects_by_syllabus_type',
            'wrapper' => 'subjects_by_syllabus_type',
        ),
    );
    $subjects_codes = array();
    if (isset($form_state['values']['syllabus_type'])) {
        $syllabus_type = $form_state['values']['syllabus_type'];
        $dept_array = $mccdb->getDepartmentsSyllabusType($syllabus_type);
        if (!empty($dept_array['deparments'])) {
            foreach ($dept_array['deparments'] as $depts) {
                if (!empty($depts['department']['subjects'])) {
                    foreach ($depts['department']['subjects'] as $subjs) {
                        $subjects_codes[$subjs['subject']['id'] . '#' . $depts['department']['code'] . '-' . $subjs['subject']['code']] = $depts['department']['code'] . '-' . $subjs['subject']['code'];
                    }
                }
            }
        }
    }
    $form['subject'] = array(
        '#type' => 'select',
        '#options' => $subjects_codes,
        '#required' => TRUE,
        '#title' => 'Select Subject',
        '#prefix' => '<div id="subjects_by_syllabus_type">',
        '#suffix' => '</div>',
        '#ajax' => array(
            'callback' => 'get_subject_modules',
            'wrapper' => 'replace_modules_div',
        ),
    );
    $modules = array();
    if (isset($form_state['values']['subject'])) {
        $sub_details = $form_state['values']['subject'];
        $sub_details = explode('#', $sub_details);
        $sub_id = $sub_details[0];
        $modules_array = $mccdb->getModulesBySubjSyllabusType($sub_id);
        $count = 1;
        foreach ($modules_array as $key => $val) {
            $val = array_pop($val);
            $modules[$count++] = $val['name'];
        }
    }
    $form['module'] = array(
        '#type' => 'select',
        '#options' => $modules,
        '#required' => TRUE,
        '#title' => 'Module',
        '#prefix' => '<div id="replace_modules_div">',
        '#suffix' => '</div>'
    );

    $form['module_materials'] = array(
        '#type' => 'plupload',
        '#title' => t('Upload Module Materials.'),
        '#description' => t(''),
        '#upload_validators' => array(
            'file_validate_extensions' => array('doc docx pdf ppt pptx'),
        ),
        '#plupload_settings' => array(
            'runtimes' => 'html5',
            'chunk_size' => '1mb',
        ),
    );

    $form['syllabus_module_materials_submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );

    $form['uploaded_materials'] = array(
        '#markup' => '<div id="uploaded_module_materials_div">' . theme('list_materials_display_template', $vars) . '</div>',
    );

    return $form;
}

function get_subjects_by_syllabus_type($form, $form_state) {
    $form_state['rebuild'] = TRUE;
    return $form['subject'];
}

function get_subject_modules($form, $form_state) {
    $form_state['rebuild'] = TRUE;
    return $form['module'];
}

function module_content_upload_form_submit($form, &$form_state) {
//  pretty_print($form_state['values']);
    $data = array();
    $sub_details = $form_state['values']['subject'];
    $sub_details = explode('#', $sub_details);
    $sub_code = $sub_details[1];
    $mccdb = new MCCdb();

    $scheme = $mccdb::MCC_EDU_MODULE_MATERIALS_URI_SYLLABUS_TYPE . '/';
    file_prepare_directory($scheme, FILE_CREATE_DIRECTORY);
    $submitted_files = $form_state['values']['module_materials'];
    foreach ($submitted_files as $file_key => $file_value) {
        $source = $file_value['tmppath'];
        $destination = file_stream_wrapper_uri_normalize($scheme . $file_value['name']);
        // Rename it to its original name, and put it in its final home.
        // Note - not using file_move here because if we call file_get_mime
        // (in file_uri_to_object) while it has a .tmp extension, it horks.
        $destination = file_unmanaged_move($source, $destination, FILE_EXISTS_RENAME);
        $file = plupload_file_uri_to_object($destination);
        file_save($file);
        if (!empty($file->fid)) {
            $data['file_id'] = $file->fid;
        }
        $data['module_no'] = $form_state['values']['module'];
        $data['sub_code'] = $sub_code;
        $data['syllabus_type'] = $form_state['values']['syllabus_type'];
        $mccdb->setModulesMaterialSyllabusType($data);
        drupal_set_message($file_value['name'] . ' uploaded successfully.');
    }
}

function mcc_common_remove_module_content() {
    $file_id = arg(2);
    $file = file_load($file_id);
    $status = file_delete($file);
    $mccdb = new MCCdb();
    $mccdb->delModuleMaterialByFIdSyllabusType($file_id);
    if ($status) {
        drupal_set_message('Removed Successfully');
    }
    drupal_goto('/syllabus/upload-modules-materials');
}

function mcc_common_upload_materials() {
//  ini_set('memory_limit', '256M');
//  ini_set('upload_max_filesize', '128M');
//  ini_set('post_max_size', '128M');
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['instruction'] = 'Upload Materials (PDF, DOC, DOCX, PPT, PPTX)';
    $vars['upload_form'] = drupal_get_form('materials_upload_form');
    return theme('syllabus_upload_form_template', $vars);
}

function materials_upload_form($form, &$form_state) {
    _add_datatable_resources();
    $form = array();
    $mccdb = new MCCdb();
    global $base_url;
    $mainPath = $mccdb::MCC_EDU_MATERIALS_URI_SYLLABUS_TYPE;
    $uploaed_materials = $mccdb->getFilesByURI($mainPath . '%');
    $vars['uploaed_materials'] = $uploaed_materials;
    $vars['text_ref_materials'] = true;
    $vars['remove_materials_url'] = '/syllabus/remove-material/';
    $form['syllabus_type'] = array(
        '#type' => 'select',
        '#options' => $mccdb->_get_syllabus_type(),
        '#required' => TRUE,
        '#title' => 'Select Syllabus Type',
        '#ajax' => array(
            'callback' => 'get_materials_folder_by_syllabus_type',
            'wrapper' => 'subjects_by_syllabus_type',
        ),
    );
    $subjects_codes = array();
    if (isset($form_state['values']['syllabus_type'])) {
        $syllabus_type = $form_state['values']['syllabus_type'];
        $dept_array = $mccdb->getDepartmentsSyllabusType($syllabus_type);
        if (!empty($dept_array['deparments'])) {
            foreach ($dept_array['deparments'] as $depts) {
                if (!empty($depts['department']['subjects'])) {
                    foreach ($depts['department']['subjects'] as $subjs) {
                        $subjects_codes[$subjs['subject']['id'] . '#' . $depts['department']['code'] . '-' . $subjs['subject']['code']] = $depts['department']['code'] . '-' . $subjs['subject']['code'];
                    }
                }
            }
        }
    }
    $form['materials_folder'] = array(
        '#type' => 'select',
        '#options' => $subjects_codes,
        '#required' => TRUE,
        '#title' => 'Select Subject',
        '#prefix' => '<div id="subjects_by_syllabus_type">',
        '#suffix' => '</div>',
    );
    $form['materials_type'] = array(
        '#type' => 'select',
        '#options' => array('text' => 'Text', 'ref' => 'Reference'),
        '#required' => TRUE,
        '#title' => 'Type'
    );

    $form['materials'] = array(
        '#type' => 'plupload',
        '#title' => t('Upload Text or Reference materials.'),
        '#description' => t(''),
        '#upload_validators' => array(
            'file_validate_extensions' => array('doc docx pdf ppt pptx'),
        ),
        '#plupload_settings' => array(
            'runtimes' => 'html5',
            'chunk_size' => '1mb',
        ),
    );

    $form['syllabus_materials_submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );

    $form['uploaded_materials'] = array(
        '#markup' => '<div id="uploaded_materials_div">' . theme('list_materials_display_template', $vars) . '</div>',
    );

    return $form;
}

function get_materials_folder_by_syllabus_type($form, $form_state) {
    $form_state['rebuild'] = TRUE;
    return $form['materials_folder'];
}

function materials_upload_form_submit($form, &$form_state) {
    $mccdb = new MCCdb();
    $sub_details = $form_state['values']['materials_folder'];
    $sub_details = explode('#', $sub_details);
    $sub_code = $sub_details[1];

    $scheme = $mccdb::MCC_EDU_MATERIALS_URI_SYLLABUS_TYPE . '/' .
        $sub_code .
        '/' .
        $form_state['values']['materials_type'] .
        '/';
    file_prepare_directory($scheme, FILE_CREATE_DIRECTORY);
    $submitted_files = $form_state['values']['materials'];
    foreach ($submitted_files as $file_key => $file_value) {
        $source = $file_value['tmppath'];
        $destination = file_stream_wrapper_uri_normalize($scheme . $file_value['name']);
        // Rename it to its original name, and put it in its final home.
        // Note - not using file_move here because if we call file_get_mime
        // (in file_uri_to_object) while it has a .tmp extension, it horks.
        $destination = file_unmanaged_move($source, $destination, FILE_EXISTS_RENAME);
        $file = plupload_file_uri_to_object($destination);
        file_save($file);
        drupal_set_message($file_value['name'] . ' uploaded successfully.');
    }
}

function mcc_common_remove_material() {
    $file_id = arg(2);
    $file = file_load($file_id);
    $status = file_delete($file);
    if ($status)
        drupal_set_message('Removed Successfully');
    drupal_goto('/syllabus/upload-materials');
}

function mcc_common_upload_audio_vedio() {
    $lang = '';
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['instruction'] = 'Upload Materials (MP4)';
    $vars['upload_form'] = drupal_get_form('audio_video_upload_form');
    return theme('syllabus_upload_form_template', $vars);
}

function audio_video_upload_form($form, &$form_state) {
    if (isset($_SESSION['audio_video_details'])) {
        $details = $_SESSION['audio_video_details'];
//    pretty_print($details, 0);
        unset($_SESSION['audio_video_details']);
        db_query("DELETE FROM {file_managed} WHERE uri = '" . $details['uri'] . "'")->execute();
        $query = db_insert('file_managed')
            ->fields(array(
            'filename' => $details['filename'],
            'uri' => $details['uri'],
            'status' => 1
        ));
        $query->execute();
    }
    _add_datatable_resources();
    $form = array();
    $mccdb = new MCCdb();
    global $base_url;
    $mainPath = $mccdb::MCC_EDU_AUDIO_VIDEO_URI_SYLLABUS_TYPE; //'public://mcc_syllabus/audio_video/';  
    $uploaed_audio_video = $mccdb->getFilesByURI($mainPath . '%');
    $vars['uploaed_audio_video'] = $uploaed_audio_video;
    $vars['remove_url'] = '/syllabus/remove-audio-video/';

    $form['syllabus_type'] = array(
        '#type' => 'select',
        '#options' => $mccdb->_get_syllabus_type(),
        '#required' => TRUE,
        '#title' => 'Select Syllabus Type',
        '#ajax' => array(
            'callback' => 'get_materials_folder_by_syllabus_type',
            'wrapper' => 'subjects_by_syllabus_type',
        ),
    );
    $subjects_codes = array();
    if (isset($form_state['values']['syllabus_type'])) {
        $syllabus_type = $form_state['values']['syllabus_type'];
        $dept_array = $mccdb->getDepartmentsSyllabusType($syllabus_type);
        if (!empty($dept_array['deparments'])) {
            foreach ($dept_array['deparments'] as $depts) {
                if (!empty($depts['department']['subjects'])) {
                    foreach ($depts['department']['subjects'] as $subjs) {
                        $subjects_codes[$subjs['subject']['id'] . '#' . $depts['department']['code'] . '-' . $subjs['subject']['code']] = $depts['department']['code'] . '-' . $subjs['subject']['code'];
                    }
                }
            }
        }
    }
    $form['materials_folder'] = array(
        '#type' => 'select',
        '#options' => $subjects_codes,
        '#required' => TRUE,
        '#title' => 'Select Subject',
        '#prefix' => '<div id="subjects_by_syllabus_type">',
        '#suffix' => '</div>',
    );
    $form['#attributes']['enctype'] = 'multipart/form-data';
    $form['audio_video_materials'] = array(
        '#type' => 'plupload',
        '#title' => t('Upload Audio Video materials.'),
        '#description' => t(''),
        '#upload_validators' => array(
            'file_validate_extensions' => array('mp4'),
        ),
        '#plupload_settings' => array(
            'runtimes' => 'html5',
            'chunk_size' => '1mb',
        ),
    );

    $form['syllabus_materials_submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );

    $form['uploaded_audio_video'] = array(
        '#markup' => '<div id="audio_video_div">' . theme('list_audo_video_display_template', $vars) . '</div>',
    );
    return $form;
}

function audio_video_upload_form_submit($form, &$form_state) {
    db_query("SET wait_timeout=1000")->execute();
    $mccdb = new MCCdb();
    $temp_path = file_directory_temp();
    $temp_path = drupal_realpath($temp_path);
    $sub_details = $form_state['values']['materials_folder'];
    $sub_details = explode('#', $sub_details);
    $sub_code = $sub_details[1];
    $scheme = $mccdb::MCC_EDU_AUDIO_VIDEO_URI_SYLLABUS_TYPE . '/' . $sub_code . '/';
    file_prepare_directory($scheme, FILE_CREATE_DIRECTORY);
    $submitted_files = $form_state['values']['audio_video_materials'];
    foreach ($submitted_files as $file_key => $file_value) {
        $source = $file_value['tmppath'];
        $destination = file_stream_wrapper_uri_normalize($scheme . $file_value['name']);
        $destination = file_unmanaged_move($source, $destination, FILE_EXISTS_REPLACE);
        if (!empty($destination)) {
            if (isset($_SESSION['audio_video_details']))
                unset($_SESSION['audio_video_details']);
            $_SESSION['audio_video_details'] = array(
                'filename' => $file_value['name'],
                'uri' => $destination
            );
        }
    }
}

function mcc_common_remove_audio_video() {
    $file_id = arg(2);
    $file = file_load($file_id);
    $status = file_delete($file);
    if ($status)
        drupal_set_message('Removed Successfully');
    drupal_goto('/syllabus/upload-audio-video');
}

function mcc_common_upload_pdf_version_syllabus_by_type() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('upload_form_pdf_version');
    return theme('syllabus_upload_form_template', $vars);
}

function upload_form_pdf_version($form, &$form_state) {
    $syllabus_pdf_default = null;
    $form = array();
    $mccDB = new MCCdb();

    $form['syllabus_type'] = array(
        '#type' => 'select',
        '#options' => $mccDB->_get_syllabus_type(),
        '#required' => TRUE,
        '#title' => 'Select Syllabus Type',
    );

    $form['syllabus_pdf'] = array(
        '#type' => 'managed_file',
        '#title' => t('Upload PDF - Allowed Extensions: PDF'),
        '#upload_location' => 'public://mcc_syllabus/',
        '#default_value' => $syllabus_pdf_default,
        '#theme' => 'syllabus_pdf_thumb_upload',
        '#progress_indicator' => 'throbber',
        '#progress_message' => 'Uploading ...',
        '#upload_validators' => array(
            'file_validate_extensions' => array('pdf'),
            'file_validate_size' => array(5 * 1024 * 1024),
            'file_validate_name' => array('syllabus_pdf_custom_validator')
        )
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );

    return $form;
}

function syllabus_pdf_custom_validator(stdClass $file) {
    db_query("DELETE FROM {file_managed} WHERE uri = '$file->destination'");
}

function upload_form_pdf_version_submit($form, &$form_state) {
    $submitted_values = $form_state['values'];
//  pretty_print($submitted_values);
    if (!empty($submitted_values['syllabus_type']) && !empty($submitted_values['syllabus_pdf'])) {
        variable_set('syllabus-' . $submitted_values['syllabus_type'], $submitted_values['syllabus_pdf']);
        if (!empty($submitted_values['syllabus_pdf'])) {
            $file = file_load($submitted_values['syllabus_pdf']);
            $file->status = FILE_STATUS_PERMANENT;
            file_save($file);
        }
    } else {
        drupal_goto(404);
    }
    drupal_set_message('Uploaded');
}

function mcc_common_syllabus_by_type_pdf($syllabus_type) {
    $vars = array();
    global $user;
    if (empty($user->uid))
        drupal_goto(404);
    if (!empty($syllabus_type)) {
        $fid = variable_get('syllabus-' . trim($syllabus_type), 0);
        if (empty($fid)) {
            drupal_set_message('PDF not found', 'error');
        } else {
            $file = file_load($fid);
            if (!empty($file->uri))
                $vars['file_url'] = file_create_url($file->uri);
        }
    } else {
        drupal_goto(404);
    }
    drupal_set_title('Syllabus Book');
    return theme('syllabus_by_type_pdf_template', $vars);
}

function mcc_common_course_registration() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('course_registration_form');
    return theme('syllabus_upload_form_template', $vars);
}

function course_registration_form($form, &$form_state) {
    _add_datatable_resources();
    $form = array();
    $mccDB = new MCCdb();
    $vars['registration_details'] = $mccDB->getRegistrationDetails();
    $form['r1'] = array(
        '#markup' => '<div class="row">'
    );
    $form['r1c1'] = array(
        '#markup' => '<div class="col col-md-5">'
    );
    $form['session'] = array(
        '#type' => 'select',
        '#options' => _session_names(),
        '#required' => TRUE,
        '#title' => 'Select Session',
    );
    $form['year'] = array(
        '#type' => 'select',
        '#options' => _years_array(),
        '#required' => TRUE,
        '#title' => 'Select Year',
    );
    $form['registration_csv'] = array(
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
            'file_validate_name' => array('course_reg_custom_validator')
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
    $reg_form = '<a target="_blank" style="display:inline; text-decoration:underline" class="" href="https://goo.gl/forms/GXOFtXGcEvNOLIhW2">Registration Form <i class="fa fa-external-link"></i></i></a>';
    $reg_form_result = '<a target="_blank" style="display:inline; text-decoration:underline" class="" href="https://docs.google.com/spreadsheets/d/1U35qsOGoCbpXOelfr03Qlzi5UiIC28u2ee7nAnJTNlY/">Sheet <i class="fa fa-external-link"></i></i></a>';
    $form['r1c2Inst'] = array(
        '#markup' => '<div class="card card-outline-primary m-b-20 white-box"><div class="card-block">'
        . '<ul class="common-list">'
        . '<li>1. This ' . $reg_form . ' is used to collect information for course registration</li>'
        . '<li>2. This ' . $reg_form_result . ' store the registration form submission from users.</li>'
        . '<li>3. Download the ' . $reg_form_result . ' as csv and upload it on this page.</li>'
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

    $form['completed_registration'] = array(
        '#markup' => '<div id="completed_registration_div">' . theme('completed_registration_template', $vars) . '</div>',
    );
    return $form;
}

function course_reg_custom_validator(stdClass $file) {
    db_query("DELETE FROM {file_managed} WHERE uri = '$file->destination'");
}

function course_registration_form_submit($form, &$form_state) {
    $submitted_values = $form_state['values'];
    $file = file_load($submitted_values['registration_csv']);
    $mccDB = new MCCdb();

    ini_set('auto_detect_line_endings', TRUE);
    $csv_uri = file_create_url($file->uri);

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
        foreach ($rows as $row) {
            if (!empty($row[6])) {
                $data_array = NULL;
                $data_array['email'] = $row[1];
                $data_array['name'] = $row[2] . ' ' . $row[3];
                $data_array['phone'] = $row[4];
                $data_array['unit'] = $row[5];
                $data_array['paid'] = $row[7];
                $data_array['course_codes'] = array_map('trim', explode(',', $row[6]));
                $data_array['session'] = $submitted_values['session'];
                $data_array['year'] = $submitted_values['year'];
                $uid = _create_update_user($data_array);
                user_multiple_role_edit(array($uid), 'add_role', 11);
                if ($uid) {
                    $data_array['user_id'] = $uid;
                    $existing = $mccDB->checkIfUserIsAlreadyRegisteredInSession($data_array);
                    if (!empty($existing->course_codes)) {
                        $courses = unserialize($existing->course_codes);
                        $courses = array_merge($courses, $data_array['course_codes']);
                        $courses = array_unique($courses);
                        unset($data_array['course_codes']);
                        $data_array['course_codes'] = $courses;
                        $data_array['id'] = $existing->id;
                    }
//                    pretty_print($data_array, 0);
                    $mccDB->setSessionRegistration($data_array);
                }
            }
        }
    }
//    die('p');
    drupal_set_message('Successfully Done.');
}

function mcc_common_registration_delete($id) {
    $mccdb = new MCCdb();
    $mccdb->delSessionRegistrationById($id);
    drupal_set_message('Deleted Successfully.');
    drupal_goto('syllabus/course-registration');
}

function mcc_common_course_url() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('course_url_form');
    return theme('syllabus_upload_form_template', $vars);
}

function course_url_form($form, &$form_state) {
    _add_datatable_resources();
    $form = array();
    $mccdb = new MCCdb();
    global $base_url;
    $syllabus_types = $mccdb->_get_syllabus_type();
    $academic_syllabus = array();
    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = array_merge($academic_syllabus, $mccdb->getDepartmentsSubjects($key));
    }
    $form['course_code'] = array(
        '#type' => 'select',
        '#required' => TRUE,
        '#title' => 'Course',
        '#options' => $academic_syllabus
    );

    $form['course_url'] = array(
        '#type' => 'textfield',
        '#title' => 'Meeting URL',
        '#required' => TRUE,
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );
    $vars['urls'] = $mccdb->getCourseUrls();
    $form['saved_urls'] = array(
        '#markup' => '<div id="saved_url_div">' . theme('list_course_urls_display_template', $vars) . '</div>',
    );

    return $form;
}

function course_url_form_submit($form, &$form_state) {
    $mccdb = new MCCdb();
    $submitted_values = $form_state['values'];
    $courese_url = $mccdb->getCourseUrl($submitted_values['course_code']);
    if (!empty($courese_url['id'])) {
        $submitted_values['id'] = $courese_url['id'];
        $url_id = $mccdb->setCourseUrl($submitted_values);
    } else {
        $url_id = $mccdb->setCourseUrl($submitted_values);
    }
    drupal_set_message('Saved');
}

function mcc_common_course_url_delete($id) {
    $mccdb = new MCCdb();
    $mccdb->delCourseUrlById($id);
    drupal_set_message('Deleted Successfully.');
    drupal_goto('syllabus/course-url');
}

function mcc_common_course_calendar($form, &$form_state) {
    global $user;
    $mccdb = new MCCdb();
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }

    $form = array();
    $form['#tree'] = TRUE;

    $html = '';

    $form['#attached']['js'] = array(
        drupal_get_path('module', 'mcc_common') . '/js/monthly.js'
    );
    $form['#attached']['css'] = array(
        drupal_get_path('module', 'mcc_common') . '/css/monthly.css'
    );

    $form['row2'] = array(
        '#markup' => '<div class="row">'
    );
    $form['row2Col1'] = array(
        '#markup' => '<div class="col col-md-12 panel-body cal-box">'
    );

    $calendar_events_array = array();
    $date_format = 'Y-m-d';
    $time_format = 'H:i';
    $vars['calendar_events_json'] = json_encode(array());
    $calendar_events = $mccdb->getMCCEduScheduleForCalendar();
    $academic_syllabuses = array();
    $syllabus_types = $mccdb->_get_syllabus_type();
    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = $mccdb->getDepartmentsSubjects($key, false);
        $academic_syllabuses = array_merge($academic_syllabuses, $academic_syllabus);
    }
//    pretty_print($academic_syllabuses,0);
    if (!empty($calendar_events)) {
        foreach ($calendar_events as $key => $event) {
            $meeting_name = $event->course_code;
            $meeting_name .= '<br/>' . str_replace($event->course_code, '', $academic_syllabuses[$event->course_code]);
            if (!empty($event->course_url)) {
                $meeting_name .= '<br/>URL: <b><i>' . $event->course_url . '</i></b>';
            }
            $calendar_events_array[$key]['id'] = $key;
            $calendar_events_array[$key]['name'] = $meeting_name;
            $calendar_events_array[$key]['startdate'] = format_date($event->class_date, 'medium', $date_format);
            $calendar_events_array[$key]['enddate'] = format_date($event->class_date, 'medium', $date_format);
            $calendar_events_array[$key]['starttime'] = format_date($event->class_date, 'medium', $time_format);
            $calendar_events_array[$key]['endtime'] = ''; //format_date($event->class_date, 'medium', $time_format);
            $calendar_events_array[$key]['color'] = '#669966';
            $calendar_events_array[$key]['url'] = !empty($event->course_url) ? $event->course_url : '#';
        }
        if (!empty($calendar_events_array)) {
            $vars['calendar_events_json'] = json_encode($calendar_events_array);
        }
    }
    $form['mcc_calendar_fed_unit'] = array(
        '#markup' => '<div id="replace_calendar_div">' . theme('mcc_edu_calendar', $vars) . '</div>',
    );
    $form['row2Col1End'] = array(
        '#markup' => '</div>'
    );
    $form['row2End'] = array(
        '#markup' => '</div>'
    );
    return $form;
}
