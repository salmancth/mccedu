<div class="white-box">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title">
                <a href="javascript:void(0);" class="btn btn-primary send-mass-email">
                    <i class="fa fa-envelope-o fa-lg"></i> Send Email to Selected User
                </a>
            </h3>
        </div>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.js"></script>
    <div class="row user-email-box">
        <div class="col-md-12">
            <div class="panel panel-project-info">
                <div class="panel-body">
                    <form id="manpower-mail" method="post">
                        <span class="mail-sending"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Wait while we are sending email.</span>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input value="" type="email" class="form-control" id="email-to-send" aria-describedby="emailHelp" placeholder="Enter email address">
                            <small id="emailHelp" class="form-text text-muted">comma separated email addresses to send email to more than one recipient.</small>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input value="" type="text" class="form-control" id="subject-to-send" aria-describedby="subjetcHelp" placeholder="Mail Subject">
                            <small id="subjetcHelp" class="form-text text-muted">Email Subject</small>
                        </div>
                        <div class="form-group">
                            <label for="textarea">Your Message</label>
                <!--              <textarea class="form-control" id="custom-message" rows="3"></textarea>-->
                            <div id="custom-message"></div>
                            <script>
                                jQuery('#custom-message').summernote({
                                    toolbar: [
                                        // [groupName, [list of button]]
                                        ['style', ['bold', 'italic', 'underline', 'clear']],
                                        ['font', ['strikethrough', 'superscript', 'subscript']],
                                        ['fontsize', ['fontsize']],
                                        ['color', ['color']],
                                        ['para', ['ul', 'ol', 'paragraph']],
                                        ['height', ['height']],
                                        ['link', ['linkDialogShow', 'unlink']]
                                    ],
                                    height: 300, // set editor height
                                    minHeight: null, // set minimum height of editor
                                    maxHeight: null, // set maximum height of editor
                                    focus: true                  // set focus to editable area after initializing summernote
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Attach File</label>
                            <?php print drupal_render($attachment_form['attachment']); ?>
                            <?php print drupal_render_children($attachment_form); ?>
                        </div>
                        <input type="hidden" name="mail-content" id="mail-content" value="">
                        <input type="button" value="Send Email Now" class="btn btn-default bg-custom form-submit pull-right" onclick="mailUser();">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="white-box">
    <?php if (!empty($registered_users_array)) { ?>
        <?php foreach ($registered_users_array as $key => $val) { ?>
            <h1><?php echo ucfirst($key); ?></h1>            
            <?php foreach ($val as $sub_code => $usrs) { ?>        
                <h2><?php echo $sub_code; ?></h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" id="" style="table-layout: fixed">
                        <thead>
                            <tr class="tablehead">
                                <!--<th class="">Course</th>-->
                                <th class="">Name</th>
                                <th class="">Email</th>
                                <th class=""></th>
                            </tr>        
                        </thead>
                        <tbody>
                            <?php // pretty_print($usr, 0); ?>
                            <?php foreach ($usrs as $usr) { ?>
                                <tr>
                                    <!--<td><?php // echo $sub_code;       ?></td>-->
                                    <td><?php echo $usr['name']; ?></td>
                                    <td><?php echo $usr['mail']; ?></td>
                                    <td>
                                        <?php
                                        echo "<input class='user-email-checkbox' type='checkbox' name='mail_arr[]' value='{$usr['mail']}' />"
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>        
        <?php } ?>    
        <?php
    } else {
        echo 'Nothing Found';
    }
    ?>
</div>

<script type = "text/javascript" >
    jQuery(document).ready(function($) {
        $(document).on('change', 'input.user-email-checkbox,input#checkAll', function() {
            if ($('input.user-email-checkbox:checked').length > 0) {
                $('a.send-mass-email').show();
            } else {
                $('a.send-mass-email').hide();
                $('.user-email-box').hide();
                $("input#email-to-send").val('');
                $("textarea#custom-message").val('');
            }
        });
        $(document).on('click', 'a.send-mass-email', function() {
            $('.user-email-box').fadeToggle('slow');
            var emails_input = null;
            $('input.user-email-checkbox:checked').each(function() {
                //console.log(this.value);
                emails_input = $("#email-to-send").val();
                if (emails_input) {
                    if (this.value) {
                        emails_input += ', ' + this.value;
                    }
                } else {
                    emails_input = this.value;
                }
                $("#email-to-send").val(emails_input);
            });
        });
    })

    function mailUser(el) {
        var mailTo = jQuery("#email-to-send").val();
        var mailMessage = jQuery('#custom-message').summernote('code');//jQuery("#custom-message").html();
        var mailSubject = jQuery("#subject-to-send").val();
        var mailAttachment = jQuery("input[name='attachment[fid]']").val();
        jQuery("#email-to-send").val('');
        //jQuery("#custom-message").val('');
        //jQuery("#custom-message").summernote('destroy');
        jQuery("#custom-message").summernote('code', '');
        jQuery("#subject-to-send").val('');
        if (mailTo) {
            jQuery('input[type="button"]').prop('disabled', true);
            jQuery('.mail-sending').css('display', 'block');
            var dataString = 'mail-to-address=' + encodeURIComponent(mailTo) + '&custom-message=' + encodeURIComponent(mailMessage)
                    + '&mail-subject=' + encodeURIComponent(mailSubject) + '&mail-attachment=' + encodeURIComponent(mailAttachment);
            jQuery.ajax({
                type: "POST",
                url: "/mcc-user-mail-send",
                data: dataString,
                cache: false,
                success: function(result) {
                    jQuery('input[type="button"]').prop('disabled', false);
                    jQuery('.mail-sending').css('display', 'none');
                    alert(result.value);
                }
            });
        }
    }
</script>