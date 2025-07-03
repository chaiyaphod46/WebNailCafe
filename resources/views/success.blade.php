<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>

<body>
    <h1>จ่ายเงินสำเร็จ</h1>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>

    <script>
        window.onload = async () => {
            // ดึง orderId จาก URL
            // const urlParams = new URLSearchParams(window.location.search);
            // const orderId = urlParams.get('id');

            // ดึง URL จาก location
            const url = window.location.pathname;

            // ใช้ split แยก string โดยใช้ '/' เป็นตัวแบ่ง
            const segments = url.split('/');

            // หาค่าหมายเลข UUID ที่อยู่ในตำแหน่งที่ 2 (หลังจาก 'success')
            const orderId = segments[2];

            // เก็บค่าในตัวแปร
            console.log(orderId);


            // ตรวจสอบว่ามี orderId หรือไม่
            if (!orderId) {
                alert('Order ID not found in URL');
                window.location.href = 'http://127.0.0.1:8000/cancel';
                return;
            }

            try {
                // ดึงข้อมูลคำสั่งซื้อจาก API
                const response = await axios.get(`http://127.0.0.1:8000/order/${orderId}`);
                const orderData = response.data;
                await axios.get(`http://127.0.0.1:8000/updateorder/${orderData.order_id}`)
                alert(orderData.fullname+"ชำระเงินเสร็จสิ้น");

                // // ตรวจสอบสถานะคำสั่งซื้อ
                // if (orderData.status !== 'complete') {
                //     //   window.location.href = 'http://localhost:8000/cancel';
                //     document.getElementById('name').innerText = orderData.fullname || 'ไม่มีข้อมูล';
                //     document.getElementById('address').innerText = orderData.address || 'ไม่มีข้อมูล';
                // } else {
                //     // อัปเดตข้อมูลในหน้า HTML
                //     document.getElementById('name').innerText = orderData.fullname || 'ไม่มีข้อมูล';
                //     document.getElementById('address').innerText = orderData.address || 'ไม่มีข้อมูล';
                // }
            } catch (error) {
                // หากเกิดข้อผิดพลาด
                console.error('Error fetching order data:', error);
                window.location.href = 'http://127.0.0.1:8000/cancel';
            }
        };
    </script>
</body>

</html>
