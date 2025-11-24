<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار من نظام إدارة العيادة</title>
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
            border-bottom: 2px solid #6c757d;
        }
        .notification-content {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 20px 0;
            border-right: 4px solid #007bff;
        }
        .notification-type {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .type-info {
            background-color: #cce7ff;
            color: #004085;
        }
        .type-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .type-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .type-success {
            background-color: #d4edda;
            color: #155724;
        }
        .notification-details {
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: bold;
            color: #495057;
        }
        .detail-value {
            color: #007bff;
        }
        .system-info {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #ced4da;
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
            margin: 10px 5px;
        }
        .dashboard-button {
            background-color: #28a745;
        }
        .support-button {
            background-color: #6c757d;
        }
        .priority-high {
            border-right-color: #dc3545 !important;
        }
        .priority-medium {
            border-right-color: #fd7e14 !important;
        }
        .priority-low {
            border-right-color: #28a745 !important;
        }
        .code-block {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 15px 0;
            direction: ltr;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #6c757d; margin: 0;">🔔 نظام إدارة العيادة</h1>
            <h2 style="color: #007bff; margin: 10px 0 0 0;">إشعار من النظام</h2>
        </div>

        <div class="notification-content {{ $priorityClass ?? '' }}">
            @if(isset($notificationType))
                <span class="notification-type type-{{ $notificationType }}">{{ $notificationTypeText }}</span>
            @else
                <span class="notification-type type-info">معلومات عامة</span>
            @endif

            @if(isset($title))
                <h3 style="color: #495057; margin: 15px 0;">{{ $title }}</h3>
            @else
                <h3 style="color: #495057; margin: 15px 0;">إشعار من النظام</h3>
            @endif

            @if(isset($message))
                <div style="font-size: 16px; line-height: 1.6; color: #495057;">
                    {!! nl2br(e($message)) !!}
                </div>
            @else
                <div style="font-size: 16px; line-height: 1.6; color: #495057;">
                    تم إرسال هذا الإشعار من نظام إدارة العيادة لأغراض إعلامية.
                </div>
            @endif
        </div>

        @if(isset($details) && count($details) > 0)
        <div class="notification-details">
            <h4 style="color: #495057; margin-bottom: 15px;">📋 تفاصيل إضافية:</h4>
            @foreach($details as $key => $value)
            <div class="detail-row">
                <span class="detail-label">{{ $key }}:</span>
                <span class="detail-value">{{ $value }}</span>
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($actionRequired) && $actionRequired)
        <div class="notification-content priority-high">
            <h4 style="color: #721c24; margin-top: 0;">⚠️ إجراء مطلوب</h4>
            <p style="color: #721c24; font-weight: bold;">{{ $actionRequired }}</p>
            
            @if(isset($actionUrl))
                <div style="text-align: center; margin-top: 20px;">
                    <a href="{{ $actionUrl }}" class="button" style="background-color: #dc3545;">
                        {{ $actionText ?? 'اتخاذ الإجراء' }}
                    </a>
                </div>
            @endif
        </div>
        @endif

        @if(isset($systemInfo) && count($systemInfo) > 0)
        <div class="system-info">
            <h4 style="color: #6c757d; margin-top: 0;">💻 معلومات النظام</h4>
            @foreach($systemInfo as $key => $value)
            <div class="detail-row">
                <span class="detail-label">{{ $key }}:</span>
                <span class="detail-value">{{ $value }}</span>
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($errorDetails))
        <div class="notification-content priority-high">
            <h4 style="color: #721c24; margin-top: 0;">🔍 تفاصيل الخطأ:</h4>
            @if(isset($errorDetails['message']))
                <p style="color: #721c24;"><strong>الرسالة:</strong> {{ $errorDetails['message'] }}</p>
            @endif
            
            @if(isset($errorDetails['file']))
                <p style="color: #721c24;"><strong>الملف:</strong> {{ $errorDetails['file'] }}</p>
            @endif
            
            @if(isset($errorDetails['line']))
                <p style="color: #721c24;"><strong>السطر:</strong> {{ $errorDetails['line'] }}</p>
            @endif

            @if(isset($errorDetails['trace']))
                <div class="code-block">
                    {{ $errorDetails['trace'] }}
                </div>
            @endif
        </div>
        @endif

        @if(isset($recommendations) && count($recommendations) > 0)
        <div class="notification-content priority-medium">
            <h4 style="color: #856404; margin-top: 0;">💡 توصيات</h4>
            <ul style="line-height: 1.8; color: #856404;">
                @foreach($recommendations as $recommendation)
                    <li>{{ $recommendation }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(isset($nextSteps) && count($nextSteps) > 0)
        <div class="notification-content">
            <h4 style="color: #495057; margin-top: 0;">📋 الخطوات التالية</h4>
            <ol style="line-height: 1.8; color: #495057;">
                @foreach($nextSteps as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ol>
        </div>
        @endif

        <div class="footer">
            <p><strong>معلومات الإشعار:</strong></p>
            <div class="detail-row" style="border: none; padding: 5px 0;">
                <span class="detail-label">تاريخ الإرسال:</span>
                <span class="detail-value">{{ now()->format('Y-m-d H:i:s') }}</span>
            </div>
            <div class="detail-row" style="border: none; padding: 5px 0;">
                <span class="detail-label">رقم المرجع:</span>
                <span class="detail-value">#{{ $referenceNumber ?? 'SYS-' . now()->format('YmdHis') }}</span>
            </div>
            <div class="detail-row" style="border: none; padding: 5px 0;">
                <span class="detail-label">نوع الإشعار:</span>
                <span class="detail-value">{{ $notificationType ?? 'معلومات عامة' }}</span>
            </div>
            <div class="detail-row" style="border: none; padding: 5px 0;">
                <span class="detail-label">الأولوية:</span>
                <span class="detail-value">{{ $priority ?? 'عادية' }}</span>
            </div>

            <div style="margin: 25px 0;">
                <a href="{{ url('/admin/dashboard') }}" class="button dashboard-button">🏥 لوحة التحكم</a>
                <a href="mailto:{{ config('clinic.support_email', 'support@clinic.com') }}?subject=استفسار حول الإشعار #{{ $referenceNumber ?? '' }}" class="button support-button">📧 الدعم التقني</a>
            </div>

            <p style="margin-top: 25px;">
                📞 الدعم التقني: {{ config('clinic.support_phone', '+966-XX-XXX-XXXX') }}<br>
                📧 البريد الإلكتروني: {{ config('clinic.email', 'info@clinic.com') }}<br>
                🕒 ساعات العمل: {{ config('clinic.working_hours', 'السبت - الخميس: 8:00 ص - 10:00 م') }}
            </p>
            
            <p style="margin-top: 20px; font-size: 12px; color: #6c757d;">
                تم إرسال هذا الإشعار تلقائياً من نظام إدارة العيادة.<br>
                للحصول على مساعدة فورية، يرجى الاتصال بخدمة العملاء.
            </p>
            
            <p style="margin-top: 15px; font-weight: bold;">
                © {{ date('Y') }} {{ config('clinic.name', 'عيادة الشفاء الطبية') }}. جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</body>
</html>