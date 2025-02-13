// Function to initiate M-Pesa STK Push
function initiatePayment(amount) {
    let phone = prompt("Enter your M-Pesa phone number (format: 2547XXXXXXXX):");

    if (!phone || !/^2547\d{8}$/.test(phone)) {
        alert("Invalid phone number. Please enter in format 2547XXXXXXXX.");
        return;
    }

    let formData = new FormData();
    formData.append("phone", phone);
    formData.append("amount", amount);

    fetch("../backend/stk-push.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.ResponseCode === "0") {
            alert("STK Push sent. Check your phone to complete the payment.");
            checkTransactionStatus(data.CheckoutRequestID); // Check transaction status
        } else {
            alert("Payment request failed. Try again.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error processing payment.");
    });
}

// Function to check transaction status
function checkTransactionStatus(CheckoutRequestID) {
    let formData = new FormData();
    formData.append("CheckoutRequestID", CheckoutRequestID);

    setTimeout(() => {
        fetch("../backend/transaction-status.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.ResultCode === "0") {
                alert("Payment successful! Subscription activated.");
            } else {
                alert("Payment failed or was not completed.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Error checking payment status.");
        });
    }, 5000); // Check status after 5 seconds
}
