function showOtpModal() {

    Swal.fire({
        title: "Enter OTP",
        input: "text",
        inputLabel: "We sent a code to your email",
        showCancelButton: true,
        confirmButtonText: "Verify"
    }).then((result) => {

        if (!result.isConfirmed) return;

        fetch("./services/verify-otp.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "otp=" + result.value
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === "success") {
                Swal.fire("Success", data.message, "success")
                .then(() => window.location.href = "login.php");
            } else {
                Swal.fire("Error", data.message, "error");
            }

        });

    });

}