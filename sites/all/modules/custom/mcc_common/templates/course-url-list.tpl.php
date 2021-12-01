<div class="white-box">
  <div class="table-responsive">
    <table class="table table-striped table-bordered nowrap" id="course_url_list-table">
      <thead>
        <tr class="tablehead">
          <th class="">Course</th>
          <th class="">URL</th>
          <th class="">Operation</th>
        </tr>        
      </thead>
      <tbody>
        <?php if (!empty($urls)) { ?>
          <?php foreach ($urls as $url): ?>
            <tr>
              <td><?php echo $url['course_code']; ?></td>
              <td><?php echo $url['course_url']; ?></td>
              <td>
                  <a onclick="return confirm('Are You Sure')"  href="/syllabus/course-url-delete/<?php echo $url['id']; ?>">DELETE</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php } ?>
      </tbody>

    </table>
  </div>
</div>