<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تذكير بموعد العيادة</title>
    <style>
        body {
            font-family: 'Arial', 'Tahoma', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }
        .appointment-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
        }
        .detail-label {
            font-weight: bold;
            color: #495057;
        }
        .detail-value {
            color: #007bff;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #007bff; margin: 0;">🏥 نظام إدارة العيادة</h1>
            <h2 style="color: #28a745; margin: 10px 0 0 0;">تذكير بموعدك القادم</h2>
        </div>

        <p>عزيزي/عزيزتي {{ $appointment->patient->name }}،</p>
        
        <p>نذكركم بأن لديكم موعداً مع العيادة في الموعد المحدد أدناه:</p>

        <div class="appointment-details">
            <h3 style="color: #007bff; margin-top: 0;">تفاصيل الموعد</h3>
            <div class="detail-row">
                <span class="detail-label">الاسم:</span>
                <span class="detail-value">{{ $appointment->patient->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">الطبيب:</span>
                <span class="detail-value">{{ $appointment->doctor->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">التخصص:</span>
                <span class="detail-value">{{ $appointment->doctor->specialization }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">تاريخ الموعد:</span>
                <span class="detail-value">{{ $appointment->appointment_date->format('Y-m-d') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">الوقت:</span>
                <span class="detail-value">{{ $appointment->appointment_time }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">نوع الخدمة:</span>
                <span class="detail-value">{{ $appointment->service->name ?? 'كشف عام' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">رقم الموعد:</span>
                <span class="detail-value">#{{ $appointment->id }}</span>
            </div>
        </div>

        <p><strong>إرشادات مهمة قبل الموعد:</strong></p>
        <ul>
            <li>يرجى الوصول قبل الموعد بـ 15 دقيقة</li>
            <li>إحضار الهوية الشخصية</li>
            <li>إحضار أي فحوصات أو تقارير طبية سابقة</li>
            <li>في حالة الحاجة للإلغاء، يرجى الاتصال بالعيادة قبل 24 ساعة</li>
        </ul>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/appointments/confirm/' . $appointment->id) }}" class="button">
                تأكيد الموعد
            </a>
        </div>

        <div class="footer">
            <p><strong>بيانات التواصل:</strong></p>
            <p>📞 الهاتف: {{ config('clinic.phone', '+966-XX-XXX-XXXX') }}</p>
            <p>📧 البريد الإلكتروني: {{ config('clinic.email', 'info@clinic.com') }}</p>
            <p>📍 العنوان: {{ config('clinic.address', 'الرياض، المملكة العربية السعودية') }}</p>
            
            <p style="margin-top: 20px;">
                © {{ date('Y') }} نظام إدارة العيادة. جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</body>
</html>