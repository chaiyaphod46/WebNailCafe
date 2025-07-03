<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Checkout API</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.stripe.com/v3/"></script> <!-- Add this line -->
</head>

<body>
    <script>
    async function sendCheckoutRequest() {
        try {
        const urlParams = new URLSearchParams(window.location.search);
        const reservs_id = urlParams.get('reservs_id'); // ดึงค่า reservs_id จาก URL

        const response = await fetch("{{ url('/checkout') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                "reservs_id": reservs_id,
                "user": {
                    "name": "John Doe",
                    "address": "Bangkok, Thailand"
                },
                "product": {
                    "name": "ชำระเงินมัดจำ",
                    "price": 300,
                    "quantity": 1
                }
            })
        });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            console.log("API Response:", data);

            if (data.id) {
                const stripe = Stripe('pk_test_51QewTHFDBjC3foqcAEz7pSrtTaP4lHr3ly4FU4vLdLT7hLSNIA66QM6efOfkifYIKJbt2N2dRQGgYpby1t1CWzpY0058blMt5F');
                const result = await stripe.redirectToCheckout({
                    sessionId: data.id
                });

                if (result.error) {
                    alert("เกิดข้อผิดพลาดในการ redirect ไปยัง Checkout");
                }
            } else {
                alert("เกิดข้อผิดพลาด: ไม่สามารถสร้าง session");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("เกิดข้อผิดพลาดในการ Checkout");
        }
    }

    window.onload = sendCheckoutRequest;
</script>


</body>

</html>
