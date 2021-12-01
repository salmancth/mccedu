<?php

include_once 'mcc.db.class.inc';

function mcc_common_course_instructor_assignment() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('course_instructor_assignment_form');
    return theme('syllabus_upload_form_template', $vars);
}

function course_instructor_assignment_form($form, &$form_state) {
    _add_datatable_resources();
    $form = array();
    $mccDB = new MCCdb();

    $roles_include = array(
        $mccDB::ROLE_FACULTY_ID
    );

    $form['instructor_id'] = array(
        '#type' => 'select',
        '#options' => _prepare_users_for_select_list($mccDB->getUsersByRoles($roles_include)),
        '#required' => TRUE,
        '#title' => 'Faculty',
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

    $syllabus_types = $mccDB->_get_syllabus_type();

    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = $mccDB->getDepartmentsSubjects($key);
        $form['courses_' . $key] = array(
            '#title' => t('Choose Subjects From ' . $val),
            '#type' => 'checkboxes',
            '#options' => $academic_syllabus,
            '#prefix' => '<div class="subjects-name">',
            '#suffix' => '</div>'
        );
    }

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );

    return $form;
}

function course_instructor_assignment_form_submit($form, &$form_state) {
    $mccDB = new MCCdb();
    $submitted_values = $form_state['values'];
    $syllabus_types = $mccDB->_get_syllabus_type();
    $submitted_values['subjects'] = array();
    foreach ($syllabus_types as $key => $val) {
        $submitted_values['subjects'] = array_merge($submitted_values['subjects'], array_filter($submitted_values['courses_' . $key]));
    }
//    pretty_print($submitted_values);
    if (!empty($submitted_values['subjects'])) {
        foreach ($submitted_values['subjects'] as $course_code) {
            $course_instructor = $mccDB->getCourseInstructor(null, $course_code, $submitted_values['session'], $submitted_values['year']);
            if (empty($course_instructor)) {
                $course_instructor['course_code'] = $course_code;
                $course_instructor['instructor_id'] = $submitted_values['instructor_id'];
                $course_instructor['session'] = $submitted_values['session'];
                $course_instructor['year'] = $submitted_values['year'];
            } else {
                $course_instructor = reset($course_instructor);
                $course_instructor['instructor_id'] = $submitted_values['instructor_id'];
                $course_instructor['session'] = $submitted_values['session'];
                $course_instructor['year'] = $submitted_values['year'];
            }
//            pretty_print($course_instructor, 0);
            if (!empty($course_instructor)) {
                $id = $mccDB->setCourseInstructor($course_instructor);
                if ($id)
                    drupal_set_message('Saved!');
            }
        }
    }
}

function mcc_common_course_classes() {
    global $user;
    $vars = array();
    $mccdb = new MCCdb();
    _add_datatable_resources();
    $instructor_id = null;
    if (_isFacultyOnly())
        $instructor_id = $user->uid;
//    if (arg(2) == 'datatable') {
//        $data = null;
//        $recordsTotal = 0;
//        $recordsFiltered = 0;
//        if (isset($_GET['start']) && $_GET['length'] != -1 && isset($_GET)) {
//            $data = $mccdb->getCoursesClassesLists($instructor_id, $_GET['start'], $_GET['length'], $_GET);
//            $recordsTotal = $mccdb->getCoursesClassesCount($instructor_id);
//            $recordsFiltered = $recordsTotal;
//        } else {
//            $data = $mccdb->getCoursesClassesLists($instructor_id);
//            $recordsTotal = $mccdb->getCoursesClassesCount($instructor_id);
//            $recordsFiltered = $recordsTotal;
//        }
//        echo json_encode(array(
//            "draw" => isset($_GET['draw']) ?
//                intval($_GET['draw']) :
//                0,
//            "recordsTotal" => $recordsTotal,
//            "recordsFiltered" => $recordsFiltered,
//            "data" => $data
//        ));
//        exit(0);
//    }
    $vars['class_list'] = $mccdb->getCoursesClassesLists($instructor_id);
//    pretty_print($vars);
    $sms_phone = variable_get('mcc_twilio_number', '+16475592852');
    $sms_phone = format_phone_number($sms_phone);
    drupal_set_message("MCC Class Attendence Phone Number: {$sms_phone}");
    return theme('syllabus_class_list_template', $vars);
}

function mcc_common_course_class_create() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('course_class_form');
    return theme('syllabus_upload_form_template', $vars);
}

function course_class_form($form, &$form_state, $class_details = NULL) {
    $form = array();
    global $user;
    $mccDB = new MCCdb();
    $months_mapping = _session_to_months_mapping();
    $current_month = date('F');
    $current_session = '';
    foreach ($months_mapping as $key => $session) {
        if (in_array($current_month, $session)) {
            $current_session = $key;
            break;
        }
    }
    $course_codes = $mccDB->getCourseInstructor($user->uid, null, $current_session, date('Y'));
    $course_codes_array = array();
    if (!empty($course_codes)) {
        foreach ($course_codes as $course_code) {
            $course_codes_array[$course_code['course_code']] = $course_code['course_code'];
        }
    }

    if (mcc_common_user_has_role('administrator')) {
        $syllabus_types = $mccDB->_get_syllabus_type();
        $course_codes_array = array();
        foreach ($syllabus_types as $key => $val) {
            $course_codes_array = array_merge($course_codes_array, $mccDB->getDepartmentsSubjects($key));
        }
    }
    $session_year_array = array($current_session . '###' . date('Y') => ucfirst($current_session) . '-' . date('Y'));
    $default_session_year = NULL;
    $default_course_code = NULL;
    $default_class_details = NULL;
    $class_date_default = format_date(REQUEST_TIME, 'custom', 'Y-m-d H:i:s');
    if (!empty($class_details)) {
        if (!empty($class_details->session) && !empty($class_details->year)) {
            $session_year_array = array($class_details->session . '###' . $class_details->year => ucfirst($class_details->session) . '-' . $class_details->year);
            $default_session_year = $class_details->session . '###' . $class_details->year;
        }
        if (!empty($class_details->class_date)) {
            $class_date_default = format_date($class_details->class_date, 'custom', 'Y-m-d H:i:s');
        }
        if (!empty($class_details->session) && !empty($class_details->year)) {
            $course_codes = $mccDB->getCourseInstructor($class_details->instructor_id, null, $class_details->session, $class_details->year);
            $course_codes_array = array();
            if (!empty($course_codes)) {
                foreach ($course_codes as $course_code) {
                    $course_codes_array[$course_code['course_code']] = $course_code['course_code'];
                }
            }
            $default_course_code = $class_details->course_code;
        }
        if (!empty($class_details->class_details)) {
            $default_class_details = $class_details->class_details;
        }
    }
    $form['session_year'] = array(
        '#type' => 'select',
        '#options' => $session_year_array,
        '#required' => TRUE,
        '#title' => 'Session',
        '#default_value' => $default_session_year
    );
    $form['course_code'] = array(
        '#type' => 'select',
        '#options' => $course_codes_array,
        '#default_value' => $default_course_code,
        '#required' => TRUE,
        '#title' => 'Course',
        '#ajax' => array(
            'callback' => 'callback_reg_user',
            'wrapper' => 'reg-user-wrapper'
        )
    );

    $form['class_date'] = array(
        '#type' => 'date_select',
        '#title' => t('Date'),
        '#date_format' => 'm-d-Y H:i',
        '#default_value' => $class_date_default,
        '#value' => $class_date_default,
        '#date_year_range' => '-1:+1',
        '#required' => TRUE,
        '#date_type' => DATE_DATETIME,
        '#date_timezone' => date_default_timezone(),
        '#date_increment' => 1,
    );

//    $form['class_presents'] = array(
//        '#type' => 'textfield',
//        '#title' => t('Total Presents'),
//        '#size' => 5,
//        '#required' => TRUE,
//        '#default_value' => $activity_presents_default
//    );

    $form['class_attendees'] = array(
        '#title' => t('Attendees'),
        '#type' => 'checkboxes',
        '#options' => array(),
//        '#default_value' => $activity_attendees_default,
        '#prefix' => '<div id="reg-user-wrapper">',
        '#suffix' => '</div>'
    );

    if (!empty($form_state['values']['course_code'])) {
        $class_students = array();
        $submitted_values = $form_state['values'];
        $course_code = $form_state['values']['course_code'];
        $session_years_array = explode('###', $submitted_values['session_year']);
        $session = NULL;
        $year = NULL;
        $results = array();
        if (!empty($session_years_array)) {
            list($session, $year) = $session_years_array;
            if (!empty($course_code)) {
                $results = $mccDB->getRegisteredUserUnderInstructorByCourseCode(
                        null, $course_code, $session, $year
                );
            }
        }

        if (!empty($results)) {
            foreach ($results as $result) {
                $nm = !empty($result->field_name_value) ? $result->field_name_value : $result->mail;
                $class_students[$result->user_id . '#' . $nm] = $nm;
            }
        }
        $form['class_attendees']['#options'] = $class_students;
    }
    if (!empty($class_details)) {
        if (!empty($class_details->course_code) && !empty($class_details->session) && !empty($class_details->year)) {
            $results = $mccDB->getRegisteredUserUnderInstructorByCourseCode(
                    null, $class_details->course_code, $class_details->session, $class_details->year
            );
            if (!empty($results)) {
                foreach ($results as $result) {
                    $nm = !empty($result->field_name_value) ? $result->field_name_value : $result->mail;
                    $class_students[$result->user_id . '#' . $nm] = $nm;
                }
            }
            $form['class_attendees']['#options'] = $class_students;
            $default_class_attendees = null;
            if (!empty($class_details->class_attendees)) {
                $att_u = drupal_json_decode($class_details->class_attendees);
                //_print_var_dump($att_u);
                foreach ($att_u['manual'] as $key => $val)
                    $default_class_attendees[] = $key . '#' . $val;
            }
            $form['class_attendees']['#default_value'] = $default_class_attendees;
        }
    }

    $form['class_details'] = array(
        '#title' => t('Notes'),
        '#type' => 'textarea',
        '#default_value' => $default_class_details,
        '#rows' => 3,
        '#resizable' => FALSE,
            //'#format' => 'plain_text',
    );

    if (!empty($class_details->id)) {
        $form['class-id'] = array(
            '#type' => 'hidden',
            '#default_value' => $class_details->id,
        );
    }

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save Class'),
    );

    return $form;
}

function callback_reg_user($form, $form_state) {
    return $form['class_attendees'];
}

function course_class_form_submit($form, &$form_state) {
    $submitted_values = $form_state['values'];
//    pretty_print($submitted_values);
    $mccDB = new MCCdb();
    global $user;
    $params = array();
    if(!empty($submitted_values['class-id'])) {
        $params['id'] = $submitted_values['class-id'];
    }
    list($session, $year) = explode('###', $submitted_values['session_year']);
    $params['session'] = $session;
    $params['year'] = $year;
    $params['course_code'] = $submitted_values['course_code'];
//    $params['class_presents'] = $submitted_values['class_presents'];
    $params['class_details'] = $submitted_values['class_details'];
    $attendess_present = array();
    $attendess_array = $form_state['input']['class_attendees'];
    $manual_total = $auto_total = 0;
    foreach ($attendess_array as $attendee) {
        if (!empty($attendee)) {
            $attendee_details = explode('#', $attendee);
            $attendess_present['manual'][$attendee_details[0]] = $attendee_details[1];
        }
    }
    if (isset($attendess_present['manual'])) {
        $manual_total = count($attendess_present['manual']);
    }
    if (isset($attendess_present['sms'])) {
        $auto_total = count($attendess_present['sms']);
    }
    $params['class_attendees'] = drupal_json_encode($attendess_present);
    $params['class_presents'] = $manual_total + $auto_total;
    if(!$params['id']) {
        $params['instructor_id'] = $user->uid;
    }
    $params['class_date'] = intval(strtotime(
                    $submitted_values['class_date']['year'] . '/' .
                    $submitted_values['class_date']['month'] . '/' .
                    $submitted_values['class_date']['day'] . ' ' .
                    $submitted_values['class_date']['hour'] . ':' .
                    $submitted_values['class_date']['minute'] . ':00'));
//    pretty_print($params);
    $cc_id = $mccDB->setCourseClass($params);
    if($params['id']) {
        drupal_set_message("Updated Successfully.");
        drupal_goto('/syllabus/update-class-attendess/'.$params['id']);
    }
    if ($cc_id) {
        drupal_goto('/syllabus/course-classes');
    }
}

function mcc_common_update_class_attendess() {
    /**
     * First get class id from arg
     * then load that class's code, created date
     * if meeting code not empty
     * prepare ending date
     * also load meeting attendess in a array
     * We'll update the array (array merge) if any message has the particular code
     */
    $mccdb = new MCCdb();
    $class_id = intval(arg(2));
    $class = $mccdb->getClassById($class_id);
//    pretty_print($class);
    $redirect_to = '/syllabus/course-classes';
    //_print_var_dump($section_node, true);
    if (!empty($class->sms_code)) {
        $code = $class->sms_code;
        $start_date = date('Y-m-d H:i', $class->class_date);
        $start_date = new DateTime($start_date, new DateTimeZone('America/Toronto'));
        $start_date = $start_date->setTimezone(new DateTimeZone('UTC'));
        $start_date = $start_date->format('Y-m-d H:i');
        $end_date = strtotime('+1 day', $class->class_date);
        $end_date = date('Y-m-d H:i', $end_date);
        $end_date = new DateTime($end_date, new DateTimeZone('America/Toronto'));
        $end_date = $end_date->setTimezone(new DateTimeZone('UTC'));
        $end_date = $end_date->format('Y-m-d H:i');
        $class_attendees = array();
        $class_attendees_by_sms = array();
        if (!empty($class->class_attendees)) {
            $class_attendees = drupal_json_decode($class->class_attendees);
            $class_attendees = (array) $class_attendees;
        }
        $dir = libraries_get_path('twilio-php-master');
        require $dir . '/Twilio/autoload.php';

        $account_sid = variable_get('mcc_twilio_sid', 'ACec5c71dc7eef4cbf6c4046117b590206');
        $auth_token = variable_get('mcc_twilio_auth', 'd8b413ecd0f2bba8aca8917ed60f4535');
        $client = new Twilio\Rest\Client($account_sid, $auth_token);
        $messages = $client->messages->read(array(
            'To' => variable_get('mcc_twilio_number', '+16475592852'), //'+16475592852',
            'DateSentAfter' => $start_date, //'2017-03-14',
            'DateSentBefore' => $end_date, //'2017-03-16',
        ));

        $sms_senders = array();
        $sms_senders_name = array();
        foreach ($messages as $message) {
            if (strpos(strtolower($message->body), strtolower($code)) !== false) {
                $current_phone = (strlen($message->from) > 10) ? substr($message->from, -10) : $message->from;
                if (!in_array($current_phone, $sms_senders)) {
                    $sms_senders[] = $current_phone;
                    $sms_senders_name[$current_phone] = str_replace(strtolower($code), "", strtolower($message->body));
                }
            }
        }
        if (!empty($sms_senders)) {
            foreach ($sms_senders_name as $p_key => $p_val) {
                $class_attendees_by_sms['sms'][$p_key] = $p_val;
            }
            $total_presents = 0;
            $class_attendees['sms'] = $class_attendees_by_sms;
            $total_presents = sizeof($class_attendees_by_sms['sms']);
            if (!empty($class_attendees['manual'])) {
                $total_presents += count($class_attendees['manual']);
            }
            if (!empty($class_attendees_by_sms)) {
                $entity_name = MCCdb::MCC_EDU_COURSE_CLASS;
                $entities = entity_load($entity_name, array($class_id));
                $entity = reset($entities);
                $ew = entity_metadata_wrapper($entity_name, $entity);
                if ($total_presents > $activity->class_presents) {
                    $ew->class_presents = $total_presents;
                }
                $ew->class_attendees = drupal_json_encode($class_attendees);
                $ew->save();
                drupal_set_message('Updated This Class Attendees');
            }
        } else {
            drupal_set_message('No SMS found.');
        }
    }
    drupal_goto($redirect_to);
}

function mcc_common_course_class_delete($class_id) {
    $mccdb = new MCCdb();
    $mccdb->deleteClass($class_id);
    drupal_set_message('Class Deleted');
    $redirect_to = '/syllabus/course-classes';
    drupal_goto($redirect_to);
}

function mcc_common_course_class_edit($class_id) {
    $mccdb = new MCCdb();
    $class_details = $mccdb->getClassById($class_id);
    $vars['upload_form'] = drupal_get_form('course_class_form', $class_details);
    return theme('syllabus_upload_form_template', $vars);
//    echo '<pre>';
//    print_r($class_details);
//    echo '</pre>';
//    drupal_set_message('Class Deleted');
//    $redirect_to = '/syllabus/course-classes';
//    drupal_goto($redirect_to);
}

function mcc_common_course_instructors($form, &$form_state) {
    $form = array();
    global $user;
    $mccDB = new MCCdb();
    $syllabus_types = $mccDB->_get_syllabus_type();
    $academic_syllabus = array();

    $session_years = $mccDB->getSessionsYearsForCourseInst();

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
            'callback' => 'callback_instructors',
            'wrapper' => 'instructor-wrapper'
        )
    );
    $form['course_instructors'] = array(
        '#type' => 'markup',
        '#prefix' => '<div id="instructor-wrapper">',
        '#suffix' => '</div>',
    );
    if (!empty($form_state['values']['session_year'])) {
        $submitted_values = $form_state['values'];
        $result = array();
        $session_years_array = explode('###', $submitted_values['session_year']);
        if (!empty($session_years_array)) {
            list($session, $year) = $session_years_array;
            $vars['session'] = $session;
            $vars['year'] = $year;
            $result = $mccDB->getCourseInstructors($session, $year);
//            pretty_print($result, 0);
        }
        $vars['result'] = $result;
        $form['course_instructors']['#prefix'] = '<div id="instructor-wrapper"> ' . theme('syllabus_by_type_course_instructors', $vars);
    }
    return $form;
}

function callback_instructors($form, &$form_state) {
    return $form['course_instructors'];
}

function mcc_common_course_instructor_del($id) {
    $mccdb = new MCCdb();
    $mccdb->unassignInstructor($id);
    drupal_set_message('Instructor Unassigned Successfully.');
    $redirect_to = '/syllabus/course-instructor-list';
    drupal_goto($redirect_to);
}

function mcc_common_course_schedule_create() {
    global $user;
    if ($user->uid == 0) {
        drupal_set_message('Login First');
        drupal_goto('/');
    }
    if (_isFacultyOnly()) {
        drupal_goto('/');
    }
    $vars['upload_form'] = drupal_get_form('course_schedule_form');
    return theme('syllabus_upload_form_template', $vars);
}

function course_schedule_form($form, &$form_state) {
    $form = array();
    global $user;
    $mccDB = new MCCdb();
    $syllabus_types = $mccDB->_get_syllabus_type();
    $academic_syllabus = array();
    foreach ($syllabus_types as $key => $val) {
        $academic_syllabus = array_merge($academic_syllabus, $mccDB->getDepartmentsSubjects($key));
    }
    $form['course_code'] = array(
        '#type' => 'select',
        '#options' => $academic_syllabus,
        '#required' => TRUE,
        '#title' => 'Course',
    );
    $class_date_default = format_date(REQUEST_TIME, 'custom', 'Y-m-d H:i:s');
    $form['class_date'] = array(
        '#type' => 'date_select',
        '#title' => t('Date'),
        '#date_format' => 'm-d-Y H:i',
        '#default_value' => $class_date_default,
        '#value' => $class_date_default,
        '#date_year_range' => '-1:+1',
        '#required' => TRUE,
        '#date_type' => DATE_DATETIME,
        '#date_timezone' => date_default_timezone(),
        '#date_increment' => 1,
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save Class'),
    );

    return $form;
}

function course_schedule_form_submit($form, &$form_state) {
    $submitted_values = $form_state['values'];
    $mccDB = new MCCdb();
    global $user;
    $params = array();
    $params['course_code'] = $submitted_values['course_code'];
    $params['class_date'] = intval(strtotime(
                    $submitted_values['class_date']['year'] . '/' .
                    $submitted_values['class_date']['month'] . '/' .
                    $submitted_values['class_date']['day'] . ' ' .
                    $submitted_values['class_date']['hour'] . ':' .
                    $submitted_values['class_date']['minute'] . ':00'));
    $cc_id = $mccDB->setCourseSchedule($params);
    if ($cc_id) {
        drupal_goto('/syllabus/course-schedule');
    }
}

function mcc_common_course_schedule() {
    global $user;
    $mccdb = new MCCdb();
    _add_datatable_resources();
    if (arg(2) == 'datatable') {
        $data = null;
        $recordsTotal = 0;
        $recordsFiltered = 0;
        if (isset($_GET['start']) && $_GET['length'] != -1 && isset($_GET)) {
            $data = $mccdb->getCoursesScheduleLists($_GET['start'], $_GET['length'], $_GET);
            $recordsTotal = $mccdb->getCoursesScheduleCount();
            $recordsFiltered = $recordsTotal;
        } else {
            $data = $mccdb->getCoursesScheduleLists();
            $recordsTotal = $mccdb->getCoursesScheduleCount();
            $recordsFiltered = $recordsTotal;
        }
        echo json_encode(array(
            "draw" => isset($_GET['draw']) ?
                    intval($_GET['draw']) :
                    0,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ));
        exit(0);
    }
    return theme('syllabus_schedule_list_template', $vars);
}

function mcc_common_course_schedule_delete($class_id) {
    $mccdb = new MCCdb();
    $mccdb->deleteSchedule($class_id);
    drupal_set_message('Schedule Deleted');
    $redirect_to = '/syllabus/course-schedule';
    drupal_goto($redirect_to);
}
