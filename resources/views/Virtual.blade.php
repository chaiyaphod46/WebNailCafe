<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทดลองผ่าย Virtual Try-on</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: #fff;
            padding: 0.5em;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        section {
            padding: 20px;
            text-align: center;
        }

        .camera-access {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
            margin-top: 20px;
        }

        .image-gallery img {
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
        }

        .like-button {
            background-color: #3498db;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <h1>ทดลองผ่าย Virtual Try-on</h1>
    </header>

    <nav>
        <a href="#">หน้าหลัก</a>
        <a href="#">การจอง</a>
        <a href="#">วันเวลาว่าง</a>
        <a href="#">เข้าสู่ระบบ/ลงทะเบียน</a>
    </nav>

    <section>
        <div class="camera-access">
            <h1>เข้าถึงกล้องโน๊ตบุค</h1>
            <video id="camera-preview" autoplay=""></video>
            <button id="start-camera">เปิดกล้อง</button>
            <button id="stop-camera">ปิดกล้อง</button>

            <script>
                const cameraPreview = document.getElementById('camera-preview');
                const startCameraButton = document.getElementById('start-camera');
                const stopCameraButton = document.getElementById('stop-camera');

                // เมื่อคลิกที่ปุ่ม "เปิดกล้อง"
                startCameraButton.addEventListener('click', async () => {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                        cameraPreview.srcObject = stream;
                    } catch (error) {
                        console.error('เกิดข้อผิดพลาดในการเข้าถึงกล้อง:', error);
                    }
                });

                // เมื่อคลิกที่ปุ่ม "ปิดกล้อง"
                stopCameraButton.addEventListener('click', () => {
                    const stream = cameraPreview.srcObject;
                    const tracks = stream.getTracks();

                    tracks.forEach(track => {
                        track.stop();
                    });

                    cameraPreview.srcObject = null;
                });
            </script>
        </div>

        <div class="image-gallery">
            <!-- เพิ่มตารางรูปภาพที่นี่ -->
            <img src="image1.jpg" alt="รูปที่ 1" class="like-button">
            <img src="image2.jpg" alt="รูปที่ 2" class="like-button">
            <img src="image3.jpg" alt="รูปที่ 3" class="like-button">
            <!-- เพิ่มรูปภาพเพิ่มเติมตามต้องการ -->
        </div>
    </section>


</body></html>
