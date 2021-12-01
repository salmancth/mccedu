<?php
//pretty_print($uploaed_audio_video, 0);
?>
<div class="white-box">
  <div class="table-responsive">    
    <div class="demo-html"></div>
    <table class="table table-striped table-bordered nowrap" id="audio_video_list-table">
      <thead>
        <tr class="tablehead">
          <th class="">Name</th>
          <th class="">URL</th>
          <th class="">Course</th>
          <th class="">Operation</th>
        </tr>        
      </thead>
      <tbody>
        <?php foreach ($uploaed_audio_video as $audio_video): ?>
          <?php
          $uri_s = explode('/', $audio_video->uri);
          ?>
          <tr>
            <td><?php echo $audio_video->filename; ?></td>
            <td><a href="<?php echo file_create_url($audio_video->uri); ?>" target="_blank">Go to File <i class="fa fa-external-link"></i></a></td>
            <td><?php echo (!empty($uri_s[4])) ? $uri_s[4] : '' ?></td>
            <td><a onclick="return confirm('Are You Sure')" href='<?php echo $remove_url . $audio_video->fid; ?>'>Remove</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  </div>
</div>