const fileSelect = document.getElementById("fileSelect");
const fileElem = document.getElementById("fileElem");

fileSelect.addEventListener(
    "click",
    (e) => {
        if (fileElem) {
            fileElem.click();
        }
    },
    false
);

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("fileElem");
    const preview = document.getElementById("user-img");

    input.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
});
