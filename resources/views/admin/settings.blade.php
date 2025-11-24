@extends('admin.layout')

@section('title', 'إعدادات النظام')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">إعدادات النظام</h1>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PATCH')
        
        <!-- إعدادات العيادة الأساسية -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">إعدادات العيادة الأساسية</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clinic_name">اسم العيادة *</label>
                            <input type="text" class="form-control @error('clinic_name') is-invalid @enderror" 
                                   id="clinic_name" name="clinic_name" 
                                   value="{{ old('clinic_name', $settings->clinic_name ?? '') }}" required>
                            @error('clinic_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clinic_phone">رقم الهاتف *</label>
                            <input type="text" class="form-control @error('clinic_phone') is-invalid @enderror" 
                                   id="clinic_phone" name="clinic_phone" 
                                   value="{{ old('clinic_phone', $settings->clinic_phone ?? '') }}" required>
                            @error('clinic_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clinic_email">البريد الإلكتروني *</label>
                            <input type="email" class="form-control @error('clinic_email') is-invalid @enderror" 
                                   id="clinic_email" name="clinic_email" 
                                   value="{{ old('clinic_email', $settings->clinic_email ?? '') }}" required>
                            @error('clinic_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_duration">مدة الموعد بالدقائق *</label>
                            <input type="number" class="form-control @error('appointment_duration') is-invalid @enderror" 
                                   id="appointment_duration" name="appointment_duration" 
                                   value="{{ old('appointment_duration', $settings->appointment_duration ?? 30) }}" 
                                   min="15" max="120" required>
                            @error('appointment_duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="max_appointments_per_day">الحد الأقصى للمواعيد يومياً *</label>
                            <input type="number" class="form-control @error('max_appointments_per_day') is-invalid @enderror" 
                                   id="max_appointments_per_day" name="max_appointments_per_day" 
                                   value="{{ old('max_appointments_per_day', $settings->max_appointments_per_day ?? 20) }}" 
                                   min="1" required>
                            @error('max_appointments_per_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="whatsapp_number">رقم واتساب</label>
                            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" 
                                   id="whatsapp_number" name="whatsapp_number" 
                                   value="{{ old('whatsapp_number', $settings->whatsapp_number ?? '') }}">
                            @error('whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="clinic_address">عنوان العيادة *</label>
                    <textarea class="form-control @error('clinic_address') is-invalid @enderror" 
                              id="clinic_address" name="clinic_address" rows="3" required>{{ old('clinic_address', $settings->clinic_address ?? '') }}</textarea>
                    @error('clinic_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ساعات العمل -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ساعات العمل</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sunday_start">الأحد - من</label>
                            <input type="time" class="form-control" id="sunday_start" name="working_hours[sunday][start]" 
                                   value="{{ old('working_hours.sunday.start', $settings->working_hours['sunday']['start'] ?? '09:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sunday_end">الأحد - إلى</label>
                            <input type="time" class="form-control" id="sunday_end" name="working_hours[sunday][end]" 
                                   value="{{ old('working_hours.sunday.end', $settings->working_hours['sunday']['end'] ?? '17:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="monday_start">الاثنين - من</label>
                            <input type="time" class="form-control" id="monday_start" name="working_hours[monday][start]" 
                                   value="{{ old('working_hours.monday.start', $settings->working_hours['monday']['start'] ?? '09:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="monday_end">الاثنين - إلى</label>
                            <input type="time" class="form-control" id="monday_end" name="working_hours[monday][end]" 
                                   value="{{ old('working_hours.monday.end', $settings->working_hours['monday']['end'] ?? '17:00') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tuesday_start">الثلاثاء - من</label>
                            <input type="time" class="form-control" id="tuesday_start" name="working_hours[tuesday][start]" 
                                   value="{{ old('working_hours.tuesday.start', $settings->working_hours['tuesday']['start'] ?? '09:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tuesday_end">الثلاثاء - إلى</label>
                            <input type="time" class="form-control" id="tuesday_end" name="working_hours[tuesday][end]" 
                                   value="{{ old('working_hours.tuesday.end', $settings->working_hours['tuesday']['end'] ?? '17:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="wednesday_start">الأربعاء - من</label>
                            <input type="time" class="form-control" id="wednesday_start" name="working_hours[wednesday][start]" 
                                   value="{{ old('working_hours.wednesday.start', $settings->working_hours['wednesday']['start'] ?? '09:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="wednesday_end">الأربعاء - إلى</label>
                            <input type="time" class="form-control" id="wednesday_end" name="working_hours[wednesday][end]" 
                                   value="{{ old('working_hours.wednesday.end', $settings->working_hours['wednesday']['end'] ?? '17:00') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="thursday_start">الخميس - من</label>
                            <input type="time" class="form-control" id="thursday_start" name="working_hours[thursday][start]" 
                                   value="{{ old('working_hours.thursday.start', $settings->working_hours['thursday']['start'] ?? '09:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="thursday_end">الخميس - إلى</label>
                            <input type="time" class="form-control" id="thursday_end" name="working_hours[thursday][end]" 
                                   value="{{ old('working_hours.thursday.end', $settings->working_hours['thursday']['end'] ?? '17:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="friday_start">الجمعة - من</label>
                            <input type="time" class="form-control" id="friday_start" name="working_hours[friday][start]" 
                                   value="{{ old('working_hours.friday.start', $settings->working_hours['friday']['start'] ?? '09:00') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="friday_end">الجمعة - إلى</label>
                            <input type="time" class="form-control" id="friday_end" name="working_hours[friday][end]" 
                                   value="{{ old('working_hours.friday.end', $settings->working_hours['friday']['end'] ?? '17:00') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="saturday_start">السبت - من</label>
                            <input type="time" class="form-control" id="saturday_start" name="working_hours[saturday][start]" 
                                   value="{{ old('working_hours.saturday.start', $settings->working_hours['saturday']['start'] ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="saturday_end">السبت - إلى</label>
                            <input type="time" class="form-control" id="saturday_end" name="working_hours[saturday][end]" 
                                   value="{{ old('working_hours.saturday.end', $settings->working_hours['saturday']['end'] ?? '') }}">
                        </div>
                    </div>
                </div>
                <small class="form-text text-muted">اترك الوقت فارغاً إذا كان اليوم غير مُعرف</small>
            </div>
        </div>

        <!-- روابط وسائل التواصل الاجتماعي -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">روابط وسائل التواصل الاجتماعي</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="facebook_url">رابط فيسبوك</label>
                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                   id="facebook_url" name="facebook_url" 
                                   value="{{ old('facebook_url', $settings->facebook_url ?? '') }}">
                            @error('facebook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twitter_url">رابط تويتر</label>
                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                   id="twitter_url" name="twitter_url" 
                                   value="{{ old('twitter_url', $settings->twitter_url ?? '') }}">
                            @error('twitter_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instagram_url">رابط إنستغرام</label>
                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                   id="instagram_url" name="instagram_url" 
                                   value="{{ old('instagram_url', $settings->instagram_url ?? '') }}">
                            @error('instagram_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="google_maps_url">رابط خرائط جوجل</label>
                            <input type="url" class="form-control @error('google_maps_url') is-invalid @enderror" 
                                   id="google_maps_url" name="google_maps_url" 
                                   value="{{ old('google_maps_url', $settings->google_maps_url ?? '') }}">
                            @error('google_maps_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- إعدادات التحليلات -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">إعدادات التحليلات</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="google_analytics_id">معرف Google Analytics</label>
                    <input type="text" class="form-control @error('google_analytics_id') is-invalid @enderror" 
                           id="google_analytics_id" name="google_analytics_id" 
                           value="{{ old('google_analytics_id', $settings->google_analytics_id ?? '') }}" 
                           placeholder="GA4-XXXXXXXXX">
                    @error('google_analytics_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">اتركه فارغاً إذا كنت لا تستخدم Google Analytics</small>
                </div>
            </div>
        </div>

        <!-- أزرار الحفظ -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> حفظ الإعدادات
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تحسين تجربة المستخدم في تحديد ساعات العمل
    const timeInputs = document.querySelectorAll('input[type="time"]');
    timeInputs.forEach(input => {
        input.addEventListener('change', function() {
            const startInput = this.parentElement.parentElement.querySelector('input[name*="[start]"]');
            const endInput = this.parentElement.parentElement.querySelector('input[name*="[end]"]');
            
            if (startInput && endInput && startInput.value && endInput.value) {
                const startTime = new Date('2000-01-01 ' + startInput.value);
                const endTime = new Date('2000-01-01 ' + endInput.value);
                
                if (endTime <= startTime) {
                    alert('وقت النهاية يجب أن يكون بعد وقت البداية');
                    this.value = '';
                }
            }
        });
    });
});
</script>
@endsection