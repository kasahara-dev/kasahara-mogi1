function paymentValue() {
    var select = document.getElementById("payment-select").value;
    var displayValue = document.getElementById("payment-name");
    displayValue.innerHTML = paymentList[select];
}
