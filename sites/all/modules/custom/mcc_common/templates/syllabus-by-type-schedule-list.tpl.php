<div class="white-box">
    <div class="alert alert-success text-center report-header" role="alert">    
        <span class="">Schedule</span>
    </div>
    <!--<a href="javascript:void(0);" class="btn btn-default" onclick="location.href = '/syllabus/course-class-create';">Add New Class</a>-->
    <div class="table-responsive">
        <div class="demo-html"></div>
        <table width="100%" class="table table-striped table-bordered nowrap class-table" id="class-schedule-table">
            <thead>
                <tr class="tablehead">
                    <th>Course Code</th>            
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>        
        </table>
    </div>
</div>
<script type = "text/javascript" >
    jQuery(document).ready(function($) {
        var dataUrl = '/syllabus/course-schedule/datatable';
        var table = $('#class-schedule-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "serverSide": true,
            "orderCellsTop": false,
            "ordering": false,
            "searching": false,
            "ajax": dataUrl,
            "columnDefs": [
//                {targets: [0], orderable: true},
//                {targets: '_all', orderable: false},
//                {targets: [0], className: "mcc_click_col"}
            ]
        });
    });
    function stopPropagation(evt) {
        if (evt.stopPropagation !== undefined) {
            evt.stopPropagation();
        } else {
            evt.cancelBubble = true;
        }
    }
</script>
<style type="text/css" class="init">
    #class-report-table tr td:nth-child(5),
    #class-report-table tr th:nth-child(5) {
        display: none;
    }
</style>