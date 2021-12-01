(function($) {
    Drupal.behaviors.myBehavior = {
        attach: function(context, settings) {

            $(".mcc_org_unit").change(function() {
                var val = $(".mcc_org_unit option:selected").text();
                if (val.trim() == "Central Unit") {
                    $(".mcc_org_level").html("<option value='Member'>Member</option><option value='Other'>Other</option>");
                } else {
                    $(".mcc_org_level").html("<option value='Member'>Member</option><option value='Associate Member'>Associate Member</option>");
                }
            });

            var val = $(".mcc_org_unit option:selected").text();
            var level = $(".mcc_org_level option:selected").text();
            if (val.trim() == "Central Unit") {
                $(".mcc_org_level").html("<option value='Member'>Member</option><option value='Other'>Other</option>");
                $(".mcc_org_level option[value='"+level+"']").attr('selected','selected');
            } else {
                $(".mcc_org_level").html("<option value='Member'>Member</option><option value='Associate Member'>Associate Member</option>");
                $(".mcc_org_level option[value='"+level+"']").attr('selected','selected');
            }
        }
    };

})(jQuery);