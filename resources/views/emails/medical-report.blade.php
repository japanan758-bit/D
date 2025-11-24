<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقرير الطبي</title>
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
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #007bff;
        }
        .report-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .patient-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .clinic-info {
            background-color: #e8f4fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #b8daff;
        }
        .medical-section {
            margin: 25px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .section-title {
            background-color: #495057;
            color: white;
            padding: 10px 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            min-width: 150px;
        }
        .info-value {
            color: #007bff;
            text-align: left;
            flex: 1;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .signature {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            border-top: 1px dashed #ccc;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .print-button {
            background-color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: right;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .medical-alert {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert-title {
            color: #856404;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #007bff; margin: 0; font-size: 28px;">التقرير الطبي</h1>
            <p style="margin: 10px 0 0 0; color: #6c757d;">نظام إدارة العيادة - إصدار {{ date('Y-m-d') }}</p>
        </div>

        <div class="report-header">
            <h2 style="margin: 0; font-size: 24px;">تقرير طبي شامل</h2>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">رقم التقرير: #{{ $reportNumber }}</p>
        </div>

        <div class="clinic-info">
            <h3 style="color: #007bff; margin-top: 0;">🏥 معلومات العيادة</h3>
            <div class="info-row">
                <span class="info-label">اسم العيادة:</span>
                <span class="info-value">{{ config('clinic.name', 'عيادة الشفاء الطبية') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">رقم الترخيص:</span>
                <span class="info-value">{{ config('clinic.license_number', 'M-12345') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">التخصص:</span>
                <span class="info-value">{{ config('clinic.specialty', 'طب عام وأمراض باطنية') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">العنوان:</span>
                <span class="info-value">{{ config('clinic.address', 'الرياض، المملكة العربية السعودية') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">الهاتف:</span>
                <span class="info-value">{{ config('clinic.phone', '+966-XX-XXX-XXXX') }}</span>
            </div>
        </div>

        <div class="patient-info">
            <h3 style="color: #007bff; margin-top: 0;">👤 بيانات المريض</h3>
            <div class="info-row">
                <span class="info-label">الاسم الكامل:</span>
                <span class="info-value">{{ $patient->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">رقم الهوية:</span>
                <span class="info-value">{{ $patient->id_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">الجنس:</span>
                <span class="info-value">{{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">تاريخ الميلاد:</span>
                <span class="info-value">{{ $patient->date_of_birth->format('Y-m-d') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">العمر:</span>
                <span class="info-value">{{ $patient->date_of_birth->age }} سنة</span>
            </div>
            <div class="info-row">
                <span class="info-label">الهاتف:</span>
                <span class="info-value">{{ $patient->phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">البريد الإلكتروني:</span>
                <span class="info-value">{{ $patient->email }}</span>
            </div>
        </div>

        <div class="medical-section">
            <div class="section-title">📋 معلومات الزيارة</div>
            <div class="info-row">
                <span class="info-label">تاريخ الزيارة:</span>
                <span class="info-value">{{ $appointment->appointment_date->format('Y-m-d') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">الوقت:</span>
                <span class="info-value">{{ $appointment->appointment_time }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">الطبيب المعالج:</span>
                <span class="info-value">{{ $doctor->name }} - {{ $doctor->specialization }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">نوع الخدمة:</span>
                <span class="info-value">{{ $appointment->service->name ?? 'كشف عام' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">حالة الموعد:</span>
                <span class="info-value">
                    @if($appointment->status == 'completed')
                        ✅ مكتمل
                    @elseif($appointment->status == 'confirmed')
                        ✅ مؤكد
                    @elseif($appointment->status == 'pending')
                        ⏳ في الانتظار
                    @else
                        ⚠️ {{ $appointment->status }}
                    @endif
                </span>
            </div>
        </div>

        @if(isset($vitalSigns) && count($vitalSigns) > 0)
        <div class="medical-section">
            <div class="section-title">🔬 العلامات الحيوية</div>
            <table>
                <thead>
                    <tr>
                        <th>القياس</th>
                        <th>القيمة</th>
                        <th>المستوى الطبيعي</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vitalSigns as $vital)
                    <tr>
                        <td>{{ $vital['name'] }}</td>
                        <td><strong>{{ $vital['value'] }}</strong></td>
                        <td>{{ $vital['normal_range'] }}</td>
                        <td>
                            @if($vital['status'] == 'normal')
                                ✅ طبيعي
                            @elseif($vital['status'] == 'high')
                                ⚠️ مرتفع
                            @elseif($vital['status'] == 'low')
                                ⚠️ منخفض
                            @else
                                🔴 غير طبيعي
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="medical-section">
            <div class="section-title">🏥 التشخيص والمعاينة</div>
            @if(isset($diagnosis) && $diagnosis)
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <h4 style="color: #495057; margin-top: 0;">التشخيص الرئيسي:</h4>
                <p style="font-size: 16px; line-height: 1.6;">{{ $diagnosis }}</p>
            </div>
            @endif

            @if(isset($symptoms) && count($symptoms) > 0)
            <div style="margin: 15px 0;">
                <h4 style="color: #495057;">الأعراض المرصودة:</h4>
                <ul style="line-height: 1.8;">
                    @foreach($symptoms as $symptom)
                    <li>{{ $symptom }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(isset($examination) && $examination)
            <div style="margin: 15px 0;">
                <h4 style="color: #495057;">نتائج الفحص السريري:</h4>
                <p style="line-height: 1.6;">{{ $examination }}</p>
            </div>
            @endif
        </div>

        @if(isset($prescriptions) && count($prescriptions) > 0)
        <div class="medical-section">
            <div class="section-title">💊 الوصفة الطبية</div>
            <table>
                <thead>
                    <tr>
                        <th>اسم الدواء</th>
                        <th>الجرعة</th>
                        <th>التكرار</th>
                        <th>مدة العلاج</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr>
                        <td><strong>{{ $prescription->medication_name }}</strong></td>
                        <td>{{ $prescription->dosage }}</td>
                        <td>{{ $prescription->frequency }}</td>
                        <td>{{ $prescription->duration }}</td>
                        <td>{{ $prescription->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if(isset($tests) && count($tests) > 0)
        <div class="medical-section">
            <div class="section-title">🧪 الفحوصات المطلوبة</div>
            <ul style="line-height: 1.8;">
                @foreach($tests as $test)
                <li>{{ $test }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(isset($instructions) && $instructions)
        <div class="medical-section">
            <div class="section-title">📝 التعليمات والملاحظات</div>
            <div style="background-color: #e8f5e8; padding: 15px; border-radius: 5px; border: 1px solid #d4edda;">
                <p style="line-height: 1.8; margin: 0;">{{ $instructions }}</p>
            </div>
        </div>
        @endif

        @if(isset($followUpDate) && $followUpDate)
        <div class="medical-alert">
            <div class="alert-title">⏰ موعد المتابعة</div>
            <p><strong>يُرجى مراجعة الطبيب في:</strong> {{ $followUpDate->format('Y-m-d') }}</p>
            <p>{{ $followUpInstructions ?? 'يرجى الحضور في الموعد المحدد للمتابعة' }}</p>
        </div>
        @endif

        <div class="signature">
            <p><strong>التوقيع والختم:</strong></p>
            <div style="display: inline-block; text-align: center; margin: 20px;">
                <p style="margin-bottom: 30px;">
                    _________________________<br>
                    {{ $doctor->name }}<br>
                    {{ $doctor->specialization }}<br>
                    رقم الترخيص: {{ $doctor->license_number ?? 'غير محدد' }}
                </p>
            </div>
            <p style="font-size: 12px; color: #6c757d;">
                تم إنشاء هذا التقرير إلكترونياً بتاريخ: {{ date('Y-m-d H:i:s') }}<br>
                رقم المرجع: #{{ $reportNumber }} | Patient ID: {{ $patient->id }}
            </p>
        </div>

        <div class="footer">
            <p><strong>إخلاء مسؤولية:</strong></p>
            <p style="font-size: 12px; line-height: 1.5;">
                هذا التقرير سري ومخصص للمريض المحدد أعلاه فقط. 
                لا يجوز استخدامه لأي غرض آخر دون موافقة صريحة من الطبيب المعالج والعيادة.
                يُرجى مراجعة الطبيب في حالة وجود أي استفسارات أو مخاوف.
            </p>
            
            <p style="margin-top: 20px;">
                📞 {{ config('clinic.phone', '+966-XX-XXX-XXXX') }} | 
                📧 {{ config('clinic.email', 'info@clinic.com') }} | 
                📍 {{ config('clinic.address', 'الرياض، المملكة العربية السعودية') }}
            </p>
            
            <p style="margin-top: 20px; font-weight: bold;">
                © {{ date('Y') }} {{ config('clinic.name', 'عيادة الشفاء الطبية') }}. جميع الحقوق محفوظة.
            </p>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/reports/print/' . $reportNumber) }}" class="button print-button">🖨️ طباعة التقرير</a>
            <a href="{{ url('/patient/dashboard') }}" class="button">📱 لوحة التحكم</a>
        </div>
    </div>
</body>
</html>