const newMessage = document.getElementById("new_message_text");

document.addEventListener("DOMContentLoaded", function () {
    var container = document.getElementById("messagesArea");
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