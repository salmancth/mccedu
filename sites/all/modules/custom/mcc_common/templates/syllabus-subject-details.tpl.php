<?php
if (!empty($sub_details)) {
  pretty_print($sub_details, 0);
  global $base_url;
  //$material_url = '/sites/default/files/mcc_syllabus/materials/';
  //$material_url = 'public://mcc_syllabus/materials/';
  $material_url = 'mcc_syllabus/materials/';
  $allowed_file_extensions = array('doc', 'docx', 'pdf', 'ppt', 'pptx');
  $displayed = false;
  $display_class = 'show';
  ?>  
  <div class="breadcrumb">
    <div style="display: inline-block">
      <span style="font-size: 50px; padding: 10px" class="glyphicon glyphicon-book" aria-hidden="true"></span>       
    </div>
    <div style="display: inline-block">
      <a style="font-size: 25px"><?php echo $sub_details['subject']['name']; ?></a>
      <p class="text-muted">
        <?php if (!empty($dept)): ?>
          <a href="/academic-syllabus#<?php echo $dept->shortcode; ?>"><?php echo $dept->name; ?></a>
        <?php endif; ?>
      </p>
    </div>

  </div>
  <ul class="nav customtab nav-tabs" role="tablist">
    <?php if (!empty($sub_details['subject']['learning_objectives'])) { ?>
      <li  role="presentation" class="nav-item active">
        <a class="nav-link" data-toggle="tab" href="#lo">Learning Objectives</a>
      </li>
    <?php } ?>
    <?php if (!empty($sub_details['subject']['course_contents'])) { ?>
      <li role="presentation" class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#cc">Course Contents</a>
      </li>  
    <?php } ?>
    <?php if (!empty($sub_details['subject']['text'])) { ?>
      <li role="presentation" class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#text">Text Materials</a>
      </li>  
    <?php } ?>
    <?php if (!empty($sub_details['subject']['ref'])) { ?>
      <li role="presentation" class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ref">Reference Materials</a>
      </li>  
    <?php } ?>
    <?php if (!empty($uploaed_audio_video)): ?>
      <li role="presentation" class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#audio_video">Audio/ Video</a>
      </li>
    <?php endif; ?>
    <?php if (!empty($sub_details['subject_has_questions']->total_questions)) { ?>
      <li role="presentation" class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#exam">Course Exam</a>
      </li>  
    <?php } ?>
  </ul>
  <div class="tab-content">
    <?php if (!empty($sub_details['subject']['learning_objectives'])) { ?>
      <div id="lo" class="tab-pane fade active in <?php echo $display_class; ?>" role="tabpanel">      
        <div class="panel panel-default"> 
          <div class="panel-heading"> <h3 class="panel-title">Learning Objectives</h3> </div> 
          <div class="panel-body"> 
            <?php echo $sub_details['subject']['learning_objectives']; ?>
          </div> 
        </div>        
        <?php if (!empty($sub_details['subject']['learning_objectives_details'])) { ?>
          <div class="panel panel-default"> 
            <div class="panel-heading"> <h3 class="panel-title">Learning Objectives Details</h3> </div> 
            <div class="panel-body"> 
              <?php echo $sub_details['subject']['learning_objectives_details']; ?>
            </div> 
          </div>
        <?php } ?>
      </div>
      <?php $display_class = ''; ?>
    <?php } ?>
    <?php if (!empty($sub_details['subject']['course_contents'])) { ?>
      <div id="cc" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">      
        <div class="panel panel-default"> 
          <div class="panel-heading"> <h3 class="panel-title">Course Contents</h3> </div> 
          <div class="panel-body"> 
            <?php $cc_count = 1; ?>
            <?php foreach ($sub_details['subject']['course_contents'] as $course_contents) { ?>
              <?php echo nl2br(decode_entities($course_contents['module']['module_details'])); ?><br/>
              <?php
              $found_material = false;
              foreach ($module_materials as $material) {
                $material = array_pop($material);
                if ($material['module_no'] == $cc_count) {
                  ?>
                  <i class = "fa fa-file-text-o" aria-hidden = "true"></i> 
                  <?php
                  $curr_file_url = '';
                  $curr_file_url = _prepare_materials_url($material['file']->uri);
                  $found_material = true;
                  ?>
                  <?php if (!empty($curr_file_url)) { ?>
                    <a class="ctools-use-modal" href="/read-pdf/nojs/<?php
                    echo $material['file']->fid;
                    ;
                    ?>">
                      <span><?php echo $material['file']->filename; ?></span>
                    </a><br/>
                    <?php
                  }
                }
              }
              if ($found_material)
                echo "<hr/>";
              $cc_count++;
              ?>
            <?php } ?>
          </div> 
        </div>        
        <?php if (!empty($sub_details['subject']['course_contents_details'])) { ?>
          <div class="panel panel-default"> 
            <div class="panel-heading"> <h3 class="panel-title">Course Contents Details</h3> </div> 
            <div class="panel-body"> 
              <?php echo nl2br($sub_details['subject']['course_contents_details']); ?>
            </div> 
          </div>
        <?php } ?>
      </div>
      <?php $display_class = ''; ?>
    <?php } ?>
    <?php if (!empty($sub_details['subject']['text'])) { ?>
      <div id="text" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
        <div class="card" style="padding: 10px">
          <ul class="common-list">
            <?php foreach ($sub_details['subject']['text'] as $text) { ?>
              <li><a><i class="fa fa-bookmark"></i> <?php echo _prepare_hyperlinked_text($text['material']['name']); ?></a></li>
            <?php } ?>
          </ul>
          <?php if (!empty($uploaded_text)) : ?>
            <hr/>
            <div class="row row in text-center">
              <?php foreach ($uploaded_text as $text): ?>
                <div class="col col-md-2 col-xs-12 m-b-10">
                  <div><i style="font-size: 60px" class="fa fa-book" aria-hidden="true"></i></div>
                  <?php
                  $curr_file_url = '';
                  $curr_file_url = _prepare_materials_url($text->uri);
                  ?>
                  <?php if (!empty($curr_file_url)) { ?>
                    <div>
                      <a class="ctools-use-modal" href="/read-pdf/nojs/<?php echo $text->fid; //$curr_file_url;                ?>">
                        <span><?php echo $text->filename; ?></span>
                      </a>
                    </div>
                  <?php } ?>
                </div>              
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>      
      </div>
      <?php $display_class = ''; ?>
    <?php } ?>
    <?php if (!empty($sub_details['subject']['ref'])) { ?>
      <div id="ref" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
        <div class="card" style="padding: 10px">
          <ul class="common-list">
            <?php foreach ($sub_details['subject']['ref'] as $ref) { ?>
              <li><a><i class="fa fa-bookmark"></i> <?php echo _prepare_hyperlinked_text($ref['material']['name']); ?></a></li>
            <?php } ?>
          </ul>
          <?php if (!empty($uploaded_ref)) : ?>
            <hr/>
            <div class="row row in text-center">
              <?php foreach ($uploaded_ref as $text): ?>
                <div class="col col-md-2 col-xs-12 m-b-10">
                  <div><i style="font-size: 60px" class="fa fa-book" aria-hidden="true"></i></div>              
                  <?php
                  $curr_file_url = '';
                  $curr_file_url = _prepare_materials_url($text->uri);
                  ?>
                  <?php if (!empty($curr_file_url)) { ?>
                    <div>
                      <a class="ctools-use-modal" href="/read-pdf/nojs/<?php echo $text->fid; //$curr_file_url;                ?>">
                        <span><?php echo $text->filename; ?></span>
                      </a>
                    </div>
                  <?php } ?>
                </div>              
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>      
      </div>
      <?php $display_class = ''; ?>
    <?php } ?>
    <?php if (!empty($uploaed_audio_video)): ?>
      <div id="audio_video" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
        <div class="card" style="padding: 10px">
          <?php foreach ($uploaed_audio_video as $key => $value) { ?>
            <div class="well well-sm">
              <video width="400" controls style="margin: auto; display: block">
                <source src="<?php echo file_create_url($value->uri) ?>" type="video/mp4">
                Your browser does not support HTML5 video.
              </video>
            </div>
          <?php } ?>
        </div>      
      </div>
      <?php $display_class = ''; ?>
    <?php endif; ?>
    <?php //pretty_print($uploaed_audio_video, 0);     ?>
    <?php if (!empty($sub_details['subject_has_questions']->total_questions)) { ?>
      <div id="exam" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
        <div class="card" style="padding: 10px">
          <ul class="common-list">
          </ul>          
        </div>
      </div>
      <?php $display_class = ''; ?> 
    <?php } ?>
  </div>
  <?php
} else {
  ?>
  <div class="alert alert-danger" role="alert">Subject Not Found</div>
  <?php
}