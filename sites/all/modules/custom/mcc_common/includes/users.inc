<?php

function port_user_from_mccportal() {
    $name = $_POST['name'];
    $email = $_POST['mail'];
    $roles_string = $_POST['roles'];
    $access_token = $_POST['access_token'];

    $existing_user_mail = user_load_by_mail($email);
    require_once 'includes/password.inc';
    if (!empty($existing_user_mail)) {
        $existing_user_mail->field_subtitle['und'][0]['value'] = $access_token;
        $existing_user_mail->pass = user_hash_password($access_token);
        user_save($existing_user_mail);
        user_multiple_role_edit(array($existing_user_mail->uid), 'add_role', 10);
    } else {
        $new_user = array(
            'name' => $email,
            'pass' => $access_token,
            'mail' => $email,
            'status' => 1,
            'init' => $email,
            'field_subtitle' => array(
                'und' => array(
                    0 => array(
                        'value' => user_hash_password($access_token),
                    ),
                ),
            ),
        );
        $account = user_save(NULL, $new_user);
        user_multiple_role_edit(array($account->uid), 'add_role', 10);
    }
}

function eduportal_in() {
    //pretty_print(arg());
    $email = arg(1);
    $pass = arg(2);

    $user_exist = user_load_by_mail($email);

    //pretty_print($user);
    if ($uid = user_authenticate($user_exist->name, $pass)) {
        $form_state = array();
        $form_state['uid'] = $uid;
        user_multiple_role_edit(array($uid), 'add_role', 10);
        user_login_submit(array(), $form_state);
        drupal_goto('academic-syllabus-brief');
        return true;
    } else {
        drupal_goto(404);
    }
}

function mcc_common_my_courses() {
    _add_datatable_resources();
    $mccDB = new MCCdb();
    global $user;
    $academic_syllabuses = array();
    $facultySubjectsArray = array();
    $syllabus_types = $mccDB->_get_syllabus_type();

    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = $mccDB->getDepartmentsSubjects($key, true);
        $academic_syllabuses = array_merge($academic_syllabuses, $academic_syllabus);
    }
////    if (_isFacultyOnly()) {
//        $facultySubjects = _getFacultyCourses(null);
//        $count_sub = 1;
//        foreach ($facultySubjects as $subject) {
//            $count_sub++;
//            $s_y = $subject['session'] . ', ' . $subject['year'];
//            $line_break = '';
//            if (!empty($facultySubjectsArray[$s_y])) {
//                if ($count_sub % 4 == 0)
//                    $line_break = '<br/>';
//                $facultySubjectsArray[$s_y] .= ', ' . $line_break . _getHyperLinkedCourse($subject['course_code'], $academic_syllabuses);
//            } else {
//                $count_sub = 1;
//                $facultySubjectsArray[$s_y] = _getHyperLinkedCourse($subject['course_code'], $academic_syllabuses);
//            }
//        }
//        $vars['facultySubjects'] = $facultySubjectsArray;
////    }

    $vars['registeredSubjects'] = $mccDB->getRegistrationDetails($user->uid);
    $vars['academic_syllabuses'] = $academic_syllabuses;
    return theme('syllabus_by_type_my_courses_template', $vars);
}

function mcc_common_my_courses_result() {
    _add_datatable_resources();
    $mccDB = new MCCdb();
    global $user;
    $academic_syllabuses = array();
    $academic_syllabuses_name = array();
    $facultySubjectsArray = array();
    $syllabus_types = $mccDB->_get_syllabus_type();

    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = $mccDB->getDepartmentsSubjects($key, true);
        $academic_syllabuses = array_merge($academic_syllabuses, $academic_syllabus);
        $academic_syllabus_name = $mccDB->getDepartmentsSubjects($key, false);
        $academic_syllabuses_name = array_merge($academic_syllabuses_name, $academic_syllabus_name);
    }

    $vars['results'] = $mccDB->getCourseResult($user->uid);
    $vars['page_title'] = "My Courses Result";
//    pretty_print($vars);
    $vars['academic_syllabuses'] = $academic_syllabuses;
    $vars['academic_syllabuses_name'] = $academic_syllabuses_name;
    return theme('syllabus_by_type_my_courses_result_template', $vars);
}

