<?php print drupal_render($form['title']); ?>
<?php print drupal_render($form['field_report_month_year']); ?>
<br/>
<?php
//echo '<pre>';
//print_r($form['field_mp_member_total']);
//echo '</pre>';
?>
<div class="table-responsive report-data">       
    <table class="table table-hover table-condensed">
        <thead>
            <tr class="info">
                <th>Manpower</th>
                <th>Last Month</th>
                <th>Increase</th>
                <th>Decrease</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Member</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td>
                    <?php
                    $form['field_mp_member_total']['#title_display'] = 'invisible';
                    print drupal_render($form['field_mp_member_total']);
                    ?>
                </td>
            </tr>
            <tr>
                <td>Member Applicant</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td>
                    <?php
                    $form['field_mp_memberapp_total']['#title_display'] = 'invisible';
                    print drupal_render($form['field_mp_memberapp_total']);
                    ?>
                </td>
            </tr>
            <tr>
                <td>Associate Member</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td>
                    <?php
                    $form['field_mp_memberassoc_total']['#title_display'] = 'invisible';
                    print drupal_render($form['field_mp_memberassoc_total']);
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive report-data">       
    <table class="table table-hover table-condensed">
        <thead>
            <tr class="info">
                <th>Organization</th>
                <th>Last Month</th>
                <th>Increase</th>
                <th>Decrease</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td> <?php print drupal_render($form['field_unit_total']); ?> </td>
            </tr>
            <tr>
                <td>Sub Unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td> <?php print drupal_render($form['field_sub_unit_total']); ?> </td>
            </tr>
            <tr>
                <td>Youth Sub Unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td> <?php print drupal_render($form['field_youth_sub_unit_total']); ?> </td>
            </tr>
            <tr>
                <td>Dawah Unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td> <?php print drupal_render($form['field_dawah_unit_total']); ?> </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive report-data">       
    <table class="table table-hover table-condensed">
        <thead>
            <tr class="info">
                <th>Dawah Work</th>
                <th>No</th>
                <th>Total Present</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Halakah</td>
                <td><?php print drupal_render($form['field_halakah_total']); ?></td>
                <td><?php print drupal_render($form['field_halakah_total_preseent']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>General Meeting</td>                
                <td><?php print drupal_render($form['field_general_meeting_total']); ?></td>
                <td><?php print drupal_render($form['field_general_meeting_total_pres']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Day Observation</td>
                <td><?php print drupal_render($form['field_day_observation_total']); ?></td>
                <td><?php print drupal_render($form['field_day_observation_total_pres']); ?></td>
                                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Iftar Program</td>
                <td><?php print drupal_render($form['field_iftar_program_total']); ?></td>
                <td><?php print drupal_render($form['field_iftar_program_total_presen']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Porichiti Distribution</td>
                <td><?php print drupal_render($form['field_porichiti_distribution']); ?></td>
                <td><?php print drupal_render($form['field_porichiti_distribution_pre']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Personal Book Distribution</td>
                <td><?php print drupal_render($form['field_book_distribution_total']); ?></td>
                <td><?php print drupal_render($form['field_book_distribution_total_pr']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Dawah Gift</td>
                <td><?php print drupal_render($form['field_dawah_gift_total']); ?></td>
                <td><?php print drupal_render($form['field_dawah_gift_total_present']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Picnic</td>
                <td><?php print drupal_render($form['field_picnic_total']); ?></td>
                <td><?php print drupal_render($form['field_picnic_total_present']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Dawah Total Hours from Manpower</td>
                <td colspan="3"><?php print drupal_render($form['field_dawah_total_hours_from_man']); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive report-data">       
    <table class="table table-hover table-condensed">
        <thead>
            <tr class="info">
                <th>Education</th>
                <th>No</th>
                <th>Total Present</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Education Camp</td>
                <td><?php print drupal_render($form['field_education_camp_total']); ?></td>
                <td><?php print drupal_render($form['field_education_camp_total_prese']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>ES</td>                
                <td><?php print drupal_render($form['field_es_total']); ?></td>
                <td><?php print drupal_render($form['field_es_total_present']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Qiamul- Layel Special</td>
                <td><?php print drupal_render($form['field_qiamul_layel_special_total']); ?></td>
                <td><?php print drupal_render($form['field_qiamul_layel_sp_total_pres']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Qiamul- Layel Aam</td>
                <td><?php print drupal_render($form['field_qiamul_layel_aam_total']); ?></td>
                <td><?php print drupal_render($form['field_qiamul_layel_aam_total_pre']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Study Circle Group</td>
                <td><?php print drupal_render($form['field_study_circle_group_total']); ?></td>
                <td><?php print drupal_render($form['field_study_circle_group_total_p']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Study Circle Session</td>
                <td><?php print drupal_render($form['field_study_circle_session']); ?></td>
                <td><?php print drupal_render($form['field_study_circle_session_prese']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Saheeh Quran Talim</td>
                <td><?php print drupal_render($form['field_saheeh_quran_talim_total']); ?></td>
                <td><?php print drupal_render($form['field_saheeh_quran_talim_total_p']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Day long Study circle</td>
                <td><?php print drupal_render($form['field_day_long_study_circle_tota']); ?></td>
                <td><?php print drupal_render($form['field_day_long_scircle_tota_pres']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Others general tarbiyah</td>
                <td><?php print drupal_render($form['field_others_general_tarbiyah_to']); ?></td>
                <td><?php print drupal_render($form['field_others_g_tarbiyah_present']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive report-data">       
    <table class="table table-hover table-condensed">
        <thead>
            <tr class="info">
                <th>Meeting</th>
                <th>No</th>
                <th>Total Present</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Secretariat Meeting</td>
                <td><?php print drupal_render($form['field_secretariat_meeting']); ?></td>
                <td><?php print drupal_render($form['field_secretariat_meeting_presen']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Emergency Secretariat Meeting</td>                
                <td><?php print drupal_render($form['field_emergency_secretariat_meet']); ?></td>
                <td><?php print drupal_render($form['field_emergency_secretariat_pres']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Members Meeting</td>
                <td><?php print drupal_render($form['field_members_meeting']); ?></td>
                <td><?php print drupal_render($form['field_members_meeting_present']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Emg. Member Meeting</td>
                <td><?php print drupal_render($form['field_emg_member_meeting']); ?></td>
                <td><?php print drupal_render($form['field_emg_member_meeting_present']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Asso. Member  Meeting</td>
                <td><?php print drupal_render($form['field_asso_member_meeting']); ?></td>
                <td><?php print drupal_render($form['field_asso_member_meeting_presen']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
            <tr>
                <td>Others</td>
                <td><?php print drupal_render($form['field_others_meeting']); ?></td>
                <td><?php print drupal_render($form['field_others_meeting_present']); ?></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive report-data">       
    <table class="table table-hover table-condensed">
        <thead>
            <tr class="info">
                <th>Library</th>
                <th>Last Month</th>
                <th>Increase</th>
                <th>Decrease</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Number of Library</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php print drupal_render($form['field_number_of_library']); ?></td>
            </tr>
            <tr>
                <td>Number of Books</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php print drupal_render($form['field_number_of_books']); ?></td>
            </tr>
            <tr>
                <td>Total Book Distribution</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php print drupal_render($form['field_total_book_distribution_li']); ?></td>
            </tr>
            <tr>
                <td>Number of Cassette. & CD</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php print drupal_render($form['field_number_of_cassette_cd']); ?></td>
            </tr>
            <tr>
                <td>Total Cassette. & CD. Dist.</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php print drupal_render($form['field_total_cassette_cd_dist']); ?></td>
            </tr>            
        </tbody>
    </table>
</div>

<div class="table-responsive report-data">       
    <table class="table table-hover table-condensed">
        <thead>
            <tr class="info">
                <th>Visit</th>
                <th>No</th>
                <th>Name Of the Visitors</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Central to Unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php //print drupal_render($form['field_mp_member_total']); ?></td>
            </tr>
            <tr>
                <td>Central  to Sub-unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php //print drupal_render($form['field_mp_member_total']); ?></td>
            </tr>
            <tr>
                <td>Unit to sub-unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php //print drupal_render($form['field_mp_member_total']); ?></td>
            </tr>
            <tr>
                <td>One unit to another unit</td>
                <td><input type="text" disabled="disabled" value="" size="12" /></td>
                <td><?php //print drupal_render($form['field_mp_member_total']); ?></td>
            </tr>            
        </tbody>
    </table>
</div>
<?php
print drupal_render_children($form);
?>