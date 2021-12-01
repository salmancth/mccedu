(function($) {
    Drupal.behaviors.subUnit = {
        attach: function(context, settings) {
            console.log('sub unit js');
            //this calculates values automatically 
            calculateTotalMember();
            $("#edit-member-increase").on("keydown keyup", function() {
                calculateTotalMember();
            });
            $("#edit-member-decrease").on("keydown keyup", function() {
                calculateTotalMember();
            });

            calculateTotalMemberApplicant();
            $("#edit-member-applicant-increase").on("keydown keyup", function() {
                calculateTotalMemberApplicant();
            });
            $("#edit-member-applicant-decrease").on("keydown keyup", function() {
                calculateTotalMemberApplicant();
            });

            calculateTotalAssociateMember();
            $("#edit-associate-member-increase").on("keydown keyup", function() {
                calculateTotalAssociateMember();
            });
            $("#edit-associate-member-decrease").on("keydown keyup", function() {
                calculateTotalAssociateMember();
            });

            calculateTotalManpower();
            $("#edit-manpower-increase").on("keydown keyup", function() {
                calculateTotalManpower();
            });
            $("#edit-manpower-decrease").on("keydown keyup", function() {
                calculateTotalManpower();
            });

            calculateTotalPrimaryMember();
            $("#edit-primary-member-increase").on("keydown keyup", function() {
                calculateTotalPrimaryMember();
            });
            $("#edit-primary-member-decrease").on("keydown keyup", function() {
                calculateTotalPrimaryMember();
            });

            calculateTotalWellwisher();
            $("#edit-wellwisher-increase").on("keydown keyup", function() {
                calculateTotalWellwisher();
            });
            $("#edit-wellwisher-decrease").on("keydown keyup", function() {
                calculateTotalWellwisher();
            });

            function calculateTotalMember() {
                var memberTotal = 0;
                var pastMember = 0;
                var increaseMember = 0;
                var decreaseMember = 0;
                if (!isNaN($('#pastMember').html()) && $('#pastMember').html().length != 0)
                    pastMember = parseInt($('#pastMember').html());
                if (!isNaN($('#edit-member-increase').val()) && $('#edit-member-increase').val().length != 0)
                    increaseMember = parseInt($('#edit-member-increase').val());
                if (!isNaN($('#edit-member-decrease').val()) && $('#edit-member-decrease').val().length != 0)
                    decreaseMember = parseInt($('#edit-member-decrease').val());
                memberTotal = pastMember + increaseMember - decreaseMember;

                $("input#edit-member-total").val(memberTotal.toFixed(0));
            }
            function calculateTotalMemberApplicant() {
                var memberApplicantTotal = 0;
                var pastMemberApplicant = 0;
                var increaseMemberApplicant = 0;
                var decreaseMemberApplicant = 0;
                if (!isNaN($('#pastMemberApplicant').html()) && $('#pastMemberApplicant').html().length != 0)
                    pastMemberApplicant = parseInt($('#pastMemberApplicant').html());
                if (!isNaN($('#edit-member-applicant-increase').val()) && $('#edit-member-applicant-increase').val().length != 0)
                    increaseMemberApplicant = parseInt($('#edit-member-applicant-increase').val());
                if (!isNaN($('#edit-member-applicant-decrease').val()) && $('#edit-member-applicant-decrease').val().length != 0)
                    decreaseMemberApplicant = parseInt($('#edit-member-applicant-decrease').val());
                memberApplicantTotal = pastMemberApplicant + increaseMemberApplicant - decreaseMemberApplicant;

                $("input#edit-member-applicant-total").val(memberApplicantTotal.toFixed(0));
            }
            function calculateTotalAssociateMember() {
                var memberAssociateTotal = 0;
                var pastAssociateMember = 0;
                var increaseAssociateMember = 0;
                var decreaseAssociateMember = 0;
                if (!isNaN($('#pastMember').html()) && $('#pastMember').html().length != 0)
                    pastAssociateMember = parseInt($('#pastAssociateMember').html());
                if (!isNaN($('#edit-associate-member-increase').val()) && $('#edit-associate-member-increase').val().length != 0)
                    increaseAssociateMember = parseInt($('#edit-associate-member-increase').val());
                if (!isNaN($('#edit-associate-member-decrease').val()) && $('#edit-associate-member-decrease').val().length != 0)
                    decreaseAssociateMember = parseInt($('#edit-associate-member-decrease').val());
                associateMemberTotal = pastAssociateMember + increaseAssociateMember - decreaseAssociateMember;

                $("input#edit-associate-member-total").val(associateMemberTotal.toFixed(0));
            }
            function calculateTotalManpower() {
                var manpowerTotal = 0;
                var pastManpower = 0;
                var increaseManpower = 0;
                var decreaseManpower = 0;
                if (!isNaN($('#pastManpower').html()) && $('#pastManpower').html().length != 0)
                    pastManpower = parseInt($('#pastManpower').html());
                if (!isNaN($('#edit-manpower-increase').val()) && $('#edit-manpower-increase').val().length != 0)
                    increaseManpower = parseInt($('#edit-manpower-increase').val());
                if (!isNaN($('#edit-manpower-decrease').val()) && $('#edit-manpower-decrease').val().length != 0)
                    decreaseManpower = parseInt($('#edit-manpower-decrease').val());
                manpowerTotal = pastManpower + increaseManpower - decreaseManpower;

                $("input#edit-manpower-total").val(manpowerTotal.toFixed(0));
            }
            function calculateTotalPrimaryMember() {
                var primaryMemberTotal = 0;
                var pastPrimaryMember = 0;
                var increasePrimaryMember = 0;
                var decreasePrimaryMember = 0;
                if (!isNaN($('#pastPrimaryMember').html()) && $('#pastPrimaryMember').html().length != 0)
                    pastPrimaryMember = parseInt($('#pastPrimaryMember').html());
                if (!isNaN($('#edit-primary-member-increase').val()) && $('#edit-primary-member-increase').val().length != 0)
                    increasePrimaryMember = parseInt($('#edit-primary-member-increase').val());
                if (!isNaN($('#edit-primary-member-decrease').val()) && $('#edit-primary-member-decrease').val().length != 0)
                    decreasePrimaryMember = parseInt($('#edit-primary-member-decrease').val());
                primaryMemberTotal = pastPrimaryMember + increasePrimaryMember - decreasePrimaryMember;

                $("input#edit-primary-member-total").val(primaryMemberTotal.toFixed(0));
            }
            function calculateTotalWellwisher() {
                var wellwisherTotal = 0;
                var pastWellwisher = 0;
                var increaseWellwisher = 0;
                var decreaseWellwisher = 0;
                if (!isNaN($('#pastWellwisher').html()) && $('#pastWellwisher').html().length != 0)
                    pastWellwisher = parseInt($('#pastWellwisher').html());
                if (!isNaN($('#edit-wellwisher-increase').val()) && $('#edit-wellwisher-increase').val().length != 0)
                    increaseWellwisher = parseInt($('#edit-wellwisher-increase').val());
                if (!isNaN($('#edit-wellwisher-decrease').val()) && $('#edit-wellwisher-decrease').val().length != 0)
                    decreaseWellwisher = parseInt($('#edit-wellwisher-decrease').val());
                wellwisherTotal = pastWellwisher + increaseWellwisher - decreaseWellwisher;

                $("input#edit-wellwisher-total").val(wellwisherTotal.toFixed(0));
            }


            calculateIncome();
            $(".mcc-income").on("keydown keyup", function() {
                calculateIncome();
            });
            function calculateIncome() {
                var mccIncome = 0;
                //iterate through each textboxes and add the values
                $(".mcc-income").each(function() {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        mccIncome += parseFloat(this.value);
                    }
                });
                $(".total_income").html(mccIncome.toFixed(2));
                
                $("#edit-surplus-deficit").val((mccIncome.toFixed(2) - parseFloat($('.total_expense').html())).toFixed(2));
            }

            calculateExpense();
            $(".mcc-expense").on("keydown keyup", function() {
                calculateExpense();
            });
            function calculateExpense() {
                var mccExpense = 0;
                //iterate through each textboxes and add the values
                $(".mcc-expense").each(function() {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        mccExpense += parseFloat(this.value);
                    }
                });
                $(".total_expense").html(mccExpense.toFixed(2));
                
                $("#edit-surplus-deficit").val((parseFloat($(".total_income").html()) - mccExpense.toFixed(2)).toFixed(2));
            }
        }
    };

})(jQuery);