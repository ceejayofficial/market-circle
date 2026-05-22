document.getElementById("postForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    Swal.fire({
        title: "Posting item...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        let res = await fetch("./services/post-item-handler.php", {
            method: "POST",
            body: formData
        });

        let data = await res.json();

        if (data.status === "success") {

            Swal.fire({
                icon: "success",
                title: "Success",
                text: data.message,
                confirmButtonColor: "#facc15"
            }).then(() => {
                window.location.href = "my-items.php";
            });

        } else {

            Swal.fire({
                icon: "error",
                title: "Failed",
                text: data.message
            });

        }

    } catch (err) {

        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Server error occurred"
        });

    }
});