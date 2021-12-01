<?php
//_print_var_dump($form);
unset($form['field_mcc_membership']['und'][0]['#title']);
unset($form['field_subtitle']['und'][0]['value']['#title']);
unset($form['field_number_of_supporters']['und'][0]['value']['#title']);
unset($form['field_number_of_a_member']['und'][0]['value']['#title']);
unset($form['field_number_of_members']['und'][0]['value']['#title']);
unset($form['field_number_of_unit_sub_unit']['und'][0]['value']['#title']);
unset($form['field_dawah_experience']['und'][0]['value']['#title']);
unset($form['field_name']['und'][0]['value']['#title']);
unset($form['field_most_interested_in']['und'][0]['#title']);
unset($form['field_most_interested_in']['und']['#title']);
unset($form['field_ssc_grade_10']['und'][0]['value']['#title']);
unset($form['field_hsc_grade_12']['und'][0]['value']['#title']);
unset($form['field_university_undergraduate']['und'][0]['value']['#title']);

$form['field_mcc_membership']['und'][0]['#theme_wrappers'] = array();
$form['field_subtitle']['#theme_wrappers'] = array();
$form['field_subtitle']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_number_of_supporters']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_number_of_a_member']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_number_of_members']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_number_of_unit_sub_unit']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_dawah_experience']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_name']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_most_interested_in']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_most_interested_in']['#theme_wrappers'] = array();
$form['field_ssc_grade_10']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_hsc_grade_12']['und'][0]['value']['#theme_wrappers'] = array();
$form['field_university_undergraduate']['und'][0]['value']['#theme_wrappers'] = array();
?>
<div class="table-responsive">
    <?php print drupal_render($form['title']); ?>
    <table class="table table-bordered table-sm section-report-form-table">
        <thead>
            <tr>
                <td>MCC Membership Since</td>
                <td>Present Responsibility</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php print drupal_render($form['field_mcc_membership']); ?></td>
                <td><?php print drupal_render($form['field_subtitle']); ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm section-report-form-table">
        <thead>
            <tr>
                <td colspan="4"><b>Contribution to MCC</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Number of Supporters Increased</td>
                <td><?php print drupal_render($form['field_number_of_supporters']); ?></td>
                <td>Number of Associate Members Increased</td>
                <td><?php print drupal_render($form['field_number_of_a_member']); ?></td>
            </tr>
            <tr>
                <td>Number of Members Increased</td>
                <td><?php print drupal_render($form['field_number_of_members']); ?></td>
                <td>Number of Unit/Sub-Unit Increased</td>
                <td><?php print drupal_render($form['field_number_of_unit_sub_unit']); ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm section-report-form-table">
        <thead>
            <tr>
                <td colspan="4"><b>Contribution to Islam</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Dawah Experience</td>
                <td><?php print drupal_render($form['field_dawah_experience']); ?></td>
                <td>Specialist in the field of Islam</td>
                <td><?php print drupal_render($form['field_name']); ?></td>
            </tr>
            <tr>
                <td>Most Interested in</td>
                <td colspan="3"><?php print drupal_render($form['field_most_interested_in']); ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm section-report-form-table">
        <thead>
            <tr>
                <td colspan="4"><b>Education (Institute Name Only)</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SSC</td>
                <td><?php print drupal_render($form['field_ssc_grade_10']); ?></td>
                <td>HSC</td>
                <td><?php print drupal_render($form['field_hsc_grade_12']); ?></td>
            </tr>
            <tr>
                <td>University</td>
                <td colspan="3"><?php print drupal_render($form['field_university_undergraduate']); ?></td>
            </tr>
        </tbody>
    </table>
    <?php //print drupal_render($form['additional_settings']); ?>
    <?php //print drupal_render($form['actions']); ?>
    <?php print drupal_render_children($form); ?>
</div>