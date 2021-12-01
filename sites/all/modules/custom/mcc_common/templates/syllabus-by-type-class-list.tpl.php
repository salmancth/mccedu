<div class="white-box">
    <!--    <div class="alert alert-success text-center report-header" role="alert">    
            <span class="">Classes</span>
        </div>-->
    <!--<a href="javascript:void(0);" class="btn btn-default" onclick="location.href = '/syllabus/course-class-create';">Add New Class</a>-->
    <?php // pretty_print($class_list); ?>
    <?php if (!empty($class_list)) { ?>
        <div class="table-responsive">
            <div class="demo-html"></div>
            <table width="100%" class="table table-striped table-bordered nowrap class-table" id="class-report-table">
                <thead>
                    <tr class="tablehead">
                        <th>Course Code</th>
                        <th>Session</th>                
                        <th>Date</th>
                        <th>Total Present</th>
                        <!--<th>Attendees</th>-->
                        <th>SMS Code</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $row_cnt = 1; ?>
                    <?php foreach ($class_list as $report) { ?>
                        <tr>
                            <td><?php echo $report->course_code; ?></td>
                            <td><?php echo ucwords($report->session) . '-' . $report->year; ?></td>
                            <td><?php echo format_date($report->class_date, 'custom', 'Y-m-d H:i'); ?></td>
                            <!--<td><?php // echo $report->class_presents;  ?></td>-->
                            <td>
                                <?php
                                $attend_details = '';
                                $class_attendees = drupal_json_decode($report->class_attendees);
                                $class_attendees = (array) $class_attendees;
                                if (!empty($class_attendees['manual'])) {
                                    $attend_details .= 'Manual: ';
                                    $attend_details .= implode(', ', $class_attendees['manual']);
                                    $attend_details .= '<br/>';
                                }
                                if (!empty($class_attendees['sms'])) {
                                    $attend_details .= 'SMS: ';
                                    $attend_details .= implode(', ', $class_attendees['sms']['sms']);
                                    $attend_details .= '<br/>';
                                }
                                if (empty($attend_details)) {
                                    $attend_details = 'No Information Found!';
                                }
                                ?>
                                <span class="cls-attnd" data-toggle="tooltip" data-placement="top" title="<?php echo $attend_details; ?>" onclick="showDetails(<?php echo $row_cnt; ?>)">
                                    <?php echo $report->class_presents; ?>
                                </span>
                                <span class="adl" id="adl-<?php echo $row_cnt; ?>"><br/><?php echo $attend_details; ?></span>
                            </td>
                            <td><?php echo!empty($report->sms_code) ? $report->sms_code . ' <a href="/syllabus/update-class-attendess/' . $report->id . '">Update Attendees</a>' : ''; ?></td>
                            <td>
                                <?php echo '<a href="/syllabus/course-class/edit/' . $report->id . '">EDIT</a>'; ?> | 
                                <?php echo '<a href="/syllabus/course-class/delete/' . $report->id . '">DELETE</a>'; ?>
                            </td>
                        </tr>
                    <?php $row_cnt++; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>
<script type = "text/javascript" >
    function showDetails(id) {
        jQuery("#adl-"+id).toggle();
    }
    jQuery(document).ready(function ($) {
        $(".cls-attnd").tooltip({boundary: 'window', html: true});
        if ($('#class-report-table').length) {
            var table = $('#class-report-table').DataTable({
                "lengthMenu": [[25, 50, 100], [25, 50, 100]],
                "processing": true,
                "orderCellsTop": true,
                "select": true
            });
        }

//        var dataUrl = '/syllabus/course-classes/datatable';
//        var table = $('#class-report-table').DataTable({
//            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
//            "processing": true,
//            "serverSide": true,
//            "orderCellsTop": false,
//            "ordering": false,
//            "searching": false,
//            "ajax": dataUrl,
//            "columnDefs": [
////                {targets: [0], orderable: true},
////                {targets: '_all', orderable: false},
////                {targets: [0], className: "mcc_click_col"}
//            ]
//        });
//        $('#class-report-table tbody').on('click', 'tr > td a.view_attendees', function() {
//            ShowRowInfo((this), [3, 4, 5, 6]);
//        });
    });
//    function stopPropagation(evt) {
//        if (evt.stopPropagation !== undefined) {
//            evt.stopPropagation();
//        } else {
//            evt.cancelBubble = true;
//        }
//    }
//    function ShowRowInfo(o, arr) {
//        var th, tr;
//        var colData = {data: []};
//
//        th = jQuery(o).closest("table").find("thead tr.tablehead");
//        tr = jQuery(o).closest('tr');
//        jQuery('.modal-body table').empty();
//
//        th.find('th').each(function(i) {
//            //console.log(i);
//            //if (jQuery.inArray(i, arr) === -1) {
//            //console.log('pushing='+i);
//            colData.data.push({"col": jQuery(this).html(), "value": tr.find("td:nth(" + i + ")").html()});
//            //};
//        });
//
//        jQuery.each(colData.data, function(j) {
//            console.log(j);
//            if (jQuery.inArray(j, arr) === -1) {
//                console.log('pushing=' + j);
//                jQuery('.modal-body table').append("<tr><td>" + colData.data[j].col + "</td><td>" + colData.data[j].value + "</td></tr>");
//            }
//        });
//
//        jQuery("#rowInfoModal").modal();
//    }
</script>
<style type="text/css" class="init">
    /*    #class-report-table tr td:nth-child(5),
        #class-report-table tr th:nth-child(5) {
            display: none;
        }*/
    .adl {
        display: none
    }
    .cls-attnd {
        cursor: pointer
    }
</style>