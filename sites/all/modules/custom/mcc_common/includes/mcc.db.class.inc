<?php

class MCCdb {

    const MCC_EDU_DEPARTMENTS = 'mcc_edu_departments';
    const MCC_EDU_SUBJECTS = 'mcc_edu_subjects';
    const MCC_EDU_MATERIALS = 'mcc_edu_materials';
    const MCC_EDU_MODULES = 'mcc_edu_modules';
    const MCC_EDU_MODULES_MATERIALS = 'mcc_edu_modules_materials';
    const MCC_EDU_DEPARTMENTS_BN = 'mcc_edu_departments_bn';
    const MCC_EDU_SUBJECTS_BN = 'mcc_edu_subjects_bn';
    const MCC_EDU_MATERIALS_BN = 'mcc_edu_materials_bn';
    const MCC_EDU_AUDIO_VIDEO_URI_EN = 'public://mcc_syllabus/audio_video/';
    const MCC_EDU_MATERIALS_URI_EN = 'public://mcc_syllabus/materials/';
    const MCC_EDU_MODULE_MATERIALS_URI_EN = 'public://mcc_syllabus/module/materials/';
    const MCC_EDU_MODULE_MATERIALS_URI_SYLLABUS_TYPE = 'public://mcc_syllabus/module/materials';
    const MCC_EDU_MATERIALS_URI_SYLLABUS_TYPE = 'public://mcc_syllabus/materials';
    const MCC_EDU_AUDIO_VIDEO_URI_SYLLABUS_TYPE = 'public://mcc_syllabus/audio_video';
    const MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS = 'mcc_edu_syllabus_type_department';
    const MCC_EDU_SYLLABUS_TYPE_SUBJECTS = 'mcc_edu_syllabus_type_subjects';
    const MCC_EDU_SYLLABUS_TYPE_MODULES_MATERIALS = 'mcc_sylbs_type_modules_materials';
    const MCC_EDU_SYLLABUS_TYPE_MODULES = 'mcc_edu_syllabus_type_modules';
    const MCC_EDU_SYLLABUS_TYPE_MATERIALS = 'mcc_edu_syllabus_type_materials';
    const MCC_EDU_QUESTIONS_BANK = 'mcc_questions_bank';
    const MCC_EDU_SESSION_NAME = 'mcc_edu_session_name';
    const MCC_EDU_SESSION_REGISTRATION_DETAILS = 'mcc_edu_session_registration_det';
    const MCC_EDU_COURSE_RESULT = 'mcc_edu_course_result';
    const MCC_EDU_COURSE_INSTRUCTOR = 'mcc_edu_course_instructor';
    const MCC_EDU_COURSE_CLASS = 'mcc_edu_course_class';
    const MCC_EDU_COURSE_URL = 'mcc_edu_course_url';
    const MCC_EDU_COURSE_SCHEDULE = 'mcc_edu_course_schedule';
    const MCC_EDU_COURSE_MODULES_ACTIVE_INACTIVE = 'mcc_edu_course_modules_active';
    const MCC_QB_NUMBER_OF_QUESTION = 5;
    const ROLE_ADMIN_ID = 3;
    const ROLE_ADMIN_NAME = 'administrator';
    const ROLE_EDITOR_ID = 8;
    const ROLE_EDITOR_NAME = 'special user';
    const ROLE_FACULTY_ID = 9;
    const ROLE_FACULTY_NAME = 'faculty';

    /**
     * 
     * @param type $id
     * @param type $level
     * $level may have value 1, 2 or 3
     * 1 = only department
     * 2 = with subjects
     * 3 = with subjects' materials
     */
    function getDeparmentById($id, $level, $lan = '') {
        $entity_name = constant('self::MCC_EDU_DEPARTMENTS');
        if ($lan == 'bn')
            $entity_name = constant('self::MCC_EDU_DEPARTMENTS_BN');
        $total_result = null;
        $entities = entity_load($entity_name, array($id));
        foreach ($entities as $dept_key => $dept_val) {
            $total_result['id'] = $dept_val->id;
            $total_result['name'] = $dept_val->name;
            $total_result['code'] = $dept_val->shortcode;
            $total_result['subjects'] = $this->getSubjectByDept($dept_val->id, $lan);
        }
        return $total_result;
    }

    function getDeparmentByNameCode($name = null, $code = null, $op = null, $lan = '') {
        $table_name = 'eck_' . constant('self::MCC_EDU_DEPARTMENTS');
        if ($lan == 'bn')
            $table_name = 'eck_' . constant('self::MCC_EDU_DEPARTMENTS_BN');
        $table_where = '';
        if ($op === 'AND' && !empty($name) && !empty($code)) {
            $table_where = "WHERE name='" . $name . "' AND shortcode='" . $code . "'";
        } else if ($op === 'OR' && !empty($name) && !empty($code)) {
            $table_where = "WHERE name='" . $name . "' OR shortcode='" . $code . "'";
        } else {
            if (!empty($name)) {
                $table_where = "WHERE name='" . $name . "'";
            } else if (!empty($code)) {
                $table_where = "WHERE shortcode='" . $code . "'";
            }
        }
        $sql = "SELECT id, name, shortcode from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function getDeparmentCodeByID($id, $lan = '') {
        $table_name = 'eck_' . constant('self::MCC_EDU_DEPARTMENTS');
        if ($lan == 'bn')
            $table_name = 'eck_' . constant('self::MCC_EDU_DEPARTMENTS_BN');
        $table_where = "WHERE id='$id'";
        $sql = "SELECT shortcode from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchColumn();
        return $result;
    }

