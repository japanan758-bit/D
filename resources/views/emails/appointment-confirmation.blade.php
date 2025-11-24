<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد الموعد</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            direction: rtl; 
            text-align: right; 
            background-color: #f8f9fa; 
            margin: 0; 
            padding: 20px; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 10px; 
            padding: 30px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            color: #2c3e50; 
        }
        .appointment-details { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 8px; 
            margin: 20px 0; 
        }
        .detail-row { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 10px; 
            padding: 8px 0; 
            border-bottom: 1px solid #eee; 
        }
        .detail-label { 
            font-weight: bold; 
            color: #495057; 
        }
        .detail-value { 
            color: #2c3e50; 
        }
        .footer { 
            text-align: center; 
            margin-top: 30px; 
            padding-top: 20px; 
            border-top: 1px solid #eee; 
            color: #6c757d; 
        }
        .clinic-info { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .status { 
            background: #28a745; 
            color: white; 
            padding: 5px 15px; 
            border-radius: 20px; 
            font-size: 12px; 
            display: inline-block; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $doctor }}</h1>
            <h2>تأكيد موعد العيادة</h2>
        </div>

        <div class="clinic-info">
            <p><strong>عيادة دكتور عبدالناصر الأخرص</strong></p>
            <p>شكراً لاختيارك خدماتنا الطبية</p>
        </div>

        <div class="appointment-details">
            <h3>تفاصيل الموعد</h3>
            
            <div class="detail-row">
                <span class="detail-label">اسم المريض:</span>
                <span class="detail-value">{{ $appointment->patient_name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">رقم الهاتف:</span>
                <span class="detail-value">{{ $appointment->patient_phone }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">البريد الإلكتروني:</span>
                <span class="detail-value">{{ $appointment->patient_email }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">نوع الخدمة:</span>
                <span class="detail-value">{{ $appointment->service->name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">تاريخ الموعد:</span>
                <span class="detail-value">{{ $appointment->appointment_date->format('d/m/Y') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">وقت الموعد:</span>
                <span class="detail-value">{{ $appointment->appointment_time->format('h:i A') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">كود التأكيد:</span>
                <span class="detail-value">{{ $appointment->confirmation_code }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">حالة الموعد:</span>
                <span class="status">{{ $appointment->status }}</span>
            </div>
        </div>

        @if($appointment->notes)
        <div class="appointment-details">
            <h3>ملاحظات</h3>
            <p>{{ $appointment->notes }}</p>
        </div>
        @endif

        <div class="footer">
            <p>في حالة وجود أي استفسار، يرجى الاتصال بنا</p>
            <p><strong>عيادة دكتور عبدالناصر الأخرص</strong></p>
            <p>© 2025 جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>