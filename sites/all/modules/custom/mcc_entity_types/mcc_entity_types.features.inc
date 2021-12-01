<?php

/**
 * @file
 * mcc_entity_types.features.inc
 */

/**
 * Implements hook_eck_entity_type_info().
 */
function mcc_entity_types_eck_entity_type_info() {
    $items = array(
        'mcc_federal_unit_report_monthly' => array(
            'name' => 'mcc_federal_unit_report_monthly',
            'label' => 'MCC Federal Unit Report Monthly',
            'properties' => array(
                'uid' => array(
                    'label' => 'Author',
                    'type' => 'integer',
                    'behavior' => 'author',
                ),
                'created' => array(
                    'label' => 'Created',
                    'type' => 'integer',
                    'behavior' => 'created',
                ),
                'changed' => array(
                    'label' => 'Changed',
                    'type' => 'integer',
                    'behavior' => 'changed',
                ),
                
                'member_total' => array(
                    'label' => 'Member Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_increase' => array(
                    'label' => 'member_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'member_decrease' => array(
                    'label' => 'member_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'member_brs_total' => array(
                    'label' => 'Member Brothers Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_sis_total' => array(
                    'label' => 'Member Sisters Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_yb_total' => array(
                    'label' => 'Member Youth Boy Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_yg_total' => array(
                    'label' => 'Member Youth Girl Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_uni_total' => array(
                    'label' => 'Member University Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_applicant_total' => array(
                    'label' => 'Member Applicant Total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),                
                'member_applicant_increase' => array(
                    'label' => 'member_applicant_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'member_applicant_decrease' => array(
                    'label' => 'member_applicant_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'member_applicant_brs_total' => array(
                    'label' => 'Member Applicant Brothers Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_applicant_sis_total' => array(
                    'label' => 'Member Applicant Sisters Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_applicant_yb_total' => array(
                    'label' => 'Member Applicant Youth Boy Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_applicant_yg_total' => array(
                    'label' => 'Member Applicant Youth Girl Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'member_applicant_uni_total' => array(
                    'label' => 'Member Applicant University Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'associate_member_total' => array(
                    'label' => 'Associate Member Total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),                
                'associate_member_increase' => array(
                    'label' => 'associate_member_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'associate_member_decrease' => array(
                    'label' => 'associate_member_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'associate_member_brs_total' => array(
                    'label' => 'associate_Member Brothers Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'associate_member_sis_total' => array(
                    'label' => 'associate_Member Sisters Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'associate_member_yb_total' => array(
                    'label' => 'associate_Member Youth Boy Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'associate_member_yg_total' => array(
                    'label' => 'associate_Member Youth Girl Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'associate_member_uni_total' => array(
                    'label' => 'associate_Member University Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'manpower_total' => array(
                    'label' => 'Manpower Total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'manpower_increase' => array(
                    'label' => 'manpower_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'manpower_decrease' => array(
                    'label' => 'manpower_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'manpower_brs_total' => array(
                    'label' => 'manpower Brothers Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'manpower_sis_total' => array(
                    'label' => 'manpower Sisters Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'manpower_yb_total' => array(
                    'label' => 'manpower Youth Boy Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'manpower_yg_total' => array(
                    'label' => 'manpower Youth Girl Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'manpower_uni_total' => array(
                    'label' => 'manpower University Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'primary_member_total' => array(
                    'label' => 'Primary Member Total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'primary_member_increase' => array(
                    'label' => 'primary_member_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'primary_member_decrease' => array(
                    'label' => 'primary_member_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'primary_member_brs_total' => array(
                    'label' => 'primary_Member Brothers Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'primary_member_sis_total' => array(
                    'label' => 'primary_Member Sisters Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'primary_member_yb_total' => array(
                    'label' => 'primary_Member Youth Boy Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'primary_member_yg_total' => array(
                    'label' => 'primary_Member Youth Girl Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'primary_member_uni_total' => array(
                    'label' => 'primary_Member University Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'wellwisher_total' => array(
                    'label' => 'Wellwisher Total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'wellwisher_increase' => array(
                    'label' => 'wellwisher_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'wellwisher_decrease' => array(
                    'label' => 'wellwisher_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'wellwisher_brs_total' => array(
                    'label' => 'wellwisher Brothers Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'wellwisher_sis_total' => array(
                    'label' => 'wellwisher Sisters Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'wellwisher_yb_total' => array(
                    'label' => 'wellwisher Youth Boy Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'wellwisher_yg_total' => array(
                    'label' => 'wellwisher Youth Girl Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'wellwisher_uni_total' => array(
                    'label' => 'wellwisher University Total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                
                'sub_unit_brs_total' => array(
                    'label' => 'sub_unit_brs_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_brs_increase' => array(
                    'label' => 'sub_unit_brs_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_brs_decrease' => array(
                    'label' => 'sub_unit_brs_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_brs_reason' => array(
                    'label' => 'sub_unit_brs_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'sub_unit_sis_total' => array(
                    'label' => 'sub_unit_sis_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_sis_increase' => array(
                    'label' => 'sub_unit_sis_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_sis_decrease' => array(
                    'label' => 'sub_unit_sis_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_sis_reason' => array(
                    'label' => 'sub_unit_sis_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'sub_unit_yb_total' => array(
                    'label' => 'sub_unit_yb_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_yb_increase' => array(
                    'label' => 'sub_unit_yb_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_yb_decrease' => array(
                    'label' => 'sub_unit_yb_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_yb_reason' => array(
                    'label' => 'sub_unit_yb_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'sub_unit_yg_total' => array(
                    'label' => 'sub_unit_yg_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_yg_increase' => array(
                    'label' => 'sub_unit_yg_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_yg_decrease' => array(
                    'label' => 'sub_unit_yg_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_yg_reason' => array(
                    'label' => 'sub_unit_yg_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'sub_unit_uni_total' => array(
                    'label' => 'sub_unit_uni_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_uni_increase' => array(
                    'label' => 'sub_unit_uni_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_uni_decrease' => array(
                    'label' => 'sub_unit_uni_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_uni_reason' => array(
                    'label' => 'sub_unit_uni_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'sub_unit_total' => array(
                    'label' => 'sub_unit_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_increase' => array(
                    'label' => 'sub_unit_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_decrease' => array(
                    'label' => 'sub_unit_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_reason' => array(
                    'label' => 'sub_unit_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'sub_unit_cb_total' => array(
                    'label' => 'sub_unit_cb_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_cb_increase' => array(
                    'label' => 'sub_unit_cb_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_cb_decrease' => array(
                    'label' => 'sub_unit_cb_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_cb_reason' => array(
                    'label' => 'sub_unit_cb_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'sub_unit_cg_total' => array(
                    'label' => 'sub_unit_cg_total',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'sub_unit_cg_increase' => array(
                    'label' => 'sub_unit_cg_increase',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_cg_decrease' => array(
                    'label' => 'sub_unit_cg_decrease',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_cg_reason' => array(
                    'label' => 'sub_unit_cg_reason',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                                
                'unit_member_meeting_number' => array(
                    'label' => 'unit_member_meeting_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_member_meeting_total_present' => array(
                    'label' => 'unit_member_meeting_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_member_meeting_remark' => array(
                    'label' => 'unit_member_meeting_remark',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'unit_associate_member_meeting_number' => array(
                    'label' => 'unit_associate_member_meeting_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_associate_member_total_present' => array(
                    'label' => 'unit_associate_member_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_associate_member_meeting_remark' => array(
                    'label' => 'unit_associate_member_meeting_remark',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'unit_secretariat_meeting_number' => array(
                    'label' => 'unit_secretariat_meeting_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_secretariat_meeting_total_present' => array(
                    'label' => 'unit_secretariat_meeting_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_secretariat_meeting_remark' => array(
                    'label' => 'unit_secretariat_meeting_remark',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'unit_other_meeting_number' => array(
                    'label' => 'unit_other_meeting_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_emergency_meeting_remark' => array(
                    'label' => 'unit_emergency_meeting_remark',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'unit_emergency_meeting_number' => array(
                    'label' => 'unit_emergency_meeting_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_emergency_meeting_total_present' => array(
                    'label' => 'unit_emergency_meeting_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_other_meeting_total_present' => array(
                    'label' => 'unit_other_meeting_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'unit_other_meeting_remark' => array(
                    'label' => 'unit_other_meeting_remark',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                
                'job_support_total' => array(
                    'label' => 'job_support_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'housing_support_total' => array(
                    'label' => 'housing_support_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'hospital_visit_total' => array(
                    'label' => 'hospital_visit_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'relative_support_total' => array(
                    'label' => 'relative_support_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'interfaith_visit_total' => array(
                    'label' => 'interfaith_visit_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'relief_activity_total' => array(
                    'label' => 'relief_activity_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'moving_help_total' => array(
                    'label' => 'moving_help_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'qarze_hasana_total' => array(
                    'label' => 'qarze_hasana_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'financial_support_total' => array(
                    'label' => 'financial_support_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'funeral_service_total' => array(
                    'label' => 'funeral_service_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'family_counselling_total' => array(
                    'label' => 'family_counselling_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'neighbour_support_total' => array(
                    'label' => 'neighbour_support_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                
                'library_total' => array(
                    'label' => 'library_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'book_total' => array(
                    'label' => 'book_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'book_distribution' => array(
                    'label' => 'book_distribution',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'cassette_cd_total' => array(
                    'label' => 'cassette_cd_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'cassette_cd_distribution' => array(
                    'label' => 'cassette_cd_distribution',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'facility_of_selling_book' => array(
                    'label' => 'facility_of_selling_book',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                
                'visit_central_to_unit_total' => array(
                    'label' => 'visit_central_to_unit_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'visit_central_to_unit_total_visitors' => array(
                    'label' => 'visit_central_to_unit_total_visitors',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'visit_central_to_unit_name_visitors' => array(
                    'label' => 'visit_central_to_unit_name_visitors',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'visit_unit_to_unit_total' => array(
                    'label' => 'visit_unit_to_unit_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'visit_unit_to_unit_total_visitors' => array(
                    'label' => 'visit_unit_to_unit_total_visitors',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'visit_unit_to_unit_name_visitors' => array(
                    'label' => 'visit_unit_to_unit_name_visitors',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                'visit_unit_to_sub_unit_total' => array(
                    'label' => 'visit_unit_to_sub_unit_total',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'visit_unit_to_sub_unit_total_visitors' => array(
                    'label' => 'visit_unit_to_sub_unit_total_visitors',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'visit_unit_to_sub_unit_name_visitors' => array(
                    'label' => 'visit_unit_to_sub_unit_name_visitors',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                
                'last_report_carry_forward' => array(
                    'label' => 'last_report_carry_forward',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                'eanat_collection' => array(
                    'label' => 'eanat_collection',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                'special_donation' => array(
                    'label' => 'special_donation',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                'other_income' => array(
                    'label' => 'other_income',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                'expense_in_unit' => array(
                    'label' => 'expense_in_unit',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                'remittance_to_federal' => array(
                    'label' => 'remittance_to_federal',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                'other_expense' => array(
                    'label' => 'other_expense',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                'surplus_deficit' => array(
                    'label' => 'surplus_deficit',
                    'type' => 'decimal',
                    'behavior' => NULL,
                ),
                
                'general_meeting_number' => array(
                    'label' => 'General Meeting Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'general_meeting_total_present' => array(
                    'label' => 'General Meeting Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'introduction_distribution_number' => array(
                    'label' => 'Introduction Distribution Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sirat_tafseer_mahfil_number' => array(
                    'label' => 'Sirat Tafseer Mahfil Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sirat_tafseer_mahfil_total_present' => array(
                    'label' => 'Sirat Tafseer Mahfil Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'personal_book_distribution_number' => array(
                    'label' => 'Introduction Distribution Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'day_eid_reunion_number' => array(
                    'label' => 'day_eid_reunion_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'day_eid_reunion_total_present' => array(
                    'label' => 'Day Eid Reunion Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'cassette_cd_distribution_number' => array(
                    'label' => 'Cassette CD Distribution Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'dawah_group_number' => array(
                    'label' => 'Dawah Group Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'dawah_group_total_present' => array(
                    'label' => 'Dawah Group Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'leaflet_distribution_number' => array(
                    'label' => 'Leaflet Distribution Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'picnic_education_tour_number' => array(
                    'label' => 'Picnic Education Tour Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'picnic_education_tour_total_present' => array(
                    'label' => 'Picnic Education Tour Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'dawah_gift_distribution_number' => array(
                    'label' => 'Dawah Gift Distribution Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'iftar_tea_potluc_number' => array(
                    'label' => 'Iftar Tea Potluc Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'iftar_tea_potluc_total_present' => array(
                    'label' => 'Iftar Tea Potluc Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'calendar_magazine_distribution_number' => array(
                    'label' => 'Calendar Magazine Distribution Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'dawah_week_month_number' => array(
                    'label' => 'Dawah Week Month Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'dawah_week_month_total_present' => array(
                    'label' => 'Dawah Week Month Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'others_number' => array(
                    'label' => 'Others Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'education_camp_number' => array(
                    'label' => 'Education Camp Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'education_camp_total_present' => array(
                    'label' => 'Education Camp Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'group_reading_number' => array(
                    'label' => 'Group Reading Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'group_reading_total_present' => array(
                    'label' => 'Group Reading Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'education_session_number' => array(
                    'label' => 'Education Session Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'education_session_total_present' => array(
                    'label' => 'Education Session Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'gen_study_session_number' => array(
                    'label' => 'Gen Study Session Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'gen_study_session_total_present' => array(
                    'label' => 'Gen Study Session Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'qiamul_lail_speical_number' => array(
                    'label' => 'Qiamul Lail Speical Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'qiamul_lail_speical_total_present' => array(
                    'label' => 'Qiamul Lail Speical Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sahih_quran_talim_number' => array(
                    'label' => 'Sahih Quran Talim Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sahih_quran_talim_total_present' => array(
                    'label' => 'sahih Quran Talim Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'qiamul_lail_aam_number' => array(
                    'label' => 'Qiamul Lail Aam Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'qiamul_lail_aam_total_present' => array(
                    'label' => 'Qiamul Lail Aam Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'leader_education_group_number' => array(
                    'label' => 'Leader Education Group Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'leader_education_group_total_present' => array(
                    'label' => 'Leader Education Group Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'study_circle_group_number' => array(
                    'label' => 'Study Circle Group Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'speech_practice_number' => array(
                    'label' => 'Speech Practice Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'speech_practice_total_present' => array(
                    'label' => 'Speech Practice Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'study_circle_session_number' => array(
                    'label' => 'Study Circle Session Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'study_circle_session_total_present' => array(
                    'label' => 'Study Circle Session Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'associate_member_education_number' => array(
                    'label' => 'Associate Member Education Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'associate_member_education_total_present' => array(
                    'label' => 'Associate Member Education Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_monthly_meeting_number' => array(
                    'label' => 'Sub Unit  Monthly Meeting Number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'sub_unit_monthly_meeting_total_present' => array(
                    'label' => 'Sub Unit Monthly Meeting Total Present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'section_id' => array(
                    'label' => 'section_id',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'current_month' => array(
                    'label' => 'Current Month',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                
                'unit_leader_note' => array(
                    'label' => 'unit_leader_note',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
                
                
                
                'family_halaqa_number' => array(
                    'label' => 'family_halaqa_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'family_halaqa_total_present' => array(
                    'label' => 'family_halaqa_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'youth_halaqa_number' => array(
                    'label' => 'youth_halaqa_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'youth_halaqa_total_present' => array(
                    'label' => 'youth_halaqa_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'children_program_number' => array(
                    'label' => 'children_program_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'seminars_number' => array(
                    'label' => 'seminars_number',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'children_program_total_present' => array(
                    'label' => 'children_program_total_present',
                    'type' => 'integer',
                    'behavior' => NULL,
                ),
                'end_month' => array(
                    'label' => 'end_month',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'report_completed' => array(
                    'label' => 'report_completed',
                    'type' => 'integer',
                    'behavior' => '',
                ),
                'president_comment' => array(
                    'label' => 'president_comment',
                    'type' => 'text_long',
                    'behavior' => NULL,
                ),
            ),
        ),
    );
    return $items;
}
