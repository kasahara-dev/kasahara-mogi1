const newMessage = document.getElementById("new_message_text");
const sendBtn = document.getElementById("send_btn");
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("messagesArea");
    container.scrollTop = container.scrollHeight;
});

newMessage.addEventListener("input", () => {
    sessionStorage.setItem("message" + purchaseId, newMessage.value);
});
document.addEventListener("DOMContentLoaded", () => {
    const savedValue = sessionStorage.getItem("message" + purchaseId);
    if (savedValue) {
        newMessage.value = savedValue;
    }
});
sendBtn.addEventListener("click", () => {
    sessionStorage.removeItem("message" + purchaseId);
});

const radios = document.querySelectorAll('input[name="rate"]');
const labels = document.querySelectorAll('input[name="rate"]');
radios.forEach((radio) => {
    radio.addEventListener("change", (e) => {
        labels.forEach((label) => {
            if (label.value <= e.target.value) {
                document
                    .getElementById("label" + label.value)
                    .classList.replace(
                        "rate-select--star__inactive",
                        "rate-select--star__active",
                    );
            } else {
                document
                    .getElementById("label" + label.value)
                    .classList.replace(
                        "rate-select--star__active",
                        "rate-select--star__inactive",
                    );

            }
        });
    });
});
