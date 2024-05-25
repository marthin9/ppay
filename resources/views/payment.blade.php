<!DOCTYPE html>
<html>
<head>
    <title>PromptPay Payment</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <form id="payment-form" method="POST">
        @csrf
        <label for="amount">Amount (THB):</label>
        <input type="number" name="amount" id="amount" required>
        <button type="submit">Pay with PromptPay</button>
    </form>

    <div id="qr-code" style="display: none;">
        <h3>Scan this QR Code to Pay</h3>
        <img id="qr-code-img" src="" alt="QR Code">
    </div>

    <script>
        document.getElementById('payment-form').addEventListener('submit', function (e) {
            e.preventDefault();

            let amount = document.getElementById('amount').value;

            axios.post('{{ route('createSource') }}', {
                amount: amount
            })
            .then(function (response) {
                console.log(response.data);
                if (response.data.object === 'source' && response.data.type === 'promptpay') {
                    let qrCodeUrl = response.data.scannable_code.image.download_uri;
                    document.getElementById('qr-code-img').src = qrCodeUrl;
                    document.getElementById('qr-code').style.display = 'block';
                }
            })
            .catch(function (error) {
                console.error(error.response.data);
                alert('Failed to generate QR code.');
            });
        });
    </script>
</body>
</html>
