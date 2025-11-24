<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تذكير بالمتابعة الطبية</title>
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
            border-bottom: 2px solid #28a745;
        }
        .followup-details {
            background-color: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #ffeaa7;
        }
        .medical-info {
            background-color: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #d4edda;
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
            color: #28a745;
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
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
        }
        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #28a745; margin: 0;">🏥 نظام إدارة العيادة</h1>
            <h2 style="color: #fd7e14; margin: 10px 0 0 0;">تذكير بالمتابعة الطبية</h2>
        </div>

        <p>عزيزي/عزيزتي {{ $patient->name }}،</p>
        
        <p>بناءً على آخر زيارة لكم في العيادة، نذكركم بأهمية المتابعة الطبية في الموعد المحدد أدناه:</p>

        <div class="followup-details">
            <h3 style="color: #fd7e14; margin-top: 0;">📅 تفاصيل موعد المتابعة</h3>
            <div class="detail-row">
                <span class="detail-label">الاسم:</span>
                <span class="detail-value">{{ $patient->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">الطبيب المعالج:</span>
                <span class="detail-value">{{ $doctor->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">التخصص:</span>
                <span class="detail-value">{{ $doctor->specialization }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">تاريخ الموعد:</span>
                <span class="detail-value">{{ $followupDate->format('Y-m-d') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">الوقت:</span>
                <span class="detail-value">{{ $appointmentTime }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">رقم المرجع:</span>
                <span class="detail-value">#{{ $referenceNumber }}</span>
            </div>
        </div>

        @if(isset($medicalNotes) && $medicalNotes)
        <div class="medical-info">
            <h3 style="color: #28a745; margin-top: 0;">📋 ملاحظات طبية من الزيارة السابقة</h3>
            <p>{{ $medicalNotes }}</p>
        </div>
        @endif

        @if(isset($prescriptions) && $prescriptions->count() > 0)
        <div class="medical-info">
            <h3 style="color: #28a745; margin-top: 0;">💊 الأدوية الموصوفة</h3>
            <ul>
                @foreach($prescriptions as $prescription)
                    <li>{{ $prescription->medication_name }} - {{ $prescription->dosage }} ({{ $prescription->frequency }})</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="warning-box">
            <h4 style="color: #856404; margin-top: 0;">⚠️ إرشادات مهمة:</h4>
            <ul>
                <li>يرجى إحضار جميع الأدوية الحالية</li>
                <li>إحضار نتائج الفحوصات المخبرية إن وجدت</li>
                <li>في حالة وجود أي أعراض جديدة، يرجى إخبار الطبيب</li>
                <li>اتباع التعليمات الطبية الموصى بها</li>
            </ul>
        </div>

        <p><strong>ملاحظة:</strong> الالتزام بمواعيد المتابعة ضروري لضمان صحة أفضل وفعالية العلاج.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/appointments/schedule-followup/' . $patient->id) }}" class="button">
                تأكيد الموعد
            </a>
            <a href="{{ url('/appointments/reschedule') }}" class="button" style="background-color: #6c757d;">
                إعادة جدولة الموعد
            </a>
        </div>

        <div class="footer">
            <p><strong>بيانات التواصل:</strong></p>
            <p>📞 الهاتف: {{ config('clinic.phone', '+966-XX-XXX-XXXX') }}</p>
            <p>📧 البريد الإلكتروني: {{ config('clinic.email', 'info@clinic.com') }}</p>
            <p>📍 العنوان: {{ config('clinic.address', 'الرياض، المملكة العربية السعودية') }}</p>
            <p>🌐 الموقع الإلكتروني: {{ config('clinic.website', 'www.clinic.com') }}</p>
            
            <p style="margin-top: 20px;">
                © {{ date('Y') }} نظام إدارة العيادة. جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</body>
</html>