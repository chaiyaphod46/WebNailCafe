document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        // ตั้งค่า FullCalendar ตามต้องการ
        plugins: ['interaction', 'dayGrid', 'timeGrid'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        select: function (info) {
            // โปรแกรมทำงานเมื่อผู้ใช้เลือกช่วงเวลาบน FullCalendar
            // สามารถเรียกใช้ Modal หรือแสดงฟอร์มสำหรับการจองเวลาได้ที่นี่
        },
        events: '/reserv', // ตัวอย่าง URL สำหรับโหลดข้อมูลการจองจากฐานข้อมูล
    });

    calendar.render();
});