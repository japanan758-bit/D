<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير صحة النظام</title>
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #28a745;
        }
        .report-title {
            background-color: #28a745;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .status-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .status-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            text-align: center;
            transition: transform 0.2s;
        }
        .status-card:hover {
            transform: translateY(-2px);
        }
        .status-excellent {
            border-color: #28a745;
            background-color: #d4edda;
        }
        .status-good {
            border-color: #20c997;
            background-color: #c3e6cb;
        }
        .status-warning {
            border-color: #ffc107;
            background-color: #fff3cd;
        }
        .status-critical {
            border-color: #dc3545;
            background-color: #f8d7da;
        }
        .status-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .status-label {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .status-value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .section {
            margin: 30px 0;
            padding: 25px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        .section-title {
            background-color: #495057;
            color: white;
            padding: 12px 15px;
            margin: -25px -25px 20px -25px;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
            font-size: 18px;
        }
        .metric-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .metric-row:last-child {
            border-bottom: none;
        }
        .metric-name {
            font-weight: bold;
            color: #495057;
        }
        .metric-value {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
        }
        .value-excellent {
            background-color: #d4edda;
            color: #155724;
        }
        .value-good {
            background-color: #c3e6cb;
            color: #0a3622;
        }
        .value-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .value-critical {
            background-color: #f8d7da;
            color: #721c24;
        }
        .performance-chart {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .chart-bar {
            height: 20px;
            background-color: #007bff;
            border-radius: 10px;
            margin: 10px 0;
            position: relative;
            transition: width 0.3s ease;
        }
        .chart-bar::after {
            content: attr(data-value);
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        .alerts-section {
            margin: 20px 0;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-right: 4px solid;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        .alert-info {
            background-color: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }
        .recommendations {
            background-color: #e8f4fd;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #b8daff;
            margin: 20px 0;
        }
        .recommendations ul {
            line-height: 1.8;
            color: #004085;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
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
        .admin-button {
            background-color: #28a745;
        }
        .print-button {
            background-color: #6c757d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: right;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        .timestamp {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin: 20px 0;
            border: 1px solid #dee2e6;
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #28a745; margin: 0; font-size: 28px;">🏥 تقرير صحة النظام</h1>
            <p style="margin: 10px 0 0 0; color: #6c757d;">نظام إدارة العيادة - {{ config('clinic.name', 'عيادة الشفاء الطبية') }}</p>
        </div>

        <div class="timestamp">
            📅 تاريخ التقرير: {{ $reportDate ?? now()->format('Y-m-d H:i:s') }}
        </div>

        <div class="report-title">
            <h2 style="margin: 0; font-size: 24px;">تقرير شامل لحالة النظام</h2>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">رقم التقرير: #{{ $reportNumber ?? 'SYS-HR-' . now()->format('YmdHis') }}</p>
        </div>

        <div class="status-overview">
            @if(isset($overallStatus))
                <div class="status-card status-{{ $overallStatus['class'] ?? 'good' }}">
                    <div class="status-icon">
                        @if(($overallStatus['level'] ?? 'good') === 'excellent')
                            🟢
                        @elseif(($overallStatus['level'] ?? 'good') === 'good')
                            🟡
                        @elseif(($overallStatus['level'] ?? 'good') === 'warning')
                            🟠
                        @else
                            🔴
                        @endif
                    </div>
                    <div class="status-label">الحالة العامة</div>
                    <div class="status-value">{{ $overallStatus['text'] ?? 'جيد' }}</div>
                </div>
            @endif

            @if(isset($systemHealth))
                <div class="status-card status-{{ $systemHealth['class'] ?? 'good' }}">
                    <div class="status-icon">🖥️</div>
                    <div class="status-label">صحة النظام</div>
                    <div class="status-value">{{ $systemHealth['percentage'] ?? '95' }}%</div>
                </div>
            @endif

            @if(isset($performance))
                <div class="status-card status-{{ $performance['class'] ?? 'good' }}">
                    <div class="status-icon">⚡</div>
                    <div class="status-label">الأداء</div>
                    <div class="status-value">{{ $performance['score'] ?? '92' }}/100</div>
                </div>
            @endif

            @if(isset($uptime))
                <div class="status-card status-excellent">
                    <div class="status-icon">⏱️</div>
                    <div class="status-label">وقت التشغيل</div>
                    <div class="status-value">{{ $uptime['percentage'] ?? '99.9' }}%</div>
                </div>
            @endif

            @if(isset($activeUsers))
                <div class="status-card">
                    <div class="status-icon">👥</div>
                    <div class="status-label">المستخدمين النشطين</div>
                    <div class="status-value">{{ $activeUsers['count'] ?? '0' }}</div>
                </div>
            @endif

            @if(isset($pendingTasks))
                <div class="status-card">
                    <div class="status-icon">📋</div>
                    <div class="status-label">المهام المعلقة</div>
                    <div class="status-value">{{ $pendingTasks['count'] ?? '0' }}</div>
                </div>
            @endif
        </div>

        <div class="section">
            <div class="section-title">🔍 تفاصيل النظام</div>
            
            <div class="metric-row">
                <span class="metric-name">نسخة Laravel:</span>
                <span class="metric-value value-excellent">{{ app()->version() }}</span>
            </div>
            
            <div class="metric-row">
                <span class="metric-name">نسخة PHP:</span>
                <span class="metric-value value-excellent">{{ PHP_VERSION }}</span>
            </div>
            
            <div class="metric-row">
                <span class="metric-name">بيئة التشغيل:</span>
                <span class="metric-value value-good">{{ config('app.env', 'local') }}</span>
            </div>
            
            <div class="metric-row">
                <span class="metric-name">حالة Debug:</span>
                <span class="metric-value {{ config('app.debug') ? 'value-warning' : 'value-excellent' }}">
                    {{ config('app.debug') ? 'مفعل' : 'غير مفعل' }}
                </span>
            </div>
            
            <div class="metric-row">
                <span class="metric-name">الذاكرة المستخدمة:</span>
                <span class="metric-value value-good">{{ round(memory_get_peak_usage(true) / 1024 / 1024, 2) }} MB</span>
            </div>
        </div>

        <div class="section">
            <div class="section-title">📊 إحصائيات الأداء</div>
            
            <div class="performance-chart">
                <h4 style="margin-top: 0; color: #495057;">استخدام الموارد</h4>
                
                @if(isset($cpuUsage))
                <div style="margin: 15px 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;">استخدام المعالج:</span>
                        <span>{{ $cpuUsage['current'] ?? '45' }}%</span>
                    </div>
                    <div class="chart-bar" style="width: {{ $cpuUsage['current'] ?? '45' }}%; background-color: {{ ($cpuUsage['current'] ?? 45) > 80 ? '#dc3545' : (($cpuUsage['current'] ?? 45) > 60 ? '#ffc107' : '#28a745') }};" data-value="{{ $cpuUsage['current'] ?? '45' }}%"></div>
                </div>
                @endif

                @if(isset($memoryUsage))
                <div style="margin: 15px 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;">استخدام الذاكرة:</span>
                        <span>{{ $memoryUsage['current'] ?? '68' }}%</span>
                    </div>
                    <div class="chart-bar" style="width: {{ $memoryUsage['current'] ?? '68' }}%; background-color: {{ ($memoryUsage['current'] ?? 68) > 90 ? '#dc3545' : (($memoryUsage['current'] ?? 68) > 70 ? '#ffc107' : '#28a745') }};" data-value="{{ $memoryUsage['current'] ?? '68' }}%"></div>
                </div>
                @endif

                @if(isset($diskUsage))
                <div style="margin: 15px 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;">استخدام القرص الصلب:</span>
                        <span>{{ $diskUsage['current'] ?? '34' }}%</span>
                    </div>
                    <div class="chart-bar" style="width: {{ $diskUsage['current'] ?? '34' }}%; background-color: {{ ($diskUsage['current'] ?? 34) > 90 ? '#dc3545' : (($diskUsage['current'] ?? 34) > 70 ? '#ffc107' : '#28a745') }};" data-value="{{ $diskUsage['current'] ?? '34' }}%"></div>
                </div>
                @endif

                @if(isset($databaseSize))
                <div style="margin: 15px 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: bold;">حجم قاعدة البيانات:</span>
                        <span>{{ $databaseSize['current'] ?? '2.3' }} MB</span>
                    </div>
                    <div class="chart-bar" style="width: {{ min(($databaseSize['current'] ?? 2.3) * 10, 100) }}%; background-color: #17a2b8;" data-value="{{ $databaseSize['current'] ?? '2.3' }} MB"></div>
                </div>
                @endif
            </div>
        </div>

        @if(isset($componentsStatus) && count($componentsStatus) > 0)
        <div class="section">
            <div class="section-title">🔧 حالة المكونات</div>
            <table>
                <thead>
                    <tr>
                        <th>المكون</th>
                        <th>الحالة</th>
                        <th>الوقت المستغرق (ms)</th>
                        <th>آخر فحص</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($componentsStatus as $component)
                    <tr>
                        <td><strong>{{ $component['name'] }}</strong></td>
                        <td>
                            @if($component['status'] === 'healthy')
                                <span style="color: #28a745; font-weight: bold;">✅ سليم</span>
                            @elseif($component['status'] === 'warning')
                                <span style="color: #ffc107; font-weight: bold;">⚠️ تحذير</span>
                            @else
                                <span style="color: #dc3545; font-weight: bold;">❌ خطأ</span>
                            @endif
                        </td>
                        <td>{{ $component['response_time'] ?? 'N/A' }}</td>
                        <td>{{ $component['last_check'] ?? now()->format('H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if(isset($alerts) && count($alerts) > 0)
        <div class="alerts-section">
            <h3 style="color: #495057; margin-bottom: 15px;">🚨 التنبيهات والإشعارات</h3>
            @foreach($alerts as $alert)
            <div class="alert alert-{{ $alert['type'] ?? 'info' }}">
                <strong>{{ $alert['title'] ?? 'تنبيه' }}:</strong> {{ $alert['message'] }}
                @if(isset($alert['timestamp']))
                    <br><small style="opacity: 0.7;">{{ $alert['timestamp'] }}</small>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($recommendations) && count($recommendations) > 0)
        <div class="recommendations">
            <h3 style="color: #004085; margin-top: 0;">💡 التوصيات</h3>
            <ul>
                @foreach($recommendations as $recommendation)
                    <li>{{ $recommendation }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(isset($securityStatus))
        <div class="section">
            <div class="section-title">🔒 حالة الأمان</div>
            
            <div class="metric-row">
                <span class="metric-name">حالة HTTPS:</span>
                <span class="metric-value {{ $securityStatus['https_enabled'] ? 'value-excellent' : 'value-critical' }}">
                    {{ $securityStatus['https_enabled'] ? 'مفعل ✅' : 'غير مفعل ❌' }}
                </span>
            </div>
            
            <div class="metric-row">
                <span class="metric-name">حالة التشفير:</span>
                <span class="metric-value value-excellent">{{ $securityStatus['encryption'] ?? 'TLS 1.3' }}</span>
            </div>
            
            <div class="metric-row">
                <span class="metric-name">آخر نسخ احتياطية:</span>
                <span class="metric-value value-good">{{ $securityStatus['last_backup'] ?? 'غير محدد' }}</span>
            </div>
            
            <div class="metric-row">
                <span class="metric-name">حالة SSL:</span>
                <span class="metric-value {{ $securityStatus['ssl_valid'] ? 'value-excellent' : 'value-warning' }}">
                    {{ $securityStatus['ssl_valid'] ? 'صالح ✅' : 'منتهي الصلاحية ⚠️' }}
                </span>
            </div>
        </div>
        @endif

        <div class="footer">
            <div style="margin: 30px 0;">
                <a href="{{ url('/admin/health-check') }}" class="button admin-button">🏥 لوحة التحكم</a>
                <a href="{{ url('/admin/health-report/print/' . ($reportNumber ?? 'latest')) }}" class="button print-button">🖨️ طباعة التقرير</a>
            </div>

            <p style="margin-top: 30px;"><strong>معلومات التقرير:</strong></p>
            <p>تاريخ الإنشاء: {{ now()->format('Y-m-d H:i:s') }}</p>
            <p>نوع التقرير: {{ $reportType ?? 'تقرير صحة النظام التلقائي' }}</p>
            <p>المرجع: #{{ $reportNumber ?? 'SYS-HR-' . now()->format('YmdHis') }}</p>
            
            <p style="margin-top: 25px;">
                📞 الدعم التقني: {{ config('clinic.support_phone', '+966-XX-XXX-XXXX') }}<br>
                📧 البريد الإلكتروني: {{ config('clinic.email', 'info@clinic.com') }}<br>
                🌐 النظام: {{ config('app.name', 'Clinic Management System') }} v{{ app()->version() }}
            </p>
            
            <p style="margin-top: 20px; font-size: 12px; color: #6c757d;">
                تم إنشاء هذا التقرير تلقائياً بواسطة نظام إدارة العيادة.<br>
                للحصول على مساعدة فورية في حالة وجود مشاكل، يرجى الاتصال بالدعم التقني.
            </p>
            
            <p style="margin-top: 15px; font-weight: bold;">
                © {{ date('Y') }} {{ config('clinic.name', 'عيادة الشفاء الطبية') }}. جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</body>
</html>