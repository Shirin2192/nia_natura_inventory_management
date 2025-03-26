$(document).on("submit", "#userForm", function(e) {
    e.preventDefault();
    var formData = $(this).serialize(); // Serialize form data

    $.ajax({
        url: frontend + "admin/save_user", // API URL
        type: "POST",
        data: formData,
        dataType: "json",
        beforeSend: function() {
            $(".btn-primary").prop("disabled", true).text("Submitting...");
        },
        success: function(response) {
            if (response.success) {
                swal({
                    icon: "success",
                    title: "Added!",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });   
                $("#userForm")[0].reset(); // Reset form
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error submitting form:", error);
        },
        complete: function() {
            $(".btn-primary").prop("disabled", false).text("Submit");
        }
    });
});