function mcc_common_user_courses_result($user_id) {
    _add_datatable_resources();
    $mccDB = new MCCdb();
    $user = user_load($user_id);
    if (empty($user))
        drupal_goto(404);
    $vars['page_title'] = "Courses Result For - " . $user->field_name['und'][0]['value'];
    drupal_set_title("Courses Result For - " . $user->field_name['und'][0]['value']);
    $academic_syllabuses = array();
    $academic_syllabuses_name = array();
    $facultySubjectsArray = array();
    $syllabus_types = $mccDB->_get_syllabus_type();

    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = $mccDB->getDepartmentsSubjects($key, true);
        $academic_syllabuses = array_merge($academic_syllabuses, $academic_syllabus);
        $academic_syllabus_name = $mccDB->getDepartmentsSubjects($key, false);
        $academic_syllabuses_name = array_merge($academic_syllabuses_name, $academic_syllabus_name);
    }

    $vars['results'] = $mccDB->getCourseResult($user_id);
//    pretty_print($vars);
    $vars['academic_syllabuses'] = $academic_syllabuses;
    $vars['academic_syllabuses_name'] = $academic_syllabuses_name;
    return theme('syllabus_by_type_my_courses_result_template', $vars);
}

function mcc_common_instructor_for_courses() {
    _add_datatable_resources();
    $mccDB = new MCCdb();
    global $user;
    $academic_syllabuses = array();
    $facultySubjectsArray = array();
    $syllabus_types = $mccDB->_get_syllabus_type();

    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = $mccDB->getDepartmentsSubjects($key, true);
        $academic_syllabuses = array_merge($academic_syllabuses, $academic_syllabus);
    }
//    if (_isFacultyOnly()) {
    $facultySubjects = _getFacultyCourses(null);
    $count_sub = 1;
    foreach ($facultySubjects as $subject) {
        $count_sub++;
        $s_y = $subject['session'] . ', ' . $subject['year'];
        $line_break = '';
        if (!empty($facultySubjectsArray[$s_y])) {
            if ($count_sub % 4 == 0)
                $line_break = '<br/>';
            $facultySubjectsArray[$s_y] .= ', ' . $line_break . _getHyperLinkedCourse($subject['course_code'], $academic_syllabuses);
        } else {
            $count_sub = 1;
            $facultySubjectsArray[$s_y] = _getHyperLinkedCourse($subject['course_code'], $academic_syllabuses);
        }
    }
    $vars['facultySubjects'] = $facultySubjectsArray;
//    }
//    $vars['registeredSubjects'] = $mccDB->getRegistrationDetails($user->uid);
    $vars['academic_syllabuses'] = $academic_syllabuses;
    return theme('syllabus_by_type_my_courses_template', $vars);
}

function mcc_common_registered_users() {
    $mccDB = new MCCdb();
    global $user;
    $vars['attachment_form'] = drupal_get_form('attach_file_form');
    $registered_users = $mccDB->getRegisteredUserUnderInstructor($user->uid);
    $registered_users_array = array();
    if (!empty($registered_users)) {
        foreach ($registered_users as $reg_usr) {
            if (!empty($reg_usr->mail)) {
                $cur_key = $reg_usr->session . ', ' . $reg_usr->year;
                $registered_users_array[$cur_key][$reg_usr->course_code][] = array(
                    'name' => $reg_usr->field_name_value,
                    'mail' => $reg_usr->mail
                );
            }
        }
    }

    $vars['registered_users_array'] = $registered_users_array;
    return theme('syllabus_by_type_registered_users', $vars);
}

function _mcc_user_mail_send() {
    header('Content-type: application/json');
    if (!empty($_POST['custom-message'])) {
        global $user;
        $email_addresses = $_POST['mail-to-address'];
        $email_subject = $_POST['mail-subject'];
        $email_text = $_POST['custom-message'];
        $email_address_array = explode(',', $email_addresses);
        $email_content = nl2br($email_text);
        $email_attachment = $_POST['mail-attachment'];
//    $mail_to = trim($email_address_array[0]);
//    unset($email_address_array[0]);
        $mail_bcc = '';
        foreach ($email_address_array as $key => $email) {
            $mail_bcc .= trim($email) . ',';
        }
        if (valid_email_address($user->mail)) {
            if (empty($email_subject))
                $email_subject = 'Mail from MCC ' . date('d M, Y');
            $mail = generate_send_mail_contents($user->mail, 'mcc-mail', array(
                'email_content' => $email_content,
                'subject' => $email_subject,
                'bcc' => trim(rtrim($mail_bcc, ',')),
                'attachment' => $email_attachment
                ), $user->mail
            );
            if (!empty($mail['result'])) {
                echo json_encode(array('value' => 'Mail Sent'), JSON_PRETTY_PRINT);
                exit;
            } else {
                watchdog('MMail', 'Not DONE-<pre>' . print_r($mail, 1) . '</pre>');
                echo json_encode(array('value' => 'Not Done'), JSON_PRETTY_PRINT);
                exit;
            }
        } else {
            //watchdog('MMail', 'Mail Address Problem-<pre>' . print_r($mail_to, 1) . '</pre>');
            echo json_encode(array('value' => 'Mail Address Problem'), JSON_PRETTY_PRINT);
            exit;
        }
    } else {
        echo json_encode(array('value' => 'Nothing'), JSON_PRETTY_PRINT);
        exit;
    }
}

