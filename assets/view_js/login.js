$(document).ready(function(){
    $("#loginForm").submit(function(event){
        event.preventDefault(); // Prevent default form submission

        // Debug: Check if `frontend` is defined
        //console.log("Frontend URL:", frontend); 

        $.ajax({
            url: frontend + "common/login_process", // Use `frontend` correctly
            // url: "<?php echo base_url('common/login_process'); ?>", // Corrected URL
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                $(".text-danger").html(""); // Clear all error messages
                $("#login_error").addClass("d-none"); // Hide general error

                if (response.status == "error") {
                    if (response.email_error) {
                        $("#email_error").html(response.email_error);
                    }
                    if (response.password_error) {
                        $("#password_error").html(response.password_error);
                    }
                    if (response.login_error) {
                        $("#login_error").removeClass("d-none").html(response.login_error);
                    }
                } else if (response.status == "success") {
                    window.location.href = response.redirect; // Redirect to dashboard
                }
            }
        });
    });
});
