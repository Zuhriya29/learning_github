document.addEventListener("DOMContentLoaded", function() {
    const warning = document.querySelector(".warning");
    if (warning) {
        warning.style.display = "block";
        setTimeout(() => {
            warning.style.display = "none";
        }, 5000); // 3 detik
    }
});