function paymentValue() {
    var select = document.getElementById("payment-select").value;
    var displayValue = document.getElementById("payment-name");
    displayValue.innerHTML = paymentList[select];
}
function changeAddress() {
    var select = document.getElementById("payment-select").value;
    var target = document.getElementById("purchase-address");
    target.href = "/purchase/address/" + itemId + "?payment=" + select;
    return false;
}
function changeNoAddress() {
    var select = document.getElementById("payment-select").value;
    var target = document.getElementById("purchase-address");
    target.href = "/purchase/address/" + itemId + "?payment=" + select;
    return false;
}
