<div id='edu_calendar_div'></div>
<script>
  var calendarEvents = {"monthly":<?php echo $calendar_events_json; ?>};
  jQuery(document).ready(function($) {
    var targetDiv = 'edu_calendar_div';
    $(document.body).off('click', '#' + targetDiv + ' .monthly-next');
    $(document.body).off('click', '#' + targetDiv + ' .monthly-prev');
    $(document.body).off('click', '#' + targetDiv + ' .monthly-reset');
    $(document.body).off('click', '#' + targetDiv + ' .monthly-cal');
    $(document.body).off('click', '#' + targetDiv + ' a.monthly-day');
    $(document.body).off('click', '#' + targetDiv + ' .listed-event');

    $('#' + targetDiv).monthly({
      mode: 'event',
      dataType: 'json',
      events: calendarEvents
    })
  });
</script>