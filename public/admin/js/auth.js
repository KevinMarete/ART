
//function password check_match
function checkPasswordMatch() {
    var password = $("#user_password").val();
    var confirmPassword = $("#confirm_password").val();

    if (password != confirmPassword)
    {
        $(".msg").html("Passwords do not match!").css('color', 'red');
        $('#submit_button').prop('disabled', true);
    } else {
        $(".msg").html("Passwords match.").css('color', 'green');
        $('#submit_button').prop('disabled', false);
    }

}

//flash delay
$(function () {
    $('.alert').delay(500).fadeIn(1500,
            function () {
                $(this).delay(500).fadeOut(1500);
            });
});
