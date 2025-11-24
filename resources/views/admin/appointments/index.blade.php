@extends('admin.layout')

@section('title', 'إدارة المواعيد')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة المواعيد</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.appointments.export') }}" class="btn btn-success">
                <i class="fas fa-download"></i> تصدير البيانات
            </a>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي المواعيد
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_appointments'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                بانتظار المراجعة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_appointments'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                مؤكدة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['confirmed_appointments'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                مكتملة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed_appointments'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                ملغية
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['cancelled_appointments'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- فلاتر البحث -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">فلاتر البحث</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.appointments.index') }}">
                <div class="row">
                    <div class="col-md-2">
                        <label for="status" class="form-label">الحالة</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">جميع الحالات</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>بانتظار المراجعة</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكدة</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغية</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">من تاريخ</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" 
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">إلى تاريخ</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" 
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="service_id" class="form-label">الخدمة</label>
                        <select name="service_id" id="service_id" class="form-control">
                            <option value="">جميع الخدمات</option>
                            @foreach($services ?? [] as $service)
                                <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="doctor_id" class="form-label">الطبيب</label>
                        <select name="doctor_id" id="doctor_id" class="form-control">
                            <option value="">جميع الأطباء</option>
                            @foreach($doctors ?? [] as $doctor)
                                <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="search" class="form-label">البحث</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               placeholder="البحث في اسم المريض، الهاتف، أو البريد الإلكتروني..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> إلغاء البحث
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة المواعيد -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">قائمة المواعيد ({{ $appointments->total() }} موعد)</h6>
        </div>
        <div class="card-body">
            @if($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>المريض</th>
                                <th>الخدمة</th>
                                <th>الطبيب</th>
                                <th>تاريخ الموعد</th>
                                <th>الوقت</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $appointment->patient_name }}</strong><br>
                                        <small class="text-muted">{{ $appointment->patient_phone }}</small><br>
                                        <small class="text-muted">{{ $appointment->patient_email }}</small>
                                    </div>
                                </td>
                                <td>{{ $appointment->service->name ?? 'غير محدد' }}</td>
                                <td>{{ $appointment->doctor->name ?? 'غير محدد' }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}</td>
                                <td>{{ $appointment->appointment_time }}</td>
                                <td>
                                    @switch($appointment->status)
                                        @case('pending')
                                            <span class="badge bg-warning">بانتظار المراجعة</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-success">مؤكد</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-info">مكتمل</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">ملغي</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ Str::limit($appointment->notes, 30) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                           class="btn btn-sm btn-info" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($appointment->status == 'pending')
                                        <a href="{{ route('admin.appointments.confirm', $appointment) }}" 
                                           class="btn btn-sm btn-success" title="تأكيد">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="{{ route('admin.appointments.cancel', $appointment) }}" 
                                           class="btn btn-sm btn-warning" title="إلغاء">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                           class="btn btn-sm btn-primary" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.appointments.destroy', $appointment) }}" 
                                              style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- ترقيم الصفحات -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        عرض {{ $appointments->firstItem() }} إلى {{ $appointments->lastItem() }} من {{ $appointments->total() }} نتيجة
                    </div>
                    <div>
                        {{ $appointments->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">لا توجد مواعيد</h5>
                    <p class="text-gray-500">لم يتم العثور على أي مواعيد تطابق المعايير المحددة.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection