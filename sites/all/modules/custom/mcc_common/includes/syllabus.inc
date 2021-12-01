<?php

include_once 'mcc.db.class.inc';

function mcc_common_upload_syllabus() {
  global $user;
  if ($user->uid == 0) {
    drupal_set_message('Login First');
    drupal_goto('/');
  }

  $vars['instruction'] = 'Instruction of PDF';
  if ('bangla' == arg(1))
    $vars['instruction'] = 'Upload Bangla Syllabus';
  $vars['upload_form'] = drupal_get_form('upload_form');
  return theme('syllabus_upload_form_template', $vars);
}

function upload_form($form, &$form_state) {
  $syllabus_doc_default = null;
  $form = array();

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
  //pretty_print($file);
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

  //die($tt.'=='.$sDirectoryName);
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
                  $title = strtolower($node->textContent);
                  if (strpos($title, 'introduction') === false &&
                    strpos($title, 'appendix') === false &&
                    strpos($title, 'materials') === false) {
                    $search_heading1 = false;
                    $search_heading2 = true;
                    $search_heading3 = false;
                    $search_listParagraph = false;

                    $dept = mb_convert_encoding($node->textContent, "HTML-ENTITIES", "UTF-8");
                    $dept = ucwords(strtolower(trim(str_replace('SYLLABUS', '', $dept))));
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
                  $subj_details[$dept]['dept_code'] = trim($codes_array[0]);
                  $subj_details[$dept][$sub_i]['name'] = trim($subject_array[1]);
                  $subj_details[$dept][$sub_i]['code'] = trim($codes_array[1]);
                }
                if ($pStyleVal == 'Heading3' && $search_heading3) {
                  $search_heading1 = false;
                  $search_heading2 = false;
                  $search_heading3 = true;
                  $search_listParagraph = true;
                  $heading3 = $node->textContent;
                }
                if ($pStyleVal == 'ListParagraph' && $search_listParagraph) {
                  $search_heading1 = true;
                  $search_heading2 = true;
                  $search_heading3 = true;
                  $search_listParagraph = true;
                  if (!empty($heading3)) {
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
  if (!empty($_SESSION['syllabus_data']))
    unset($_SESSION['syllabus_data']);
  $_SESSION['syllabus_data'] = $subj_details;
  drupal_set_message("Successfully Parsed.");
  $redirect_url = '/parse-syllabus/';
  drupal_goto($redirect_url);
}

function mcc_common_parse_syllabus() {
  $subj_details = $_SESSION['syllabus_data'];
  $vars['entry_form'] = drupal_get_form('syllabus_entry_form_auto', $subj_details);
  return theme('syllabus_entry_form_template', $vars);
}

function syllabus_entry_form_auto($form, &$form_state, $input_data) {
  //pretty_print($input_data);
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
    $form['dept_fieldset'][$dept_key]['dept_name'] = array(
      '#type' => 'textfield',
      '#multiple' => true,
      '#default_value' => _format_string($dept_key),
      '#title' => 'Deparment Name',
      '#prefix' => '<div class="col-md-6">',
      '#suffix' => '</div>'
    );
    $form['dept_fieldset'][$dept_key]['dept_short_code'] = array(
      '#type' => 'textfield',
      '#multiple' => true,
      '#default_value' => $dept_val['dept_code'],
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
        '#default_value' => _format_string($subject_details['name']),
        '#title' => 'Subject Name',
        '#prefix' => '<div class="col-md-6">',
        '#suffix' => '</div>'
      );
      $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_code'] = array(
        '#type' => 'textfield',
        '#multiple' => true,
        '#default_value' => _format_string($subject_details['code']),
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
        '#default_value' => _format_string(str_replace('<br/>', PHP_EOL, implode('<br/>', $subject_details['Learning Objectives']))),
        '#title' => 'Subject Learning Objectives',
        '#prefix' => '<div class="col-md-12"><div class="syllabus-textarea">',
        '#suffix' => '</div></div>'
      );
      $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_cc_mp'] = array(
        '#markup' => '<div class="col-md-12"><div class="syllabus-textarea"><b>Course Content</b></div></div>'
      );
//      $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_cc'] = array(
//        '#type' => 'textarea',
//        '#format' => 'full_html',
//        '#theme_wrappers' => array(),
//        '#multiple' => true,
//        '#default_value' => _format_string(str_replace('<br/>', PHP_EOL, implode('<br/>',$subject_details['Course Contents']))),
//        '#title' => 'Subject Course Contents',
//        '#prefix' => '<div class="col-md-12"><div class="syllabus-textarea">',
//        '#suffix' => '</div></div>'
//      );
      foreach ($subject_details['Course Contents'] as $cc_key => $cc) {
        $form['dept_fieldset'][$dept_key]['subj_fieldset'][$key]['subject_cc'][$cc_key] = array(
          '#type' => 'textarea',
          '#format' => 'full_html',
          '#theme_wrappers' => array(),
          '#multiple' => true,
          '#default_value' => $cc,
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
          '#default_value' => _format_string($text_mat),
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
          '#default_value' => _format_string($ref_mat),
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
  if ('bangla' == arg(1)) {
    $url_param = 'bangla';
    $lang = 'bn';
  }

  $submitted_data = $form_state['values']['dept_fieldset'];
  $mccdb = new MCCdb();
  $mccdb->deleteMaterials();
  $mccdb->deleteModulesMaterials();
  $mccdb->deleteModules();
  $mccdb->deleteSubjs();
  $mccdb->deleteDepts();
  foreach ($submitted_data as $key => $value) {
    $dept_name = addslashes($value['dept_name']);
    $dept_shortcode = $value['dept_short_code'];
    $dept = $mccdb->getDeparmentByNameCode($dept_name, $dept_shortcode, 'OR', $lang);
    $dept_array = array();
    $dept_array['name'] = $dept_name;
    $dept_array['shortcode'] = $dept_shortcode;
    if (!empty($dept)) {
      $dept = array_pop($dept);
      $dept_array['id'] = $dept->id;
    }
    $dept_id = $mccdb->setDepartment($dept_array, $lang);
    if (empty($dept_id))
      continue;
    foreach ($value as $dept_key => $dept_val) {
      if (is_array($dept_val)) {
        foreach ($dept_val as $sub_key => $sub_val) {
          //pretty_print($sub_val);
          $subj_array = array();
          $subj_array['name'] = addslashes($sub_val['subject_name']);
          $subj_array['code'] = $sub_val['subject_code'];
          $subj_array['dept_id'] = $dept_id;
          $subj_array['learning_objectives'] = (addslashes($sub_val['subject_lo']));
          //$subj_array['course_contents'] = (addslashes($sub_val['subject_cc']));
          $subj = $mccdb->getSubjectByNameCode($subj_array['name'], $subj_array['code'], 'OR', $dept_id, $lang);
          if (!empty($subj)) {
            $subj = array_pop($subj);
            $subj_array['id'] = $subj->id;
          }
          $subj_id = $mccdb->setSubject($subj_array, $lang);
          if (empty($subj_id))
            continue;
          if (is_array($sub_val['subject_cc'])) {
            foreach ($sub_val['subject_cc'] as $cc_key => $cc_val) {
              if (!empty($cc_val)) {
                $text_array = array();
                $text_array['name'] = 'Module ' . ($cc_key + 1);
                $text_array['sub_id'] = $subj_id;
                $text_array['module_details'] = $cc_val;
//                $text = $mccdb->getMaterialsByNameSuject($text_array['name'], $text_array['sub_id'], $lang);
//                if (!empty($text)) {
//                  $text = array_pop($text);
//                  $text_array['id'] = $text->id;
//                }
                $mccdb->setModules($text_array, $lang);
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
                $text = $mccdb->getMaterialsByNameSuject($text_array['name'], $text_array['sub_id'], $lang);
                if (!empty($text)) {
                  $text = array_pop($text);
                  $text_array['id'] = $text->id;
                }
                $mccdb->setMaterials($text_array, $lang);
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
                $ref = $mccdb->getMaterialsByNameSuject($ref_array['name'], $ref_array['sub_id'], $lang);
                if (!empty($ref)) {
                  $ref = array_pop($ref);
                  $ref_array['id'] = $ref->id;
                }
                $mccdb->setMaterials($ref_array, $lang);
              }
            }
          }
        }
      }
    }
  }
//  die('p');
  drupal_goto('/academic-syllabus/' . $url_param);
}

function mcc_common_academic_syllabus() {
  $url_param = '';
  $lang = '';
  if ('bangla' == arg(1)) {
    $lang = 'bn';
    $url_param = arg(1);
  }
  global $user;
  if (empty($user->uid))
    drupal_goto(404);
  $vars['edit_permission'] = false;
  if (user_access('create syllabus')) {
    $vars['edit_permission'] = true;
  }
  $mccdb = new MCCdb();
  $academic_syllabus = $mccdb->getDepartments($lang);
  //pretty_print($academic_syllabus);
  $vars['lang'] = $url_param;
  $vars['academic_syllabus'] = $academic_syllabus;
  return theme('syllabus_academic_list_template', $vars);
}

function mcc_common_academic_syllabus_brief() {
//  $url_param = '';
//  $lang = '';
//  if ('bangla' == arg(1)) {
//    $lang = 'bn';
//    $url_param = arg(1);
//  }
//  global $user;
//  if (empty($user->uid))
//    drupal_goto(404);
//  $mccdb = new MCCdb();
//  $academic_syllabus = $mccdb->getDepartments($lang);
//  //pretty_print($academic_syllabus);
//  $vars['lang'] = $url_param;
//  $vars['academic_syllabus'] = $academic_syllabus;
//  return theme('syllabus_academic_brief_list_template', $vars);

  $mccdb = new MCCdb();
  $syllabus_types = $mccdb->_get_syllabus_type();
//  pretty_print($syllabus_types);
  if (!empty($syllabus_types)) {
    foreach ($syllabus_types as $key => $val) {
      if ($key == 'general' && !user_access('inspect syllabus')) {
        continue;
      }
      drupal_goto('syllabus/academic-syllabus-brief-by-type/' . $key);
    }
  } else {
    drupal_goto('syllabus');
  }
}

function mcc_common_subject_details() {
  //pretty_print(arg(), 0)
  ctools_include('modal');
  ctools_modal_add_js();
  _add_pdf_js();
  global $user;
  if (empty($user->uid))
    drupal_goto(404);
  $sub_id = arg(2);
  $lang = '';
  $url_param = '';
  if ('bangla' == arg(3)) {
    $lang = 'bn';
    $url_param = arg(3);
  }
  $mccdb = new MCCdb();
  $sub_details = $mccdb->getSubjectById($sub_id, 2, $lang);
  if (!empty($sub_details)) {
    //$other_subjects = $mccdb->getSubjectByDept($dept_id);
    $sub_details = array_pop($sub_details);
    //pretty_print($sub_details, 0);
    $sub_materials_folder = $sub_details['subject']['dept_code'] . '-' . $sub_details['subject']['code'];
    $mainPath = $mccdb::MCC_EDU_AUDIO_VIDEO_URI_EN . $sub_materials_folder . '/';
    $uploaed_audio_video = $mccdb->getFilesByURI($mainPath . '%');
    $vars['uploaed_audio_video'] = $uploaed_audio_video;
    $mainTextMatPath = $mccdb::MCC_EDU_MATERIALS_URI_EN . $sub_materials_folder . '/text/';
    $uploaded_text = $mccdb->getFilesByURI($mainTextMatPath . '%');
    $vars['uploaded_text'] = $uploaded_text;
    $mainRefMatPath = $mccdb::MCC_EDU_MATERIALS_URI_EN . $sub_materials_folder . '/ref/';
    $uploaded_ref = $mccdb->getFilesByURI($mainRefMatPath . '%');
    $vars['uploaded_ref'] = $uploaded_ref;
    $vars['dept'] = '';
    $vars['module_materials'] = $mccdb->getModulesMaterialsBySubj($sub_materials_folder);
//    echo $sub_materials_folder;
//    pretty_print($vars['module_materials']);
    if (!empty($sub_details['subject']['dept_code'])) {
      $dept = $mccdb->getDeparmentByNameCode(NULL, trim($sub_details['subject']['dept_code']));
      if (!empty($dept))
        $vars['dept'] = array_pop($dept);
    }
    drupal_set_title($sub_details['subject']['code'] . ' ' . $sub_details['subject']['name']);
  }
  $vars['sub_details'] = $sub_details;
  $vars['lang'] = $url_param;
  return theme('syllabus_subject_details_template', $vars);
}

function mcc_common_edit_department() {
  global $user;
  if (empty($user->uid))
    drupal_goto(404);
  $dept_id = arg(2);
  $lang = '';
  $url_param = '';
  if ('bangla' == arg(3)) {
    $lang = 'bn';
    $url_param = arg(3);
  }
  $mccdb = new MCCdb();
  $department_details = $mccdb->getDeparmentById($dept_id, 3, $lang);

  $vars['entry_form'] = drupal_get_form('syllabus_entry_form_edit', $department_details);
  return theme('syllabus_entry_form_template', $vars);
}

function syllabus_entry_form_edit($form, &$form_state, $input_data) {
  //pretty_print($input_data);
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
  $lang = '';
  $url_param = '';
  if ('bangla' == arg(3)) {
    $lang = 'bn';
    $url_param = arg(3);
  }
  $submitted_data = $form_state['values']['dept_fieldset'];
  $mccdb = new MCCdb();
  $dept_array = array();
  $dept_array['name'] = addslashes(trim($submitted_data['dept_name']));
  $dept_array['shortcode'] = $submitted_data['dept_short_code'];
  $dept_array['id'] = $submitted_data['dept_id'];
  $delSubs = false;
  if (empty($dept_array['name'])) {
    $mccdb->delDeptById($dept_array['id'], $lang);
    $delSubs = true;
    watchdog('EDU-DEL', 'Deleting Dept ' . $dept_array['id']);
  } else {
    $dept_id = $mccdb->setDepartment($dept_array, $lang);
  }
  if (!empty($dept_id) || $delSubs) {
    foreach ($submitted_data['subj_fieldset'] as $key => $value) {
      $delMats = false;
      $delMods = false;
      $subj_array = array();
      $subj_array['name'] = addslashes(trim($value['subject_name']));

      if (empty($subj_array['name']) || $delSubs) {
        $mccdb->delSubjectById($value['subject_id'], $lang);
        $delMats = true;
        $delMods = true;
        watchdog('EDU-DEL', 'Deleting Sub ' . $value['subject_id']);
      } else {
        $subj_array['code'] = trim($value['subject_code']);
        $subj_array['dept_id'] = $dept_id;
        $subj_array['learning_objectives'] = addslashes($value['subject_lo']);
        $subj_array['learning_objectives_details'] = addslashes($value['subject_lo_details']);
//        $subj_array['course_contents'] = addslashes($value['subject_cc']);
//        $subj_array['course_contents_details'] = addslashes($value['subject_cc_details']);
        $subj_array['id'] = $value['subject_id'];
        $subj_id = $mccdb->setSubject($subj_array, $lang);
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
              $mccdb->delModuleById($id, $lang);
            } else {
              //$text_array['name'] = 'Module ' . ($cc_count+1);
              $text_array['sub_id'] = $subj_id;
              $mccdb->setModules($text_array, $lang);
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
              $mccdb->delMaterialById($text_key, $lang);
              watchdog('EDU-DEL', 'Deleting TExt ' . $text_key);
            } else {
              $text_array['sub_id'] = $subj_id;
              $text_array['text_or_ref'] = 'text';
              $text_array['serial'] = $text_count++;
              $mccdb->setMaterials($text_array, $lang);
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
              $mccdb->delMaterialById($text_key, $lang);
              watchdog('EDU-DEL', 'Deleting Ref ' . $text_key);
            } else {
              $text_array['sub_id'] = $subj_id;
              $text_array['text_or_ref'] = 'ref';
              $text_array['serial'] = $text_count++;
              $mccdb->setMaterials($text_array, $lang);
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
  $subjects_codes = array();
  $mccdb = new MCCdb();
  $lang = '';
  $academic_syllabus = $mccdb->getDepartments($lang);
  if (!empty($academic_syllabus['deparments'])) {
    foreach ($academic_syllabus['deparments'] as $depts) {
      if (!empty($depts['department']['subjects'])) {
        foreach ($depts['department']['subjects'] as $subjs) {
          $subjects_codes[$subjs['subject']['id'] . '#' . $depts['department']['code'] . '-' . $subjs['subject']['code']] = $depts['department']['code'] . '-' . $subjs['subject']['code'];
        }
      }
    }
  }

  $vars['instruction'] = 'Upload Module\'s Materials';
  $vars['upload_form'] = drupal_get_form('module_content_upload_form', $subjects_codes);
  return theme('syllabus_upload_form_template', $vars);
}

function module_content_upload_form($form, &$form_state, $subjects_codes) {
  _add_datatable_resources();
  $form = array();
  $mccdb = new MCCdb();
  global $base_url;
  $mainPath = $mccdb::MCC_EDU_MODULE_MATERIALS_URI_EN;
  $uploaed_materials = $mccdb->getFilesByURI($mainPath . '%');
  $vars['uploaed_materials'] = $uploaed_materials;
  $vars['module_content'] = true;
  $vars['remove_materials_url'] = '/academic-syllabus/remove-module-content/';
  $form['subject'] = array(
    '#type' => 'select',
    '#options' => $subjects_codes,
    '#required' => TRUE,
    '#title' => 'Select Subject',
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
    $modules_array = $mccdb->getModulesBySubj($sub_id);
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

function get_subject_modules($form, $form_state) {
  $form_state['rebuild'] = TRUE;
  return $form['module'];
}

function module_content_upload_form_submit($form, &$form_state) {
  //pretty_print($form_state['values']);
  $data = array();
  $sub_details = $form_state['values']['subject'];
  $sub_details = explode('#', $sub_details);
  $sub_code = $sub_details[1];
  $mccdb = new MCCdb();

  $scheme = $mccdb::MCC_EDU_MODULE_MATERIALS_URI_EN . '/';
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
    $mccdb->setModulesMaterial($data);
    drupal_set_message($file_value['name'] . ' uploaded successfully.');
  }
}

function mcc_common_remove_module_content() {
  $file_id = arg(2);
  $file = file_load($file_id);
  $status = file_delete($file);
  $mccdb = new MCCdb();
  $mccdb->delModuleMaterialByFId($file_id);
  if ($status) {
    drupal_set_message('Removed Successfully');
  }
  drupal_goto('/academic-syllabus/upload-modules-materials');
}

function mcc_common_upload_materials() {
  ini_set('memory_limit', '256M');
  ini_set('upload_max_filesize', '128M');
  ini_set('post_max_size', '128M');
  global $user;
  if ($user->uid == 0) {
    drupal_set_message('Login First');
    drupal_goto('/');
  }
  $subjects_codes = array();
  $mccdb = new MCCdb();
  $lang = '';
  $academic_syllabus = $mccdb->getDepartments($lang);
  if (!empty($academic_syllabus['deparments'])) {
    foreach ($academic_syllabus['deparments'] as $depts) {
      if (!empty($depts['department']['subjects'])) {
        foreach ($depts['department']['subjects'] as $subjs) {
          $subjects_codes[$depts['department']['code'] . '-' . $subjs['subject']['code']] = $depts['department']['code'] . '-' . $subjs['subject']['code'];
        }
      }
    }
  }
  $vars['instruction'] = 'Upload Materials (PDF, DOC, DOCX, PPT, PPTX)';
  $vars['upload_form'] = drupal_get_form('materials_upload_form', $subjects_codes);
  return theme('syllabus_upload_form_template', $vars);
}

function materials_upload_form($form, &$form_state, $subjects_codes) {
  _add_datatable_resources();
  $form = array();
  $mccdb = new MCCdb();
  global $base_url;
  $mainPath = $mccdb::MCC_EDU_MATERIALS_URI_EN;
  $uploaed_materials = $mccdb->getFilesByURI($mainPath . '%');
  $vars['uploaed_materials'] = $uploaed_materials;
  $vars['text_ref_materials'] = true;
  $vars['remove_materials_url'] = '/academic-syllabus/remove-material/';
  $form['materials_folder'] = array(
    '#type' => 'select',
    '#options' => $subjects_codes,
    '#required' => TRUE,
    '#title' => 'Select Subject'
  );
  $form['materials_type'] = array(
    '#type' => 'select',
    '#options' => array('text' => 'Text', 'ref' => 'Reference'),
    '#required' => TRUE,
    '#title' => 'Type'
  );

  $form['academic_materials'] = array(
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

function materials_upload_form_submit($form, &$form_state) {
  $mccdb = new MCCdb();

  $scheme = $mccdb::MCC_EDU_MATERIALS_URI_EN .
    $form_state['values']['materials_folder'] .
    '/' .
    $form_state['values']['materials_type'] .
    '/';
  file_prepare_directory($scheme, FILE_CREATE_DIRECTORY);
  $submitted_files = $form_state['values']['academic_materials'];
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
  drupal_goto('/academic-syllabus/upload-materials');
}

function mcc_common_upload_audio_vedio() {
  $lang = '';
  global $user;
  if ($user->uid == 0) {
    drupal_set_message('Login First');
    drupal_goto('/');
  }
  $subjects_codes = array();
  $mccdb = new MCCdb();
  $academic_syllabus = $mccdb->getDepartments($lang);
  if (!empty($academic_syllabus['deparments'])) {
    foreach ($academic_syllabus['deparments'] as $depts) {
      if (!empty($depts['department']['subjects'])) {
        foreach ($depts['department']['subjects'] as $subjs) {
          $subjects_codes[$depts['department']['code'] . '-' . $subjs['subject']['code']] = $depts['department']['code'] . '-' . $subjs['subject']['code'];
        }
      }
    }
  }
  $vars['instruction'] = 'Upload Materials (MP4)';
  $vars['upload_form'] = drupal_get_form('audio_video_upload_form', $subjects_codes);
  return theme('syllabus_upload_form_template', $vars);
}

function audio_video_upload_form($form, &$form_state, $subjects_codes) {
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
  $mainPath = $mccdb::MCC_EDU_AUDIO_VIDEO_URI_EN; //'public://mcc_syllabus/audio_video/';  
  $uploaed_audio_video = $mccdb->getFilesByURI($mainPath . '%');
  $vars['uploaed_audio_video'] = $uploaed_audio_video;
  $vars['remove_url'] = '/academic-syllabus/remove-audio-video/';

  $form['materials_folder'] = array(
    '#type' => 'select',
    '#options' => $subjects_codes,
    '#required' => TRUE,
    '#title' => 'Select Subject'
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
  //$scheme = 'public://mcc_syllabus/audio_video/'.$form_state['values']['materials_folder'].'/';
  $scheme = $mccdb::MCC_EDU_AUDIO_VIDEO_URI_EN . $form_state['values']['materials_folder'] . '/';
  file_prepare_directory($scheme, FILE_CREATE_DIRECTORY);
  $submitted_files = $form_state['values']['audio_video_materials'];
//  pretty_print($_FILES);
  foreach ($submitted_files as $file_key => $file_value) {
    $source = $file_value['tmppath'];
//    $source = $temp_path.DIRECTORY_SEPARATOR.$file_value['tmpname'];
    $destination = file_stream_wrapper_uri_normalize($scheme . $file_value['name']);
//    $destination = file_stream_wrapper_uri_normalize($scheme);
//    $tt = move_uploaded_file($source, drupal_realpath($destination));
//    $tt = drupal_move_uploaded_file($source, drupal_realpath($destination));
//    $tt = drupal_move_uploaded_file($source, $destination);
//    die(drupal_realpath($destination).'-pp-'.$source.'='.$tt);
//    watchdog('AV', 'uploading-'.$file_value['tmppath'].' to '.drupal_realpath($destination));
//    $tt1 = move_uploaded_file($file_value['tmppath'], drupal_realpath($destination));
//    $destination_path = getcwd().DIRECTORY_SEPARATOR;
//    die($destination_path.'==');
//    $dd = file_save_upload($file_value['tmppath'], array(),$destination);
//    pretty_print($dd);
//    file_move($source, $destination);
//    die('--'.$uri);
//    // Rename it to its original name, and put it in its final home.
//    // Note - not using file_move here because if we call file_get_mime
//    // (in file_uri_to_object) while it has a .tmp extension, it horks.
    watchdog('AV', '1-<pre>' . print_r($destination, 1) . '</pre>');
    $destination = file_unmanaged_move($source, $destination, FILE_EXISTS_REPLACE);
//    pretty_print($destination);
//    $query = db_insert('file_managed')
//      ->fields(array(
//        'filename' => $file_value['tmpname'],
//        'uri' => $destination,
//        'status' => 1
//      ));
//    $query->execute();
//    $file = plupload_file_uri_to_object($destination);
//    if (!empty($file)) {
//      $file = file_save($file);
//      drupal_set_message($file_value['name'] . ' uploaded successfully.');
//    } else {
//    }
    watchdog('AV', '2-<pre>' . print_r($destination, 1) . '</pre>');
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
  drupal_goto('/academic-syllabus/upload-audio-video');
}

function mcc_common_read_pdf($ajax, $fid) {
  if ($ajax) {
    ctools_include('ajax');
    ctools_include('modal');
//    _add_pdf_js();
    $file = file_load($fid);

    $file_url = file_create_url($file->uri);
    $ext = pathinfo($file_url, PATHINFO_EXTENSION);
    $vars['file_url'] = $file_url;
    if (strtolower($ext) == 'pdf') {
      $popup_title = t('PDF');
      $vars['file_type'] = 'pdf';
    } else {
      $popup_title = t('Doc');
      $vars['file_type'] = 'doc';
    }
    ctools_modal_render($popup_title, theme('pdf_view_template', $vars));
    drupal_exit();
  } else {
    $vars['file_url'] = file_create_url($file->uri);
    return theme('pdf_view_template', $vars);
  }
}
