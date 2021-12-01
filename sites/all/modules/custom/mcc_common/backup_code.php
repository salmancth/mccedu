<?php
$entity_type = EntityType::loadByName('mcc_edu_departments_bn');

$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('shortcode', 'shortcode',  'text');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_materials_bn');

$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('writer', 'writer',  'text');
$entity_type->addProperty('sub_id', 'sub_id',  'integer');
$entity_type->addProperty('text_or_ref', 'text_or_ref',  'text');
$entity_type->addProperty('uploaded_file_id', 'uploaded_file_id',  'integer');
$entity_type->addProperty('serial', 'serial',  'integer');
$entity_type->save();


$entity_type = EntityType::loadByName('mcc_edu_subjects_bn');

$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('code', 'code',  'text');
$entity_type->addProperty('dept_id', 'dept_id',  'integer');
$entity_type->addProperty('learning_objectives', 'learning_objectives',  'text_long');
$entity_type->addProperty('learning_objectives_details', 'learning_objectives_details',  'text_long');
$entity_type->addProperty('course_contents', 'course_contents',  'text_long');
$entity_type->addProperty('course_contents_details', 'course_contents_details',  'text_long');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_modules');

$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('sub_id', 'sub_id',  'integer');
$entity_type->addProperty('module_details', 'module_details',  'text_long');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_modules_materials');

$entity_type->addProperty('module_no', 'module_no',  'integer');
$entity_type->addProperty('sub_code', 'sub_code',  'text');
$entity_type->addProperty('file_id', 'file_id',  'integer');
$entity_type->save();

////////////


$entity_type = EntityType::loadByName('mcc_edu_syllabus_type_department');

$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('syllabus_type', 'syllabus_type',  'text');
$entity_type->addProperty('shortcode', 'shortcode',  'text');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_syllabus_type_subjects');

$entity_type->addProperty('syllabus_type', 'syllabus_type',  'text');
$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('code', 'code',  'text');
$entity_type->addProperty('dept_id', 'dept_id',  'integer');
$entity_type->addProperty('created', 'created',  'integer');
$entity_type->addProperty('learning_objectives', 'learning_objectives',  'text_long');
$entity_type->addProperty('learning_objectives_details', 'learning_objectives_details',  'text_long');
$entity_type->addProperty('course_contents', 'course_contents',  'text_long');
$entity_type->addProperty('course_contents_details', 'course_contents_details',  'text_long');
$entity_type->save();
  
$entity_type = EntityType::loadByName('mcc_edu_syllabus_type_modules');

$entity_type->addProperty('syllabus_type', 'syllabus_type',  'text');
$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('sub_id', 'sub_id',  'integer');
$entity_type->addProperty('module_details', 'module_details',  'text_long');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_sylbs_type_modules_materials');

$entity_type->addProperty('syllabus_type', 'syllabus_type',  'text');
$entity_type->addProperty('sub_code', 'sub_code',  'text');
$entity_type->addProperty('module_no', 'module_no',  'integer');
$entity_type->addProperty('file_id', 'file_id',  'integer');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_syllabus_type_materials');

$entity_type->addProperty('syllabus_type', 'syllabus_type',  'text');
$entity_type->addProperty('name', 'name',  'text');
$entity_type->addProperty('writer', 'writer',  'text');
$entity_type->addProperty('sub_id', 'sub_id',  'integer');
$entity_type->addProperty('text_or_ref', 'text_or_ref',  'text');
$entity_type->addProperty('uploaded_file_id', 'uploaded_file_id',  'integer');
$entity_type->addProperty('serial', 'serial',  'integer');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_questions_bank');

$entity_type->addProperty('sub_code', 'sub_code',  'text');
$entity_type->addProperty('module_no', 'module_no',  'integer');
$entity_type->addProperty('question', 'question',  'text');
$entity_type->addProperty('answers', 'answers',  'text_long');
$entity_type->addProperty('right_answer', 'right_answer',  'integer');
$entity_type->addProperty('uploaded_by', 'uploaded_by',  'integer');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_session_name');

$entity_type->addProperty('name', 'name',  'text');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_session_registration_det');

$entity_type->addProperty('session', 'session',  'text');
$entity_type->addProperty('user_id', 'user_id',  'integer');
$entity_type->addProperty('year', 'year',  'text');
$entity_type->addProperty('paid', 'paid',  'text');
$entity_type->addProperty('course_codes', 'course_codes',  'text_long');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_course_result');

$entity_type->addProperty('course_code', 'course_code',  'text');
$entity_type->addProperty('module', 'module',  'integer');
$entity_type->addProperty('score', 'score',  'decimal');
$entity_type->addProperty('user_id', 'user_id',  'integer');
$entity_type->addProperty('exam_date', 'exam_date',  'integer');
$entity_type->addProperty('next_possible_exam_date', 'next_possible_exam_date',  'integer');
$entity_type->addProperty('session', 'session',  'text');
$entity_type->addProperty('year', 'year',  'text');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_course_instructor');

$entity_type->addProperty('course_code', 'course_code',  'text');
$entity_type->addProperty('instructor_id', 'instructor_id',  'integer');
$entity_type->addProperty('session', 'session',  'text');
$entity_type->addProperty('year', 'year',  'text');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_course_class');

$entity_type->addProperty('course_code', 'course_code',  'text');
$entity_type->addProperty('sms_code', 'sms_code',  'text');
$entity_type->addProperty('instructor_id', 'instructor_id',  'integer');
$entity_type->addProperty('session', 'session',  'text');
$entity_type->addProperty('year', 'year',  'text');
$entity_type->addProperty('class_date', 'class_date',  'integer');
$entity_type->addProperty('class_doc', 'class_doc',  'integer');
$entity_type->addProperty('class_presents', 'class_presents',  'integer');
$entity_type->addProperty('class_details', 'class_details',  'text_long');
$entity_type->addProperty('class_attendees', 'class_attendees',  'text_long');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_course_url');

$entity_type->addProperty('course_code', 'course_code',  'text');
$entity_type->addProperty('course_url', 'course_url',  'text');
$entity_type->save();


$entity_type = EntityType::loadByName('mcc_edu_course_schedule');

$entity_type->addProperty('course_code', 'course_code',  'text');
$entity_type->addProperty('class_date', 'class_date',  'integer');
$entity_type->save();

$entity_type = EntityType::loadByName('mcc_edu_course_modules_active');

$entity_type->addProperty('course_code', 'course_code',  'text');
$entity_type->addProperty('module', 'module',  'integer');
$entity_type->addProperty('active_date', 'active_date',  'integer');
$entity_type->save();