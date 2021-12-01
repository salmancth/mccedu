<div class="white-box">
  <div class="table-responsive">
    <table class="table table-striped table-bordered nowrap" id="uploaded_qb_list-table">
      <thead>
        <tr class="tablehead">
          <th class="">Question</th>
          <th class="">Answers</th>
          <th class="">Subject</th>
          <th class="">Module</th>
          <th class="">Operation</th>
        </tr>        
      </thead>
      <tbody>
        <?php if (!empty($uploaded_questions)) { ?>
          <?php foreach ($uploaded_questions as $question): ?>
            <?php
//          $answers = unserialize($question['answers']);
//          pretty_print($question, 0);
//          var_dump($question['answers1']);
            ?>
            <tr>
              <td><?php echo $question['question']; ?></td>
              <td>
                <?php
//              pretty_print($question['answers'], 0); 
                //right_answer
                if (!empty($question['answers'])) {
                  foreach ($question['answers'] as $key => $val) {
                    if (!empty($val)) {
                      echo $key . '. ' . $val . ($key == $question['right_answer'] ? ' <i class="fa fa-check-circle"></i>' : '') . '</br>';
                    }
                  }
                }
                ?>
              </td>
              <td><?php echo $question['sub_code']; ?></td>
              <td><?php echo $question['module_no']; ?></td>
              <td>
                <a href="/syllabus/question/edit/<?php echo $question['id']; ?>">EDIT</a>
                | <a onclick="return confirm('Are You Sure')"  href="/syllabus/question/delete/<?php echo $question['id']; ?>">DELETE</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php } ?>
      </tbody>

    </table>
  </div>
</div>