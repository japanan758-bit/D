<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إلغاء الموعد</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; direction: rtl; text-align: right; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; color: #2c3e50; }
        .status-cancelled { background: #dc3545; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; display: inline-block; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>عيادة دكتور عبدالناصر الأخرص</h1>
            <h2>إلغاء الموعد</h2>
        </div>

        <p>عزيزي {{ $appointment->patient_name }}،</p>
        
        <p>نعتذر عن إلغاء موعدك التالي في عيادة دكتور عبدالناصر الأخرص</p>

        <p><strong>تاريخ الموعد الملغي:</strong> {{ $appointment->appointment_date->format('d/m/Y') }} - {{ $appointment->appointment_time->format('h:i A') }}</p>
        
        @if($appointment->notes)
        <p><strong>السبب:</strong> {{ $appointment->notes }}</p>
        @endif

        <p>يمكنكم حجز موعد جديد من خلال موقعنا الإلكتروني</p>

        <div class="footer">
            <p>نتطلع لخدمتكم قريباً</p>
            <p>© 2025 عيادة دكتور عبدالناصر الأخرص</p>
        </div>
    </div>
</body>
</html>