    function setDepartment($data = array(), $lan = '') {
        $entity_name = constant('self::MCC_EDU_DEPARTMENTS');
        if ($lan == 'bn')
            $entity_name = constant('self::MCC_EDU_DEPARTMENTS_BN');
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
        if (!empty($data['name'])) {
            $ew->name = $data['name'];
            if (!empty($data['shortcode']))
                $ew->shortcode = $data['shortcode'];
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getDepartments($lan = '') {
        $entity_name = constant('self::MCC_EDU_DEPARTMENTS');
        if ($lan == 'bn')
            $entity_name = constant('self::MCC_EDU_DEPARTMENTS_BN');
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $dept_key => $dept_val) {
            $total_result['deparments'][$dept_key]['department']['id'] = $dept_val->id;
            $total_result['deparments'][$dept_key]['department']['name'] = stripslashes($dept_val->name);
            $total_result['deparments'][$dept_key]['department']['code'] = $dept_val->shortcode;
            $total_result['deparments'][$dept_key]['department']['subjects'] = $this->getSubjectByDept($dept_val->id, $lan);
        }
        return $total_result;
    }

    function delDeptById($id, $lan = '') {
        $query = new EntityFieldQuery();
        $entity_type = constant('self::MCC_EDU_DEPARTMENTS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_DEPARTMENTS_BN');
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    /**
     * 
     * @param type $id
     * @param type $level
     * $level may have value 1 or 2
     * 1 = only subject
     * 2 = with subject's materials
     */
    function getSubjectById($id, $level, $lan = '') {
        $entity_type = constant('self::MCC_EDU_SUBJECTS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_SUBJECTS_BN');
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        foreach ($entities as $sub_key => $sub_val) {
            $total_result[$sub_key]['subject']['id'] = $sub_val->id;
            $total_result[$sub_key]['subject']['name'] = stripslashes($sub_val->name);
            $total_result[$sub_key]['subject']['code'] = $sub_val->code;
            $total_result[$sub_key]['subject']['dept_id'] = $sub_val->dept_id;
            $total_result[$sub_key]['subject']['dept_code'] = $this->getDeparmentCodeByID($sub_val->dept_id, $lan);
            $total_result[$sub_key]['subject']['learning_objectives'] = stripslashes($sub_val->learning_objectives);
            $total_result[$sub_key]['subject']['learning_objectives_details'] = stripslashes($sub_val->learning_objectives_details);
            $total_result[$sub_key]['subject']['course_contents'] = $this->getModulesBySubj($sub_val->id, $lan);
//      $total_result[$sub_key]['subject']['course_contents'] = stripslashes($sub_val->course_contents);
//      $total_result[$sub_key]['subject']['course_contents_details'] = stripslashes($sub_val->course_contents_details);
            if ($level == 2) {
                $total_result[$sub_key]['subject']['text'] = $this->getMaterialsBySubj($sub_val->id, 'text', $lan);
                $total_result[$sub_key]['subject']['ref'] = $this->getMaterialsBySubj($sub_val->id, 'ref', $lan);
            }
        }
        return $total_result;
    }

    function getSubjectByDept($dept_id, $lan = '') {
        $entity_type = constant('self::MCC_EDU_SUBJECTS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_SUBJECTS_BN');
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('dept_id', $dept_id, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        foreach ($entities as $sub_key => $sub_val) {
            $total_result[$sub_key]['subject']['id'] = $sub_val->id;
            $total_result[$sub_key]['subject']['name'] = stripslashes($sub_val->name);
            $total_result[$sub_key]['subject']['code'] = $sub_val->code;
            $total_result[$sub_key]['subject']['dept_id'] = $sub_val->dept_id;
            $total_result[$sub_key]['subject']['learning_objectives'] = stripslashes($sub_val->learning_objectives);
            $total_result[$sub_key]['subject']['learning_objectives_details'] = stripslashes($sub_val->learning_objectives_details);
//      $total_result[$sub_key]['subject']['course_contents'] = stripslashes($sub_val->course_contents);
//      $total_result[$sub_key]['subject']['course_contents_details'] = stripslashes($sub_val->course_contents_details);
            $total_result[$sub_key]['subject']['course_contents'] = $this->getModulesBySubj($sub_val->id, $lan);
            $total_result[$sub_key]['subject']['text'] = $this->getMaterialsBySubj($sub_val->id, 'text', $lan);
            $total_result[$sub_key]['subject']['ref'] = $this->getMaterialsBySubj($sub_val->id, 'ref', $lan);
        }
        return $total_result;
    }

    function getSubjectByNameCode($name = null, $code = null, $op, $dept_id, $lan = '') {
        $table_name = 'eck_' . constant('self::MCC_EDU_SUBJECTS');
        if ($lan == 'bn')
            $table_name = 'eck_' . constant('self::MCC_EDU_SUBJECTS_BN');
        $table_where = " WHERE dept_id='$dept_id'";
        if ($op === 'AND' && !empty($name) && !empty($code)) {
            $table_where .= " AND name='" . $name . "' AND code='" . $code . "'";
        } else if ($op === 'OR' && !empty($name) && !empty($code)) {
            $table_where .= " AND (name='" . $name . "' OR code='" . $code . "')";
        } else {
            if (!empty($name)) {
                $table_where .= " AND name='" . $name . "'";
            } else if (!empty($code)) {
                $table_where .= " AND code='" . $code . "'";
            }
        }
        $sql = "SELECT id, name, code from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function setSubject($data, $lan = '') {
        $entity_type = constant('self::MCC_EDU_SUBJECTS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_SUBJECTS_BN');
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['name'])) {
            $ew->name = $data['name'];
            if (!empty($data['code']))
                $ew->code = $data['code'];
            if (!empty($data['dept_id']))
                $ew->dept_id = $data['dept_id'];
            if (!empty($data['learning_objectives']))
                $ew->learning_objectives = nl2br($data['learning_objectives']);
            if (!empty($data['course_contents']))
                $ew->course_contents = nl2br($data['course_contents']);
            if (!empty($data['learning_objectives_details']))
                $ew->learning_objectives_details = nl2br($data['learning_objectives_details']);
            if (!empty($data['course_contents_details']))
                $ew->course_contents_details = nl2br($data['course_contents_details']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function delSubjectById($id, $lan = '') {
        $query = new EntityFieldQuery();
        $entity_type = constant('self::MCC_EDU_SUBJECTS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_SUBJECTS_BN');
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function getMaterialsByNameSuject($name, $subject_id, $lan = '') {
        $table_name = 'eck_' . constant('self::MCC_EDU_MATERIALS');
        if ($lan == 'bn')
            $table_name = 'eck_' . constant('self::MCC_EDU_MATERIALS_BN');
        $table_where = " WHERE sub_id='$subject_id' AND name LIKE '%" . addslashes($name) . "'";
        $sql = "SELECT id, name from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function setMaterials($data, $lan = '') {
        $entity_type = constant('self::MCC_EDU_MATERIALS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_MATERIALS_BN');
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['name'])) {
            $ew->name = $data['name'];
            if (!empty($data['writer']))
                $ew->writer = $data['writer'];
            if (!empty($data['sub_id']))
                $ew->sub_id = $data['sub_id'];
            if (!empty($data['text_or_ref']))
                $ew->text_or_ref = $data['text_or_ref'];
            if (!empty($data['serial']))
                $ew->serial = $data['serial'];
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getMaterialsBySubj($sub_id, $text_or_ref, $lan = '') {
        $entity_type = constant('self::MCC_EDU_MATERIALS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_MATERIALS_BN');
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('sub_id', $sub_id, '=')
                ->propertyCondition('text_or_ref', $text_or_ref, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        if (!empty($entities)) {
            foreach ($entities as $mat_key => $mat_val) {
                $total_result[$mat_key]['material']['id'] = $mat_val->id;
                $total_result[$mat_key]['material']['name'] = stripslashes($mat_val->name);
                $total_result[$mat_key]['material']['writer'] = $mat_val->writer;
                $total_result[$mat_key]['material']['sub_id'] = $mat_val->sub_id;
                $total_result[$mat_key]['material']['text_or_ref'] = $mat_val->text_or_ref;
                $total_result[$mat_key]['material']['uploaded_file_id'] = $mat_val->uploaded_file_id;
                $total_result[$mat_key]['material']['serial'] = $mat_val->serial;
            }
        }
        return $total_result;
    }

    function delMaterialById($id, $lan = '') {
        $query = new EntityFieldQuery();
        $entity_type = constant('self::MCC_EDU_MATERIALS');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_MATERIALS_BN');
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

//  function getModulesBySuject($subject_id, $lan = '') {
//    $table_name = 'eck_' . constant('self::MCC_EDU_MODULES');
//    if ($lan == 'bn')
//      $table_name = 'eck_' . constant('self::MCC_EDU_MODULES_BN');
//    $table_where = " WHERE sub_id='$subject_id'";
//    $sql = "SELECT id, name from {$table_name} " . $table_where;
//    $result = db_query($sql)->fetchAll();
//    return $result;
//  }

    function setModules($data, $lan = '') {
        $entity_type = constant('self::MCC_EDU_MODULES');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_MODULES_BN');
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['module_details'])) {
            $ew->module_details = check_plain($data['module_details']);
            if (!empty($data['sub_id']))
                $ew->sub_id = intval($data['sub_id']);
            if (!empty($data['name']))
                $ew->name = check_plain($data['name']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getModulesBySubj($sub_id, $lan = '') {
        $entity_type = constant('self::MCC_EDU_MODULES');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_MODULES_BN');
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('sub_id', $sub_id, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        if (!empty($entities)) {
            foreach ($entities as $mod_key => $mod_val) {
                $total_result[$mod_key]['module']['id'] = $mod_val->id;
                $total_result[$mod_key]['module']['sub_id'] = $mod_val->sub_id;
                $total_result[$mod_key]['module']['name'] = decode_entities($mod_val->name);
                $total_result[$mod_key]['module']['module_details'] = decode_entities($mod_val->module_details);
            }
        }
        return $total_result;
    }

    function delModuleById($id, $lan = '') {
        $query = new EntityFieldQuery();
        $entity_type = constant('self::MCC_EDU_MODULES');
        if ($lan == 'bn')
            $entity_type = constant('self::MCC_EDU_MODULES_BN');
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function setModulesMaterial($data, $lan = '') {
        $entity_type = constant('self::MCC_EDU_MODULES_MATERIALS');
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['file_id'])) {
            $ew->file_id = intval($data['file_id']);
            if (!empty($data['sub_code']))
                $ew->sub_code = check_plain($data['sub_code']);
            if (!empty($data['module_no']))
                $ew->module_no = intval($data['module_no']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getModulesMaterialsBySubj($sub_code, $lan = '') {
        $entity_type = constant('self::MCC_EDU_MODULES_MATERIALS');
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('sub_code', $sub_code, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        if (!empty($entities)) {
            foreach ($entities as $mod_key => $mod_val) {
                $total_result[$mod_key]['module_mat']['id'] = $mod_val->id;
                $total_result[$mod_key]['module_mat']['sub_code'] = $mod_val->sub_code;
                $total_result[$mod_key]['module_mat']['module_no'] = $mod_val->module_no;
                if (!empty($mod_val->file_id))
                    $total_result[$mod_key]['module_mat']['file'] = file_load($mod_val->file_id);
            }
        }
        return $total_result;
    }

    function delModuleMaterialById($id, $lan = '') {
        $query = new EntityFieldQuery();
        $entity_type = constant('self::MCC_EDU_MODULES_MATERIALS');
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function delModuleMaterialByFId($id, $lan = '') {
        $query = new EntityFieldQuery();
        $entity_type = constant('self::MCC_EDU_MODULES_MATERIALS');
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('file_id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function getFilesByURI($uri) {
        $query = "SELECT fm.filename, fm.uri, fm.fid FROM file_managed fm WHERE "
                . "fm.uri LIKE :uri";
        $results = db_query($query, array(':uri' => $uri))->fetchAll();
        return $results;
    }

    function deleteDepts() {
        $entity_type = constant('self::MCC_EDU_DEPARTMENTS');
        $results = entity_load($entity_type);
        $entity_ids = array_keys($results);
        entity_delete_multiple($entity_type, $entity_ids);
    }

    function deleteSubjs() {
        $entity_type = constant('self::MCC_EDU_SUBJECTS');
        $results = entity_load($entity_type);
        $entity_ids = array_keys($results);
        entity_delete_multiple($entity_type, $entity_ids);
    }

    function deleteMaterials() {
        $entity_type = constant('self::MCC_EDU_MATERIALS');
        $results = entity_load($entity_type);
        $entity_ids = array_keys($results);
        entity_delete_multiple($entity_type, $entity_ids);
    }

    function deleteModules() {
        $entity_type = constant('self::MCC_EDU_MODULES');
        $results = entity_load($entity_type);
        $entity_ids = array_keys($results);
        entity_delete_multiple($entity_type, $entity_ids);
    }

    function deleteModulesMaterials() {
        $entity_type = self::MCC_EDU_MODULES_MATERIALS;
        $results = entity_load($entity_type);
        $entity_ids = array_keys($results);
        entity_delete_multiple($entity_type, $entity_ids);
    }

    function _get_syllabus_type() {
        return array(
            'general' => 'General Syllabus',
            'bangla' => 'Bangla Syllabus',
            'short' => 'Short Courses',
        );
    }

    function deleteDeptsBySyllabusType($syllabus_type) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type);
        $query->propertyCondition('syllabus_type', $syllabus_type);
        ;
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
        }
        entity_delete_multiple($entity_type, $entities_ids);
    }

    function deleteSubjsBySyllabusType($syllabus_type) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_SUBJECTS;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type);
        $query->propertyCondition('syllabus_type', $syllabus_type);
        ;
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
        }
        entity_delete_multiple($entity_type, $entities_ids);
    }

    function deleteModulesMaterialsBySyllabusType($syllabus_type) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES_MATERIALS;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type);
        $query->propertyCondition('syllabus_type', $syllabus_type);
        ;
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
        }
        entity_delete_multiple($entity_type, $entities_ids);
    }

    function deleteModulesBySyllabusType($syllabus_type) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type);
        $query->propertyCondition('syllabus_type', $syllabus_type);
        ;
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
        }
        entity_delete_multiple($entity_type, $entities_ids);
    }

    function deleteMaterialsBySyllabusType($syllabus_type) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MATERIALS;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type);
        $query->propertyCondition('syllabus_type', $syllabus_type);
        ;
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
        }
        entity_delete_multiple($entity_type, $entities_ids);
    }

    function getDeparmentByNameCodeSyllabusType($name = null, $code = null, $syllabus_type = null, $op = null) {
        $table_name = 'eck_' . self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        $table_where = '';
        if ($op === 'AND' && !empty($name) && !empty($code)) {
            $table_where = "WHERE name='" . $name . "' AND shortcode='" . $code . "'";
        } else if ($op === 'OR' && !empty($name) && !empty($code)) {
            $table_where = "WHERE name='" . $name . "' OR shortcode='" . $code . "'";
        } else {
            if (!empty($name)) {
                $table_where = "WHERE name='" . $name . "'";
            } else if (!empty($code)) {
                $table_where = "WHERE shortcode='" . $code . "'";
            }
        }
        if (!empty($syllabus_type)) {
            if (!empty($table_where)) {
                $table_where .= " AND syllabus_type = '" . $syllabus_type . "'";
            } else {
                $table_where = "WHERE syllabus_type = '" . $syllabus_type . "'";
            }
        }
        $sql = "SELECT id, name, shortcode, syllabus_type from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function setDepartmentSyllabusType($data = array()) {
        $entity_name = self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
        if (!empty($data['name'])) {
            $ew->name = $data['name'];
            $ew->syllabus_type = $data['syllabus_type'];
            if (!empty($data['shortcode']))
                $ew->shortcode = $data['shortcode'];
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getSubjectByNameCodeSyllabusType($name = null, $code = null, $op, $dept_id) {
        $table_name = 'eck_' . self::MCC_EDU_SYLLABUS_TYPE_SUBJECTS;
        $table_where = " WHERE dept_id='$dept_id'";
        if ($op === 'AND' && !empty($name) && !empty($code)) {
            $table_where .= " AND name='" . $name . "' AND code='" . $code . "'";
        } else if ($op === 'OR' && !empty($name) && !empty($code)) {
            $table_where .= " AND (name='" . $name . "' OR code='" . $code . "')";
        } else {
            if (!empty($name)) {
                $table_where .= " AND name='" . $name . "'";
            } else if (!empty($code)) {
                $table_where .= " AND code='" . $code . "'";
            }
        }
        $sql = "SELECT id, name, code from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function setSubjectSyllabusType($data) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_SUBJECTS;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['name'])) {
            $ew->name = $data['name'];
            if (!empty($data['code']))
                $ew->code = $data['code'];
            if (!empty($data['syllabus_type']))
                $ew->syllabus_type = $data['syllabus_type'];
            if (!empty($data['dept_id']))
                $ew->dept_id = $data['dept_id'];
            if (!empty($data['learning_objectives']))
                $ew->learning_objectives = nl2br($data['learning_objectives']);
            if (!empty($data['course_contents']))
                $ew->course_contents = nl2br($data['course_contents']);
            if (!empty($data['learning_objectives_details']))
                $ew->learning_objectives_details = nl2br($data['learning_objectives_details']);
            if (!empty($data['course_contents_details']))
                $ew->course_contents_details = nl2br($data['course_contents_details']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function setModulesSyllabusType($data) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['module_details'])) {
            $ew->module_details = check_plain($data['module_details']);
            if (!empty($data['sub_id']))
                $ew->sub_id = intval($data['sub_id']);
            if (!empty($data['syllabus_type']))
                $ew->syllabus_type = $data['syllabus_type'];
            if (!empty($data['name']))
                $ew->name = check_plain($data['name']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getMaterialsByNameSujectSyllabusType($name, $subject_id) {
        $table_name = 'eck_' . self::MCC_EDU_SYLLABUS_TYPE_MATERIALS;
        $table_where = " WHERE sub_id='$subject_id' AND name LIKE '%" . addslashes($name) . "'";
        $sql = "SELECT id, name from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function setMaterialsSyllabusType($data) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MATERIALS;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['name'])) {
            $ew->name = $data['name'];
            if (!empty($data['writer']))
                $ew->writer = $data['writer'];
            if (!empty($data['syllabus_type']))
                $ew->syllabus_type = $data['syllabus_type'];
            if (!empty($data['sub_id']))
                $ew->sub_id = $data['sub_id'];
            if (!empty($data['text_or_ref']))
                $ew->text_or_ref = $data['text_or_ref'];
            if (!empty($data['serial']))
                $ew->serial = $data['serial'];
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getDepartmentsSyllabusType($syllabus_type) {
        $entity_name = self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        $query->propertyCondition('syllabus_type', $syllabus_type);
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $dept_key => $dept_val) {
            $total_result['deparments'][$dept_key]['department']['id'] = $dept_val->id;
            $total_result['deparments'][$dept_key]['department']['name'] = stripslashes($dept_val->name);
            $total_result['deparments'][$dept_key]['department']['code'] = $dept_val->shortcode;
            $total_result['deparments'][$dept_key]['department']['syllabus_type'] = $dept_val->syllabus_type;
            $total_result['deparments'][$dept_key]['department']['subjects'] = $this->getSubjectByDeptSyllabusType($dept_val->id);
        }
        return $total_result;
    }

    function getSubjectByDeptSyllabusType($dept_id) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_SUBJECTS;
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('dept_id', $dept_id, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        foreach ($entities as $sub_key => $sub_val) {
            $total_result[$sub_key]['subject']['id'] = $sub_val->id;
            $total_result[$sub_key]['subject']['name'] = stripslashes($sub_val->name);
            $total_result[$sub_key]['subject']['code'] = $sub_val->code;
            $total_result[$sub_key]['subject']['syllabus_type'] = $sub_val->syllabus_type;
            $total_result[$sub_key]['subject']['dept_id'] = $sub_val->dept_id;
            $total_result[$sub_key]['subject']['learning_objectives'] = stripslashes($sub_val->learning_objectives);
            $total_result[$sub_key]['subject']['learning_objectives_details'] = stripslashes($sub_val->learning_objectives_details);
            $total_result[$sub_key]['subject']['course_contents'] = $this->getModulesBySubjSyllabusType($sub_val->id);
            $total_result[$sub_key]['subject']['text'] = $this->getMaterialsBySubjSyllabusType($sub_val->id, 'text');
            $total_result[$sub_key]['subject']['ref'] = $this->getMaterialsBySubjSyllabusType($sub_val->id, 'ref');
        }
        return $total_result;
    }

    function getModulesBySubjSyllabusType($sub_id) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES;
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('sub_id', $sub_id, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        if (!empty($entities)) {
            foreach ($entities as $mod_key => $mod_val) {
                $total_result[$mod_key]['module']['id'] = $mod_val->id;
                $total_result[$mod_key]['module']['sub_id'] = $mod_val->sub_id;
                $total_result[$mod_key]['module']['syllabus_type'] = $mod_val->syllabus_type;
                $total_result[$mod_key]['module']['name'] = decode_entities($mod_val->name);
                $total_result[$mod_key]['module']['module_details'] = decode_entities($mod_val->module_details);
            }
        }
        return $total_result;
    }

    function getMaterialsBySubjSyllabusType($sub_id, $text_or_ref) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MATERIALS;
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('sub_id', $sub_id, '=')
                ->propertyCondition('text_or_ref', $text_or_ref, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        if (!empty($entities)) {
            foreach ($entities as $mat_key => $mat_val) {
                $total_result[$mat_key]['material']['id'] = $mat_val->id;
                $total_result[$mat_key]['material']['name'] = stripslashes($mat_val->name);
                $total_result[$mat_key]['material']['writer'] = $mat_val->writer;
                $total_result[$mat_key]['material']['syllabus_type'] = $mat_val->syllabus_type;
                $total_result[$mat_key]['material']['sub_id'] = $mat_val->sub_id;
                $total_result[$mat_key]['material']['text_or_ref'] = $mat_val->text_or_ref;
                $total_result[$mat_key]['material']['uploaded_file_id'] = $mat_val->uploaded_file_id;
                $total_result[$mat_key]['material']['serial'] = $mat_val->serial;
            }
        }
        return $total_result;
    }

    /**
     * 
     * @param type $id
     * @param type $level
     * $level may have value 1 or 2
     * 1 = only subject
     * 2 = with subject's materials
     */
    function getSubjectByIdSyllabusType($id, $level) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_SUBJECTS;
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        foreach ($entities as $sub_key => $sub_val) {
            $total_result[$sub_key]['subject']['id'] = $sub_val->id;
            $total_result[$sub_key]['subject']['name'] = stripslashes($sub_val->name);
            $total_result[$sub_key]['subject']['code'] = $sub_val->code;
            $total_result[$sub_key]['subject']['syllabus_type'] = $sub_val->syllabus_type;
            $total_result[$sub_key]['subject']['dept_id'] = $sub_val->dept_id;
            $total_result[$sub_key]['subject']['dept_code'] = $this->getDeparmentCodeByIDSyllabusType($sub_val->dept_id);
            $total_result[$sub_key]['subject']['learning_objectives'] = stripslashes($sub_val->learning_objectives);
            $total_result[$sub_key]['subject']['learning_objectives_details'] = stripslashes($sub_val->learning_objectives_details);
            $total_result[$sub_key]['subject']['course_contents'] = $this->getModulesBySubjSyllabusType($sub_val->id);
            if ($level == 2) {
                $total_result[$sub_key]['subject']['text'] = $this->getMaterialsBySubjSyllabusType($sub_val->id, 'text');
                $total_result[$sub_key]['subject']['ref'] = $this->getMaterialsBySubjSyllabusType($sub_val->id, 'ref');
            }
        }
        return $total_result;
    }

    function getModulesMaterialsBySubjSyllabusType($sub_code) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES_MATERIALS;
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('sub_code', $sub_code, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        if (!empty($entities)) {
            foreach ($entities as $mod_key => $mod_val) {
                $total_result[$mod_key]['module_mat']['id'] = $mod_val->id;
                $total_result[$mod_key]['module_mat']['sub_code'] = $mod_val->sub_code;
                $total_result[$mod_key]['module_mat']['syllabus_type'] = $mod_val->syllabus_type;
                $total_result[$mod_key]['module_mat']['module_no'] = $mod_val->module_no;
                if (!empty($mod_val->file_id))
                    $total_result[$mod_key]['module_mat']['file'] = file_load($mod_val->file_id);
            }
        }
        return $total_result;
    }

    function getDeparmentCodeByIDSyllabusType($id) {
        $table_name = 'eck_' . self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        $table_where = "WHERE id='$id'";
        $sql = "SELECT shortcode from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchColumn();
        return $result;
    }

    /**
     * 
     * @param type $id
     * @param type $level
     * $level may have value 1, 2 or 3
     * 1 = only department
     * 2 = with subjects
     * 3 = with subjects' materials
     */
    function getDeparmentByIdSyllabusType($id, $level) {
        $entity_name = self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        $total_result = null;
        $entities = entity_load($entity_name, array($id));
        foreach ($entities as $dept_key => $dept_val) {
            $total_result['id'] = $dept_val->id;
            $total_result['name'] = $dept_val->name;
            $total_result['code'] = $dept_val->shortcode;
            $total_result['syllabus_type'] = $dept_val->syllabus_type;
            $total_result['subjects'] = $this->getSubjectByDeptSyllabusType($dept_val->id);
        }
        return $total_result;
    }

    function delDeptByIdSyllabusType($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function delSubjectByIdSyllabusType($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_SUBJECTS;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function delModuleByIdSyllabusType($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function delMaterialByIdSyllabusType($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MATERIALS;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function setModulesMaterialSyllabusType($data) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES_MATERIALS;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_type, array('type' => $entity_type));
        } else {
            $entities = entity_load($entity_type, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_type, $entity);
        if (!empty($data['file_id'])) {
            $ew->file_id = intval($data['file_id']);
            if (!empty($data['sub_code']))
                $ew->sub_code = check_plain($data['sub_code']);
            if (!empty($data['module_no']))
                $ew->module_no = intval($data['module_no']);
            if (!empty($data['syllabus_type']))
                $ew->syllabus_type = intval($data['syllabus_type']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function delModuleMaterialByFIdSyllabusType($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_MODULES_MATERIALS;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('file_id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function setQuestion($data = array()) {
        $entity_name = self::MCC_EDU_QUESTIONS_BANK;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
        if (!empty($data['question']) && !empty($data['sub_code']) && !empty($data['answers'])) {
            $ew->question = check_plain(trim($data['question']));
            $ew->sub_code = check_plain(trim($data['sub_code']));
            if (isset($data['module_no']))
                $ew->module_no = intval($data['module_no']);
            if (isset($data['right_answer']))
                $ew->right_answer = check_plain($data['right_answer']);
            $ew->answers = $data['answers'];
            if (isset($data['uploaded_by']))
                $ew->uploaded_by = check_plain($data['uploaded_by']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getQuestions($sub_code = NULL, $random_order = FALSE, $limit = NULL, $subjects = array(), $module = NULL) {
        $entity_name = self::MCC_EDU_QUESTIONS_BANK;
        $results = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        if (!empty($sub_code))
            $query->propertyCondition('sub_code', $sub_code, '=');
        else {
            if (!empty($subjects))
                $query->propertyCondition('sub_code', $subjects, 'IN');
        }
        if (!empty($module))
            $query->propertyCondition('module_no', $module, '=');
        if (!empty($random_order) && !empty($limit)) {
            $query->addTag('random');
            $query->range(0, $limit);
        } else {
            $query->propertyOrderBy('sub_code', 'ASC');
            $query->propertyOrderBy('module_no', 'ASC');
            $query->propertyOrderBy('question', 'ASC');
        }
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $key => $val) {
            $results[$key]['id'] = $val->id;
            $results[$key]['sub_code'] = $val->sub_code;
            $results[$key]['module_no'] = $val->module_no;
            $results[$key]['question'] = $val->question;
            $results[$key]['answers'] = unserialize($val->answers);
//      $results[$key]['answers1'] = $val->answers;
            $results[$key]['right_answer'] = $val->right_answer;
            $results[$key]['uploaded_by'] = $val->uploaded_by;
        }
        return $results;
    }

    function getQuestionById($id) {
        $entity_name = self::MCC_EDU_QUESTIONS_BANK;
        $results = null;
        $entities = entity_load($entity_name, array($id));
//    pretty_print($entities);
        foreach ($entities as $key => $val) {
            $results[$key][0] = $val->sub_code;
            $results[$key][1] = $val->module_no;
            $results[$key][2] = $val->question;

            $results[$key][3] = $results[$key][4] = $results[$key][5] = $results[$key][6] = '';
            $answers = unserialize($val->answers);
            if (!empty($answers)) {
                $results[$key][3] = $answers[1];
                $results[$key][4] = $answers[2];
                $results[$key][5] = $answers[3];
                $results[$key][6] = $answers[4];
            }
            $results[$key][7] = $val->right_answer;
            $results[$key][8] = $val->id;
        }
        return $results;
    }

    function delQuestionById($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_QUESTIONS_BANK;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function checkIfSubjectHasQuestionBank($sub_code) {
        $table_name = 'eck_' . self::MCC_EDU_QUESTIONS_BANK;
        $table_where = " WHERE sub_code='$sub_code'";
        $sql = "SELECT COUNT(id) as total_questions from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchObject();
        return $result;
    }

    function setCourseResult($data = array()) {
        $entity_name = self::MCC_EDU_COURSE_RESULT;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
        if (!empty($data['course_code']) && !empty($data['user_id'])) {
            $ew->course_code = check_plain(trim($data['course_code']));
            $ew->user_id = intval(trim($data['user_id']));
            if (isset($data['score']))
                $ew->score = floatval($data['score']);
            if (!empty($data['module']))
                $ew->module = intval($data['module']);
            $ew->exam_date = REQUEST_TIME;
            $ew->session = check_plain(trim($data['session']));
            $ew->year = check_plain(trim($data['year']));
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getCourseResult($uid = NULL, $course_code = NULL, $session = NULL, $year = NULL) {
        $entity_name = self::MCC_EDU_COURSE_RESULT;
        $results = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        if (!empty($uid))
            $query->propertyCondition('user_id', $uid, '=');
        if (!empty($course_code))
            $query->propertyCondition('course_code', $course_code, '=');
        if (!empty($session))
            $query->propertyCondition('session', $session, '=');
        if (!empty($year))
            $query->propertyCondition('year', $year, '=');
        $query->propertyOrderBy('exam_date', 'DESC');
        $query->propertyOrderBy('course_code', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $key => $val) {
            $results[$key]['id'] = $val->id;
            $results[$key]['course_code'] = $val->course_code;
            $results[$key]['user_id'] = $val->user_id;
            $results[$key]['score'] = $val->score;
            $results[$key]['exam_date'] = $val->exam_date;
            $results[$key]['session'] = $val->session;
            $results[$key]['year'] = $val->year;
            $results[$key]['module'] = $val->module;
        }
        return $results;
    }

    function checkIfUserIsAlreadyRegisteredInSession($data) {
        $table_name = 'eck_' . self::MCC_EDU_SESSION_REGISTRATION_DETAILS;
        $table_where = " WHERE user_id='" . $data['user_id'] . "' AND year='" . $data['year'] .
                "' AND session='" . $data['session'] . "'";
        $sql = "SELECT id, course_codes from {$table_name} " . $table_where;
        $result = db_query($sql)->fetchObject();
        return $result;
    }

    function setSessionRegistration($data = array()) {
        $entity_name = self::MCC_EDU_SESSION_REGISTRATION_DETAILS;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
        if (!empty($data['user_id']) && !empty($data['year']) && !empty($data['session']) && !empty($data['course_codes'])) {
            $ew->user_id = intval(trim($data['user_id']));
            $ew->year = intval(trim($data['year']));
            $ew->session = check_plain(trim($data['session']));
            $ew->paid = check_plain(trim($data['paid']));
            $ew->course_codes = serialize($data['course_codes']);
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function delSessionRegistrationById($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_SESSION_REGISTRATION_DETAILS;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function getRegistrationDetails($user_id = null) {
        $entity_name = self::MCC_EDU_SESSION_REGISTRATION_DETAILS;
        $results = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        if (!empty($user_id))
            $query->propertyCondition('user_id', $user_id, '=');
        $query->propertyOrderBy('year', 'DESC');
        $query->propertyOrderBy('session', 'DESC');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $key => $val) {
            $results[$key]['id'] = $val->id;
            $results[$key]['courses'] = unserialize($val->course_codes);
            $results[$key]['session'] = $val->session . ', ' . $val->year;
            $results[$key]['user'] = user_load($val->user_id);
            $results[$key]['paid'] = $val->paid;
        }
        return $results;
    }

    public function getCountofFilteredMccEduUser($input = array()) {
        $input_where = '';

        if (!empty($input['search']['value'])) {
            $input_where = "AND (fn.field_name_value LIKE '%{$input['search']['value']}%')";
        }
        if (!empty($input['columns'][0]['search']['value'])) {
            $input_where .= " AND (users_roles.rid = '{$input['columns'][0]['search']['value']}')";
        }
        if (!empty($input['columns'][1]['search']['value'])) {
            $input_where .= " AND (fu.field_unit_value = '{$input['columns'][1]['search']['value']}')";
        }
        $sql = "SELECT COUNT(DISTINCT users.uid) as total 
            FROM users users
            LEFT JOIN users_roles users_roles 
                ON users.uid = users_roles.uid 
            LEFT JOIN field_data_field_name fn 
                ON fn.entity_id = users.uid AND fn.entity_type = 'user' 
            LEFT JOIN field_data_field_unit fu 
                ON fu.entity_id = users.uid AND fu.entity_type = 'user'
            WHERE (( (users.status <> '0')  
            AND fn.field_name_value NOT LIKE '%developer%' {$input_where} )) ";
        //echo $sql;
        $results = db_query($sql)->fetchAll();
        if (!empty($results)) {
            $results = array_pop($results);
            return $results->total;
        } else {
            return 0;
        }
        return 0;
    }

    public function getCountofTotalMccEduUser() {
        $sql = "SELECT COUNT(users.uid) as total 
            FROM users users
            LEFT JOIN field_data_field_name fn 
                ON fn.entity_id = users.uid AND fn.entity_type = 'user'
            WHERE (( (users.status <> '0')  
            AND fn.field_name_value NOT LIKE '%developer%'  ))";
        //echo $sql;
        $results = db_query($sql)->fetchAll();
        if (!empty($results)) {
            $results = array_pop($results);
            return $results->total;
        } else {
            return 0;
        }
        return 0;
    }

    public function getMccEduUser($isAdmin, $start = 0, $length = -1, $input = array()) {
        $limit = '';
        $input_where = '';
        $input_order = '';
        if (isset($start) && $length != -1) {
            $limit = "LIMIT " . intval($start) . ", " . intval($length);
        }
        if (!empty($input['search']['value'])) {
            $input_where = "AND (fn.field_name_value LIKE '%{$input['search']['value']}%')";
        }
        if (!empty($input['columns'][0]['search']['value'])) {
            $input_where .= " AND (users_roles.rid = '{$input['columns'][0]['search']['value']}')";
        }
        if (!empty($input['columns'][1]['search']['value'])) {
            $input_where .= " AND (fu.field_unit_value = '{$input['columns'][1]['search']['value']}')";
        }
        if (isset($input['order'][0]['column']) && !empty($input['order'][0]['dir'])) {
            $column_index = $input['order'][0]['column'];
            $column_dir = $input['order'][0]['dir'];
            if ($column_index == 0) {
                $input_order = " ORDER BY fn.field_name_value {$column_dir} ";
            }
        }
        $sql = "SELECT users.uid, fn.field_name_value, fol.field_organizational_level_value, 
            fou.field_organizational_unit_target_id, fsu.field_sub_unit_target_id 
            FROM users users
            LEFT JOIN users_roles users_roles 
            ON users.uid = users_roles.uid
            LEFT JOIN field_data_field_name fn 
                ON fn.entity_id = users.uid AND fn.entity_type = 'user'
            LEFT JOIN field_data_field_organizational_level fol 
                ON fol.entity_id = users.uid AND fol.entity_type = 'user'
            LEFT JOIN field_data_field_organizational_unit fou 
                ON fou.entity_id = users.uid AND fou.entity_type = 'user' 
            LEFT JOIN field_data_field_sub_unit fsu 
                ON fsu.entity_id = users.uid AND fsu.entity_type = 'user' 
            WHERE (( (users.status <> '0') AND fn.field_name_value <> '' 
            AND fn.field_name_value NOT LIKE '%developer%' {$input_where} )) "
                . "GROUP BY users.uid"
                . $input_order . $limit;
        //echo $sql;
        $man_power = array();
        $results = db_query($sql)->fetchAll();
        $isUnitLeader = false;
        global $user;
        if (mcc_common_user_has_role(array('Unit Leader', 'Central Leader'), $user)) {
            $isUnitLeader = true;
        }
        $org_new_labels = array(
            'Member' => 'Charter Member',
            'Associate Member' => 'General Member',
            'Other' => 'Other',
        );
        foreach ($results as $key => $manpower) {
            $edit_del_str = '';
            $man_power[$key][0] = '';
            $man_power[$key][1] = '';
            $man_power[$key][2] = '';
            $man_power[$key][3] = '';
            $man_power[$key][4] = '';
            if ($isAdmin)
                $man_power[$key][5] = '';
            //$man_power[$key]['name'] = $manpower->field_name_value;            
            $man_power[$key][0] = ($key + 1 + intval($start)) . '. <a title="Click To Show Details">' . $manpower->field_name_value . '</a>';
            //$man_power[$key]['uid'] = $manpower->uid;
            $user_object = user_load($manpower->uid);
            $man_power[$key][1] = $org_new_labels[$user_object->field_organizational_level['und'][0]['value']];
            if ($isUnitLeader) {
                $loggedinuser = user_load($user->uid);
                if ($manpower->field_organizational_unit_target_id === $loggedinuser->field_organizational_unit['und'][0]['target_id'] || mcc_common_user_has_role(array('Central Leader'), $user)) {
                    $man_power[$key][0] .= "<span class='user-edit-del-option'>"
                            . "<a href='/user/{$manpower->uid}/edit'>EDIT</a> "
                            . "</span>";
                }
            }
            if (!empty($manpower->field_organizational_unit_target_id)) {
                $unit = node_load($manpower->field_organizational_unit_target_id);
                if (!empty($unit)) {
                    //$man_power[$key]['unit'] = $unit->title;
                    $man_power[$key][2] = $unit->title;
                }
            }
            if (!empty($manpower->field_sub_unit_target_id)) {
                $subunit = node_load($manpower->field_sub_unit_target_id);
                if (!empty($subunit)) {
                    //$man_power[$key]['subunit'] = $subunit->title;
                    $man_power[$key][3] = $subunit->title;
                }
            }
        }

        return $man_power;
    }

    function getUsersByRoles($roles_include) {
        $roles_include = "'" . implode("','", $roles_include) . "'";
        $sql = "SELECT users.uid, users.mail, fn.field_name_value, fp.field_phone_value, 
            fu.field_unit_value  
            FROM {users} users
            LEFT JOIN {users_roles} users_roles 
                ON users.uid = users_roles.uid
            LEFT JOIN {field_data_field_name} fn 
                ON fn.entity_id = users.uid AND fn.entity_type = 'user'
            LEFT JOIN {field_data_field_phone} fp 
                ON fp.entity_id = users.uid AND fp.entity_type = 'user'
            LEFT JOIN {field_data_field_unit} fu 
                ON fu.entity_id = users.uid AND fu.entity_type = 'user' 
            WHERE (( 
              (users.status <> '0')
              AND (users_roles.rid IN ($roles_include))                
            )) GROUP BY users.uid";

        $result = db_query($sql)->fetchAll();
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }

    function getDepartmentsSubjects($syllabus_type, $return_sub_id = false) {
        $subjects = array();
        $entity_name = self::MCC_EDU_SYLLABUS_TYPE_DEPARTMENTS;
        $total_result = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        $query->propertyCondition('syllabus_type', $syllabus_type);
//        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $dept_key => $dept_val) {
            if ($return_sub_id)
                $subjects[] = $this->getSubjectsByDept($dept_val->id, $dept_val->shortcode, true);
            else
                $subjects[] = $this->getSubjectsByDept($dept_val->id, $dept_val->shortcode);
        }
        if (!empty($subjects)) {
            $subjects = _flatten_array($subjects);
        }
        return $subjects;
    }

    function getSubjectsByDept($dept_id, $dept_short_code = '', $return_sub_id = false) {
        $entity_type = self::MCC_EDU_SYLLABUS_TYPE_SUBJECTS;
        $total_result = array();
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('dept_id', $dept_id, '=');
        $query->propertyOrderBy('id', 'ASC');
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $entities_ids = array_keys($result[$entity_type]);
            $entities = entity_load($entity_type, $entities_ids);
        }
        foreach ($entities as $sub_key => $sub_val) {
            if ($return_sub_id)
                $total_result[$dept_short_code . '-' . $sub_val->code] = $sub_val->id;
            else
                $total_result[$dept_short_code . '-' . $sub_val->code] = $dept_short_code . '-' . $sub_val->code . ' (' . stripslashes($sub_val->name) . ')';
        }
        return $total_result;
    }

    function setCourseInstructor($data = array()) {
        $entity_name = self::MCC_EDU_COURSE_INSTRUCTOR;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
//        pretty_print($data, 0);
        if (!empty($data['course_code']) && !empty($data['instructor_id'])) {
            $ew->course_code = check_plain(trim($data['course_code']));
            $ew->session = check_plain(trim($data['session']));
            $ew->year = check_plain(trim($data['year']));
            $ew->instructor_id = intval(trim($data['instructor_id']));
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getCourseInstructor($instructor_id = NULL, $course_code = NULL, $session = NULL, $year = NULL) {
        $entity_name = self::MCC_EDU_COURSE_INSTRUCTOR;
        $results = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        if (!empty($instructor_id))
            $query->propertyCondition('instructor_id', $instructor_id, '=');
        if (!empty($course_code))
            $query->propertyCondition('course_code', $course_code, '=');
        if (!empty($session))
            $query->propertyCondition('session', $session, '=');
        if (!empty($year))
            $query->propertyCondition('year', $year, '=');
        $query->propertyOrderBy('year', 'DESC');
        $query->propertyOrderBy('session', 'DESC');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $key => $val) {
            $results[$key]['id'] = $val->id;
            $results[$key]['course_code'] = $val->course_code;
            $results[$key]['instructor_id'] = $val->instructor_id;
            $results[$key]['year'] = $val->year;
            $results[$key]['session'] = $val->session;
        }
        return $results;
    }

    function getRegisteredUserUnderInstructor($instructor_id) {
        $instructor_table = "eck_" . self::MCC_EDU_COURSE_INSTRUCTOR;
        $regsitration_table = "eck_" . self::MCC_EDU_SESSION_REGISTRATION_DETAILS;

        $sql = "SELECT it.id, it.session, it.year, it.course_code, rt.course_codes, rt.user_id, "
                . "rt.session as rt_session, rt.year as rt_year, "
                . "u.mail, fn.field_name_value FROM $instructor_table it "
                . "LEFT JOIN $regsitration_table rt ON "
                . "rt.session = it.session AND rt.year = it.YEAR "
                . "AND rt.course_codes LIKE concat('%', it.course_code, '%') "
                . "LEFT JOIN users u ON "
                . "u.uid = rt.user_id "
                . "LEFT JOIN field_data_field_name fn ON "
                . "fn.entity_id = u.uid AND fn.entity_type = 'user'"
                . "WHERE it.instructor_id = '$instructor_id' "
                . "ORDER BY it.year DESC, it.session DESC";

        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function getRegisteredUserUnderInstructorByCourseCode($instructor_id, $course_code, $session, $year) {
        $instructor_table = "eck_" . self::MCC_EDU_COURSE_INSTRUCTOR;
        $regsitration_table = "eck_" . self::MCC_EDU_SESSION_REGISTRATION_DETAILS;
        if (!empty($instructor_id)) {
            $sql = "SELECT rt.user_id, "
                    . "u.mail, fn.field_name_value FROM $instructor_table it "
                    . "LEFT JOIN $regsitration_table rt ON "
                    . "rt.session = it.session AND rt.year = it.YEAR "
                    . "AND rt.course_codes LIKE concat('%', it.course_code, '%') "
                    . "LEFT JOIN users u ON "
                    . "u.uid = rt.user_id "
                    . "LEFT JOIN field_data_field_name fn ON "
                    . "fn.entity_id = u.uid AND fn.entity_type = 'user'"
                    . "WHERE it.instructor_id = '$instructor_id' AND "
                    . "it.course_code = '$course_code' AND "
                    . "it.session = '$session' AND "
                    . "it.year = '$year'"
                    . "ORDER BY it.year DESC, it.session DESC";
        } else {
            $sql = "SELECT rt.user_id, "
                    . "u.mail, fn.field_name_value FROM $instructor_table it "
                    . "LEFT JOIN $regsitration_table rt ON "
                    . "rt.session = it.session AND rt.year = it.YEAR "
                    . "AND rt.course_codes LIKE concat('%', it.course_code, '%') "
                    . "LEFT JOIN users u ON "
                    . "u.uid = rt.user_id "
                    . "LEFT JOIN field_data_field_name fn ON "
                    . "fn.entity_id = u.uid AND fn.entity_type = 'user'"
                    . "WHERE it.course_code = '$course_code' AND "
                    . "it.session = '$session' AND "
                    . "it.year = '$year'"
                    . "ORDER BY it.year DESC, it.session DESC";
        }
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function getCourseResultWithUserInfo($course_code, $session, $year) {
        $result_table = "eck_" . self::MCC_EDU_COURSE_RESULT;

        $sql = "SELECT rt.id, rt.session, rt.year, rt.course_code, rt.user_id, "
                . "rt.score, rt.exam_date, rt.module, "
                . "u.mail, fn.field_name_value FROM $result_table rt "
                . "LEFT JOIN users u ON "
                . "u.uid = rt.user_id "
                . "LEFT JOIN field_data_field_name fn ON "
                . "fn.entity_id = u.uid AND fn.entity_type = 'user'"
                . "WHERE rt.course_code = '$course_code' "
                . "AND rt.session = '$session' "
                . "AND rt.year = '$year'"
                . "ORDER BY rt.exam_date DESC, fn.field_name_value ASC";

        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function getCourseInstructors($session, $year) {
        $result_table = "eck_" . self::MCC_EDU_COURSE_INSTRUCTOR;

        $sql = "SELECT rt.id, rt.session, rt.year, rt.course_code, rt.instructor_id, "
                . "u.mail, fn.field_name_value, fp.field_phone_value FROM $result_table rt "
                . "LEFT JOIN users u ON "
                . "u.uid = rt.instructor_id "
                . "LEFT JOIN field_data_field_name fn ON "
                . "fn.entity_id = u.uid AND fn.entity_type = 'user'"
                . "LEFT JOIN field_data_field_phone fp ON "
                . "fp.entity_id = u.uid "
                . "WHERE rt.session = '$session' "
                . "AND rt.year = '$year'"
                . "ORDER BY fn.field_name_value ASC";

        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function getSessionsYearsForCourseInst($inst_id = null) {
        $table = "eck_" . self::MCC_EDU_COURSE_INSTRUCTOR;
        if (!empty($inst_id)) {
            $sql = "SELECT DISTINCT session, year from {$table} "
                    . "WHERE instructor_id = '$inst_id' order by year desc, session desc";
        } else {
            $sql = "SELECT DISTINCT session, year from {$table} "
                    . "order by year desc, session desc";
        }
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function getSessionsYearsFromReg() {
        $regsitration_table = "eck_" . self::MCC_EDU_SESSION_REGISTRATION_DETAILS;
        $sql = "SELECT DISTINCT session, year from {$regsitration_table} order by year desc, session desc";
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function getCourseCodesFromReg() {
        $regsitration_table = "eck_" . self::MCC_EDU_SESSION_REGISTRATION_DETAILS;
        $sql = "SELECT DISTINCT course_codes from {$regsitration_table} order by course_codes asc";
        $result = db_query($sql)->fetchAll();
        return $result;
    }

    function setCourseClass($data = array()) {
        $entity_name = self::MCC_EDU_COURSE_CLASS;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
            $time_sum = array_sum(str_split(time()));
            $sms_code = randomKey(2) . $time_sum;
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
//        pretty_print($data, 0);
        if (!empty($data['course_code']) && !empty($data['session']) && !empty($data['year']) && !empty($data['class_date'])) {
            $ew->class_details = check_plain(trim($data['class_details']));
            $ew->class_presents = intval(trim($data['class_presents']));
            $ew->class_date = intval(trim($data['class_date']));
            $ew->course_code = check_plain(trim($data['course_code']));
            $ew->session = check_plain(trim($data['session']));
            $ew->year = check_plain(trim($data['year']));
            $ew->class_attendees = $data['class_attendees'];
            if (!empty($data['instructor_id']))
                $ew->instructor_id = intval(trim($data['instructor_id']));
            if (!empty($sms_code)) {
                $ew->sms_code = $sms_code;
                $sms_phone = variable_get('mcc_twilio_number', '+16475592852');
                $sms_phone = format_phone_number($sms_phone);
                $additional_message = " Type '{$sms_code} [YOUR NAME]' and send to {$sms_phone} to be listed as attendee of this class.";
                drupal_set_message('Saved.' . $additional_message);
            }
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getCoursesClassesLists($instructor_id, $start = 0, $length = -1, $input = array()) {
        $reports = null;
        $data = null;

        $query = new EntityFieldQuery();
        $entity_name = self::MCC_EDU_COURSE_CLASS;
        $query->entityCondition('entity_type', $entity_name);
        if (!empty($instructor_id))
            $query->propertyCondition('instructor_id', $instructor_id, '=');
        $query->propertyOrderBy('class_date', 'DESC');
        $query->propertyOrderBy('course_code', 'ASC');
        if (isset($start) && $length != -1) {
            $query->range(intval($start), intval($length));
        }
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $report_ids = array_keys($result[$entity_name]);
            $reports = entity_load($entity_name, $report_ids);
        }
//        pretty_print($reports);
//        if (!empty($reports)) {
//            $count = 0;
//            foreach ($reports as $report) {
//                $data[$count][] = $report->course_code;
//                $data[$count][] = ucwords($report->session) . '-' . $report->year;
//                $data[$count][] = format_date($report->class_date, 'custom', 'Y-m-d H:i');
//                $data[$count][] = $report->class_presents;
//                $data[$count][] = $report->class_attendees;
//                if ($report->sms_code)
//                    $data[$count][] = $report->sms_code . ' <a href="/syllabus/update-class-attendess/' . $report->id . '">Update Attendees</a>';
//                else
//                    $data[$count][] = '';
//                if (mcc_common_user_has_role('administrator'))
//                    $data[$count][] = '<a href="/syllabus/course-class/delete/' . $report->id . '">DELETE</a>';
//                else
//                    $data[$count][] = '';
//                $count++;
//            }
//        }
//        return $data;
        return $reports;
    }

    function getCoursesClassesCount($instructor_id) {
        $table = "eck_" . self::MCC_EDU_COURSE_CLASS;
        $sql = "SELECT COUNT(id) as total from {$table}";
        if (!empty($instructor_id))
            $sql .= " WHERE instructor_id = $instructor_id";
        $result = db_query($sql)->fetchColumn();
        return $result;
    }

    public function getClassById($id) {
        $reports = null;
        $query = new EntityFieldQuery();
        $entity_name = self::MCC_EDU_COURSE_CLASS;
        $query->entityCondition('entity_type', $entity_name)
                ->propertyCondition('id', $id, '=');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $report_ids = array_keys($result[$entity_name]);
            $reports = reset(entity_load($entity_name, $report_ids));
        }
        return $reports;
    }

    public function deleteClass($id) {
        $entity = null;
        $query = new EntityFieldQuery();
        $entity_name = self::MCC_EDU_COURSE_CLASS;
        $query->entityCondition('entity_type', $entity_name)
                ->propertyCondition('id', $id, '=');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $report_ids = array_keys($result[$entity_name]);
            $entity = reset(entity_load($entity_name, $report_ids));
        }
        if (!empty($entity)) {
            entity_delete($entity_name, $entity->id);
        }
    }

    public function unassignInstructor($id) {
        $entity = null;
        $query = new EntityFieldQuery();
        $entity_name = self::MCC_EDU_COURSE_INSTRUCTOR;
        $query->entityCondition('entity_type', $entity_name)
                ->propertyCondition('id', $id, '=');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $report_ids = array_keys($result[$entity_name]);
            $entity = reset(entity_load($entity_name, $report_ids));
        }
        if (!empty($entity)) {
            entity_delete($entity_name, $entity->id);
        }
    }

    function setCourseUrl($data = array()) {
        $entity_name = self::MCC_EDU_COURSE_URL;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
//        pretty_print($data, 0);
        if (!empty($data['course_code']) && !empty($data['course_url'])) {
            $ew->course_code = check_plain(trim($data['course_code']));
            $ew->course_url = check_plain(trim($data['course_url']));
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getCourseUrl($course_code) {
        $entity_name = self::MCC_EDU_COURSE_URL;
        $results = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        if (!empty($course_code))
            $query->propertyCondition('course_code', $course_code, '=');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $key => $val) {
            $results['id'] = $val->id;
            $results['course_code'] = $val->course_code;
            $results['course_url'] = $val->course_url;
        }
        return $results;
    }

    function delCourseUrlById($id) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_COURSE_URL;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('id', $id);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
            $reports = entity_load($entity_type, $ids);
            $entity = reset($reports);
        }
        if (!empty($entity)) {
            entity_delete($entity_type, $entity->id);
        }
    }

    function getCourseUrls() {
        $entity_name = self::MCC_EDU_COURSE_URL;
        $results = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $key => $val) {
            $results[$key]['id'] = $val->id;
            $results[$key]['course_code'] = $val->course_code;
            $results[$key]['course_url'] = $val->course_url;
        }
        return $results;
    }

    function setCourseSchedule($data = array()) {
        $entity_name = self::MCC_EDU_COURSE_SCHEDULE;
        if (!isset($data['id'])) {
            $entity = entity_create($entity_name, array('type' => $entity_name));
        } else {
            $entities = entity_load($entity_name, array($data['id']));
            $entity = reset($entities);
        }
        $ew = entity_metadata_wrapper($entity_name, $entity);
        if (!empty($data['course_code']) && !empty($data['class_date'])) {
            $ew->class_date = intval(trim($data['class_date']));
            $ew->course_code = check_plain(trim($data['course_code']));
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getCoursesScheduleLists($start = 0, $length = -1, $input = array()) {
        $reports = null;
        $data = null;

        $query = new EntityFieldQuery();
        $entity_name = self::MCC_EDU_COURSE_SCHEDULE;
        $query->entityCondition('entity_type', $entity_name);
        $query->propertyOrderBy('class_date', 'DESC');
        $query->propertyOrderBy('course_code', 'ASC');
        if (isset($start) && $length != -1) {
            $query->range(intval($start), intval($length));
        }
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $report_ids = array_keys($result[$entity_name]);
            $reports = entity_load($entity_name, $report_ids);
        }
//        pretty_print($reports);
        if (!empty($reports)) {
            $count = 0;
            foreach ($reports as $report) {
                $data[$count][] = $report->course_code;
                $data[$count][] = format_date($report->class_date, 'custom', 'Y-m-d H:i');
                if (mcc_common_user_has_role('administrator'))
                    $data[$count][] = '<a href="/syllabus/course-schedule/delete/' . $report->id . '">DELETE</a>';
                else
                    $data[$count][] = '';
                $count++;
            }
        }
        return $data;
    }

    function getCoursesScheduleCount() {
        $table = "eck_" . self::MCC_EDU_COURSE_SCHEDULE;
        $sql = "SELECT COUNT(id) as total from {$table}";
        $result = db_query($sql)->fetchColumn();
        return $result;
    }

    public function getScheduleById($id) {
        $reports = null;
        $query = new EntityFieldQuery();
        $entity_name = self::MCC_EDU_COURSE_SCHEDULE;
        $query->entityCondition('entity_type', $entity_name)
                ->propertyCondition('id', $id, '=');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $report_ids = array_keys($result[$entity_name]);
            $reports = reset(entity_load($entity_name, $report_ids));
        }
        return $reports;
    }

    public function deleteSchedule($id) {
        $entity = null;
        $query = new EntityFieldQuery();
        $entity_name = self::MCC_EDU_COURSE_SCHEDULE;
        $query->entityCondition('entity_type', $entity_name)
                ->propertyCondition('id', $id, '=');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $report_ids = array_keys($result[$entity_name]);
            $entity = reset(entity_load($entity_name, $report_ids));
        }
        if (!empty($entity)) {
            entity_delete($entity_name, $entity->id);
        }
    }

    public function getMCCEduScheduleForCalendar($filter = array()) {

        $table_name = 'eck_' . self::MCC_EDU_COURSE_SCHEDULE;
        $table_course_url = 'eck_' . self::MCC_EDU_COURSE_URL;
        $table_alias = 'mecs';
        $input_where = '';
        foreach ($filter as $filter_key => $filter_val) {
            $input_where .= " AND ($table_alias.$filter_key = '$filter_val')";
        }
        $sql = "SELECT $table_alias.id, $table_alias.course_code, $table_alias.class_date, mecu.course_url "
                . "FROM $table_name $table_alias "
                . "LEFT JOIN $table_course_url mecu "
                . "ON mecu.course_code = $table_alias.course_code "
                . "WHERE (( "
                . "($table_alias.id <> 0) $input_where "
                . ")) ORDER BY $table_alias.id DESC";


        $results = db_query($sql)->fetchAll();
        return $results;
    }

    function setModuleActiveInactive($data = array()) {
        $entity_name = self::MCC_EDU_COURSE_MODULES_ACTIVE_INACTIVE;
        $entity = entity_create($entity_name, array('type' => $entity_name));
        $ew = entity_metadata_wrapper($entity_name, $entity);
        if (!empty($data['course_code']) && !empty($data['active_date']) && !empty($data['module'])) {
            $ew->course_code = check_plain(trim($data['course_code']));
            $ew->active_date = intval(trim($data['active_date']));
            $ew->module = intval(trim($data['module']));
            $ew->save();
            return $ew->getIdentifier();
        } else {
            return 0;
        }
    }

    function getModuleActiveInactive($course_code) {
        $entity_name = self::MCC_EDU_COURSE_MODULES_ACTIVE_INACTIVE;
        $results = null;
        $entities = null;
        $query = new EntityFieldQuery();
        $query->entityCondition('entity_type', $entity_name);
        if (!empty($course_code))
            $query->propertyCondition('course_code', $course_code, '=');
        $result = $query->execute();
        if (!empty($result[$entity_name])) {
            $entities_ids = array_keys($result[$entity_name]);
            $entities = entity_load($entity_name, $entities_ids);
        }
        foreach ($entities as $key => $val) {
            $results[$val->module]['id'] = $val->id;
            $results[$val->module]['course_code'] = $val->course_code;
            $results[$val->module]['active_date'] = $val->active_date;
            $results[$val->module]['module'] = $val->module;
        }
        return $results;
    }

    function delModuleActiveInactive($course_code) {
        $query = new EntityFieldQuery();
        $entity_type = self::MCC_EDU_COURSE_MODULES_ACTIVE_INACTIVE;
        $query->entityCondition('entity_type', $entity_type)
                ->propertyCondition('course_code', $course_code);
        $result = $query->execute();
        if (!empty($result[$entity_type])) {
            $ids = array_keys($result[$entity_type]);
//            $reports = entity_load($entity_type, $ids);
//            pretty_print($reports);
//            $entity = reset($reports);
//
//            $results = entity_load($entity_type);
//            $entity_ids = array_keys($results);
            entity_delete_multiple($entity_type, $ids);
        }
    }

}

/****
 * TO DO
 * 1. after any user delete, delete its id from all tables like course_reg, course_instructor etc
 * 2. after updating any course code, update course code in all associated table
 * 3. after deleting any course, delete its code from all associated tables
 * 
 */