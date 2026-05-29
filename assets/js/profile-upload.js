document.getElementById("profileUpload")?.addEventListener("change", async function () {

    const file = this.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append("image", file);

    const res = await fetch("../services/upload-profile.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.status === "success") {

        Swal.fire({
            icon: "success",
            title: "Updated",
            text: "Profile image updated successfully",
            confirmButtonColor: "#eab308"
        }).then(() => location.reload());

    } else {

        Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message
        });

    }
});
