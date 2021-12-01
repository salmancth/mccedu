<div class="white-box">
  <?php if ($text_ref_materials) { ?>
    <div class="table-responsive">    
      <div class="demo-html"></div>
      <table class="table table-striped table-bordered nowrap" id="materials_list-table">
        <thead>
          <tr class="tablehead">
            <th class="">Name</th>
            <th class="">URL</th>
            <th class="">Course</th>
            <th class="">Text/ Ref</th>
            <th class="">Operation</th>
          </tr>        
        </thead>
        <tbody>
          <?php foreach ($uploaed_materials as $material): ?>
            <?php
            $uri_s = explode('/', $material->uri);
            ?>
            <tr>
              <td><?php echo $material->filename; ?></td>
              <td><a href="<?php echo file_create_url($material->uri); ?>" target="_blank">Go to File <i class="fa fa-external-link"></i></a></td>
              <td><?php echo (!empty($uri_s[4])) ? $uri_s[4] : '' ?></td>
              <td><?php echo (!empty($uri_s[5])) ? ucfirst($uri_s[5]) : '' ?></td>
              <td><a onclick="return confirm('Are You Sure')" href='<?php echo $remove_materials_url . $material->fid; ?>'>Remove</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </div>
  <?php } if ($module_content) { ?>
    <div class="table-responsive">    
      <div class="demo-html"></div>
      <table class="table table-striped table-bordered nowrap" id="module_content_list-table">
        <thead>
          <tr class="tablehead">
            <th class="">Name</th>
            <th class="">URL</th>
            <th class="">Operation</th>
          </tr>        
        </thead>
        <tbody>
          <?php foreach ($uploaed_materials as $material): ?>
            <tr>
              <td><?php echo $material->filename; ?></td>
              <td><a href="<?php echo file_create_url($material->uri); ?>" target="_blank">Go to File <i class="fa fa-external-link"></i></a></td>
              <td><a onclick="return confirm('Are You Sure')" href='<?php echo $remove_materials_url . $material->fid; ?>'>Remove</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </div>
  <?php } ?>
</div>