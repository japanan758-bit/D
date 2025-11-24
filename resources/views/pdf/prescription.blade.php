<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>وصفة طبية - {{ $record->patient_name }}</title>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .clinic-name { font-size: 24px; font-weight: bold; }
        .doctor-name { font-size: 18px; }
        .patient-info { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 5px; }
        .rx-symbol { font-size: 30px; font-weight: bold; margin-bottom: 10px; }
        .medication { margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
        .medication-name { font-weight: bold; font-size: 16px; }
        .medication-dose { color: #555; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 12px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="clinic-name">{{ $settings->clinic_name ?? 'عيادة طبية' }}</div>
        <div class="doctor-name">{{ $record->doctor->name ?? 'الطبيب المعالج' }}</div>
        <div>{{ $settings->clinic_address ?? '' }} | {{ $settings->clinic_phone ?? '' }}</div>
    </div>

    <div class="patient-info">
        <strong>اسم المريض:</strong> {{ $record->patient_name }} <br>
        <strong>التاريخ:</strong> {{ $record->created_at->format('Y-m-d') }} <br>
        <strong>التشخيص:</strong> {{ $record->diagnosis }}
    </div>

    <div class="rx-symbol">Rx</div>

    <div class="medications">
        @if($record->medications)
            @foreach($record->medications as $index => $med)
                <div class="medication">
                    <div class="medication-name">{{ $med }}</div>
                    <div class="medication-dose">
                        {{ $record->dosages[$index] ?? '' }} - {{ $record->frequencies[$index] ?? '' }}
                        ({{ $record->durations[$index] ?? '' }})
                    </div>
                </div>
            @endforeach
        @else
            <p>لا توجد أدوية مسجلة.</p>
        @endif
    </div>

    <div class="footer">
        <p>نتمنى لكم الشفاء العاجل</p>
        <p>{{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
