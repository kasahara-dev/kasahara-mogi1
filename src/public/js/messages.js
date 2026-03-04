const newMessage = document.getElementById("new_message_text");
const sendBtn = document.getElementById("send_btn");

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("messagesArea");
    container.scrollTop = container.scrollHeight;
});

newMessage.addEventListener('input', () => {
    sessionStorage.setItem('message' + purchaseId, newMessage.value);
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
