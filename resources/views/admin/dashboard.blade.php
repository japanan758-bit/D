@extends('admin.layout')

@section('title', 'لوحة التحكم الرئيسية')
@section('page_title', 'لوحة التحكم')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">إجمالي المواعيد</div>
                        <div class="stat-number">{{ number_format($stats['total_appointments']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">المواعيد المعلقة</div>
                        <div class="stat-number">{{ number_format($stats['pending_appointments']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">المواعيد المؤكدة</div>
                        <div class="stat-number">{{ number_format($stats['confirmed_appointments']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">الأطباء النشطين</div>
                        <div class="stat-number">{{ number_format($stats['total_doctors']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-md stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Charts Row -->
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">المواعيد الشهرية</h5>
            </div>
            <div class="card-body">
                <canvas id="appointmentsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">حالات المواعيد</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Appointments -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">المواعيد الحديثة</h5>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-primary btn-sm">
                    عرض الكل
                </a>
            </div>
            <div class="card-body">
                @if($recentAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>المريض</th>
                                    <th>الخدمة</th>
                                    <th>الطبيب</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2">
                                                {{ substr($appointment->patient_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $appointment->patient_name }}</div>
                                                <small class="text-muted">{{ $appointment->patient_phone }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $appointment->service->name ?? 'غير محدد' }}</td>
                                    <td>{{ $appointment->doctor->name ?? 'غير محدد' }}</td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y/m/d') }}</div>
                                        <small class="text-muted">{{ $appointment->appointment_time }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($appointment->status) {
                                                'pending' => 'bg-warning',
                                                'confirmed' => 'bg-success',
                                                'completed' => 'bg-primary',
                                                'cancelled' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                            
                                            $statusText = match($appointment->status) {
                                                'pending' => 'قيد الانتظار',
                                                'confirmed' => 'مؤكد',
                                                'completed' => 'مكتمل',
                                                'cancelled' => 'ملغي',
                                                default => $appointment->status
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">لا توجد مواعيد حديثة</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Quick Actions & Notifications -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">إجراءات سريعة</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.appointments.index') }}?status=pending" class="btn btn-warning btn-sm">
                        <i class="fas fa-clock me-2"></i>
                        مراجعة المواعيد المعلقة ({{ $stats['pending_appointments'] }})
                    </a>
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-md me-2"></i>
                        إدارة الأطباء
                    </a>
                    <a href="{{ route('admin.medical-records.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-medical me-2"></i>
                        إضافة سجل طبي
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-envelope me-2"></i>
                        الرسائل ({{ $stats['unread_messages'] }})
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Pending Testimonials -->
        @if($pendingTestimonials->count() > 0)
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">آراء المرضى المعلقة</h5>
                <span class="badge bg-warning">{{ $pendingTestimonials->count() }}</span>
            </div>
            <div class="card-body">
                @foreach($pendingTestimonials as $testimonial)
                <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                    <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-3">
                        <i class="fas fa-user text-muted"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $testimonial->patient_name }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($testimonial->message, 100) }}</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-xs" onclick="approveTestimonial({{ $testimonial->id }})">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="rejectTestimonial({{ $testimonial->id }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<div class="row">
    <!-- Today's Schedule -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">جدولة اليوم</h5>
            </div>
            <div class="card-body">
                @if($todayAppointments->count() > 0)
                    <div class="timeline">
                        @foreach($todayAppointments as $appointment)
                        <div class="timeline-item d-flex align-items-start mb-3">
                            <div class="timeline-time me-3 text-center">
                                <div class="badge bg-light text-dark">{{ $appointment->appointment_time }}</div>
                            </div>
                            <div class="timeline-content flex-grow-1">
                                <h6 class="mb-1">{{ $appointment->patient_name }}</h6>
                                <p class="text-muted small mb-1">{{ $appointment->service->name ?? 'غير محدد' }}</p>
                                <small class="text-muted">{{ $appointment->doctor->name ?? 'غير محدد' }}</small>
                                <div class="mt-1">
                                    @php
                                        $statusClass = match($appointment->status) {
                                            'pending' => 'badge-warning',
                                            'confirmed' => 'badge-success',
                                            default => 'badge-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ match($appointment->status) {
                                            'pending' => 'قيد الانتظار',
                                            'confirmed' => 'مؤكد',
                                            default => $appointment->status
                                        } }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                        <p class="text-muted">لا توجد مواعيد لليوم</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Popular Services -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">الخدمات الأكثر طلباً</h5>
            </div>
            <div class="card-body">
                @if($popularServices->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($popularServices as $index => $service)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $service->name }}</h6>
                                <p class="text-muted small mb-0">{{ $service->price }} ريال</p>
                            </div>
                            <div class="text-center">
                                <span class="badge bg-primary">{{ $service->appointment_count }}</span>
                                <br>
                                <small class="text-muted">موعد</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                        <p class="text-muted">لا توجد بيانات للخدمات</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Appointments Chart
    const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
    const appointmentsChart = new Chart(appointmentsCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($monthlyAppointments as $appointment)
                    '{{ $appointment->month_name }}',
                @endforeach
            ],
            datasets: [{
                label: 'عدد المواعيد',
                data: [
                    @foreach($monthlyAppointments as $appointment)
                        {{ $appointment->count }},
                    @endforeach
                ],
                borderColor: '#2c5aa0',
                backgroundColor: 'rgba(44, 90, 160, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['معلق', 'مؤكد', 'مكتمل', 'ملغي'],
            datasets: [{
                data: [
                    {{ $stats['pending_appointments'] }},
                    {{ $stats['confirmed_appointments'] }},
                    {{ $stats['completed_appointments'] }},
                    {{ $stats['cancelled_appointments'] }}
                ],
                backgroundColor: [
                    '#f59e0b',
                    '#10b981',
                    '#3b82f6',
                    '#ef4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Testimonial actions
    function approveTestimonial(id) {
        if (confirm('هل تريد الموافقة على هذا الرأي؟')) {
            fetch(`/admin/testimonials/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                location.reload();
            });
        }
    }
    
    function rejectTestimonial(id) {
        if (confirm('هل تريد رفض هذا الرأي؟')) {
            fetch(`/admin/testimonials/${id}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                location.reload();
            });
        }
    }
</script>
@endpush