function attach_file_form($form, &$form_state) {
    $form = array();

    $form['attachment'] = array(
        '#type' => 'managed_file',
        '#title' => t('Attach File - Allowed Extensions: pdf, doc, docx, ppt, pptx, jpg, jpeg, png'),
        '#upload_location' => 'public://mailfile/',
        '#attributes' => array('id' => 'mcc_mail_file'),
        '#progress_indicator' => 'throbber',
        '#progress_message' => 'Uploading ...',
        '#upload_validators' => array(
            'file_validate_extensions' => array('pdf doc docx ppt pptx jpg jpeg png'),
            'file_validate_size' => array(5 * 1024 * 1024)
        )
    );

    return $form;
}

function mcc_common_course_result($form, $form_state) {
    $form = array();
    global $user;
    $mccDB = new MCCdb();
    $syllabus_types = $mccDB->_get_syllabus_type();
    $academic_syllabus = array();

    if (!_isFacultyOnly()) {
        $session_years = $mccDB->getSessionsYearsFromReg();
        foreach ($syllabus_types as $key => $val) {
            $academic_syllabus = array_merge($academic_syllabus, $mccDB->getDepartmentsSubjects($key));
        }
    } else if (_isFacultyOnly())
        $session_years = $mccDB->getSessionsYearsForCourseInst($user->uid);

    $session_years_array = array();
    if (!empty($session_years)) {
        foreach ($session_years as $session_year) {
            $session_years_array[$session_year->session . '###' . $session_year->year] = ucfirst($session_year->session) . ', ' . $session_year->year;
        }
    }
    $form['session_year'] = array(
        '#type' => 'select',
        '#options' => $session_years_array,
        '#required' => TRUE,
        '#title' => 'Session',
        '#ajax' => array(
            'callback' => 'callback_course_codes',
            'wrapper' => 'course-codes-wrapper'
        )
    );

    $form['course_codes'] = array(
        '#type' => 'select',
        '#options' => array(),
        '#required' => TRUE,
        '#title' => 'Course',
        '#prefix' => '<div id="course-codes-wrapper">',
        '#suffix' => '</div>',
        '#ajax' => array(
            'callback' => 'callback_result',
            'wrapper' => 'result-wrapper'
        )
    );
    $form['course_results'] = array(
        '#type' => 'markup',
        '#prefix' => '<div id="result-wrapper">',
        '#suffix' => '</div>',
    );
    if (!empty($form_state['values']['session_year'])) {
        $selected_s_y = explode('###', $form_state['values']['session_year']);
        if (_isFacultyOnly()) {
            $course_codes = $mccDB->getCourseInstructor($user->uid, null, $selected_s_y[0], $selected_s_y[1]);
            $course_codes_array = array();
            if (!empty($course_codes)) {
                foreach ($course_codes as $course_code) {
                    $course_codes_array[$course_code['course_code']] = $course_code['course_code'];
                }
                $form['course_codes']['#options'] = $course_codes_array;
            }
        } else {
            $form['course_codes']['#options'] = $academic_syllabus;
        }
    }
    if (!empty($form_state['values']['course_codes'])) {
        $submitted_values = $form_state['values'];
        $result = array();
        $session_years_array = explode('###', $submitted_values['session_year']);
        if (!empty($session_years_array)) {
            list($session, $year) = $session_years_array;
            $vars['session'] = $session;
            $vars['year'] = $year;
            $vars['course_code'] = $form_state['values']['course_codes'];
            $result = $mccDB->getCourseResultWithUserInfo($submitted_values['course_codes'], $session, $year);
        }
        $vars['result'] = $result;
        $form['course_results']['#prefix'] = '<div id="result-wrapper"> ' . theme('syllabus_by_type_course_result', $vars);
    }
    return $form;
}

function callback_course_codes($form, $form_state) {
    return $form['course_codes'];
}

function callback_result($form, $form_state) {
    return $form['course_results'];
}
