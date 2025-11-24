@extends('admin.layout')

@section('title', 'التحليلات والإحصائيات')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">التحليلات والإحصائيات</h1>
        <div class="d-flex gap-2">
            <select name="timeframe" id="timeframe" class="form-control" onchange="changeTimeframe()">
                <option value="7_days" {{ $timeframe == '7_days' ? 'selected' : '' }}>آخر 7 أيام</option>
                <option value="30_days" {{ $timeframe == '30_days' ? 'selected' : '' }}>آخر 30 يوم</option>
                <option value="90_days" {{ $timeframe == '90_days' ? 'selected' : '' }}>آخر 90 يوم</option>
                <option value="1_year" {{ $timeframe == '1_year' ? 'selected' : '' }}>السنة الماضية</option>
            </select>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي المواعيد
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $appointmentsByStatus->sum('count') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                معدل الإكمال
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $total = $appointmentsByStatus->sum('count');
                                    $completed = $appointmentsByStatus->where('status', 'completed')->first()->count ?? 0;
                                    echo $total > 0 ? round(($completed / $total) * 100, 1) : 0;
                                @endphp%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                متوسط المواعيد اليومية
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $days = match($timeframe) {
                                        '7_days' => 7,
                                        '30_days' => 30,
                                        '90_days' => 90,
                                        '1_year' => 365,
                                        default => 30,
                                    };
                                    echo round($total / $days, 1);
                                @endphp
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                معدل الإلغاء
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $cancelled = $appointmentsByStatus->where('status', 'cancelled')->first()->count ?? 0;
                                    echo $total > 0 ? round(($cancelled / $total) * 100, 1) : 0;
                                @endphp%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسوم البيانية -->
    <div class="row">
        <!-- حالة المواعيد -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">حالة المواعيد</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- المواعيد اليومية -->
        <div class="col-xl-6 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">المواعيد اليومية</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الخدمات الأكثر طلباً -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">الخدمات الأكثر طلباً</h6>
                </div>
                <div class="card-body">
                    @if($servicesAnalytics->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>الخدمة</th>
                                        <th>عدد المواعيد</th>
                                        <th>معدل الإكمال</th>
                                        <th>نسبة الطلب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servicesAnalytics as $service)
                                    <tr>
                                        <td>
                                            <strong>{{ $service->name }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                        </td>
                                        <td>{{ $service->total_appointments }}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" 
                                                     style="width: {{ $service->completion_rate }}%">
                                                    {{ number_format($service->completion_rate, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $percentage = $total > 0 ? ($service->total_appointments / $total) * 100 : 0;
                                            @endphp
                                            <span class="badge bg-info">{{ number_format($percentage, 1) }}%</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-gray-300"></i>
                            <p class="text-gray-500 mt-2">لا توجد بيانات متاحة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- الاتجاهات الشهرية -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">الاتجاهات الشهرية</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// تغيير الإطار الزمني
function changeTimeframe() {
    const timeframe = document.getElementById('timeframe').value;
    window.location.href = `{{ route('admin.analytics') }}?timeframe=${timeframe}`;
}

// رسم بياني لحالة المواعيد
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($appointmentsByStatus as $status)
                @switch($status->status)
                    @case('pending') 'بانتظار المراجعة' @break
                    @case('confirmed') 'مؤكدة' @break
                    @case('completed') 'مكتملة' @break
                    @case('cancelled') 'ملغية' @break
                    @default '{{ $status->status }}' @break
                @endswitch
                @if(!$loop->last),@endif
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($appointmentsByStatus as $status)
                    {{ $status->count }}@if(!$loop->last),@endif
                @endforeach
            ],
            backgroundColor: [
                '#f6c23e', '#1cc88a', '#36b9cc', '#e74a3b', '#858796'
            ],
            borderWidth: 1
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

// رسم بياني للمواعيد اليومية
const dailyCtx = document.getElementById('dailyChart').getContext('2d');
const dailyChart = new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: [
            @foreach($dailyAppointments as $daily)
                '{{ $daily->date }}'@if(!$loop->last),@endif
            @endforeach
        ],
        datasets: [{
            label: 'عدد المواعيد',
            data: [
                @foreach($dailyAppointments as $daily)
                    {{ $daily->count }}@if(!$loop->last),@endif
                @endforeach
            ],
            borderColor: '#36b9cc',
            backgroundColor: 'rgba(54, 185, 204, 0.1)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// رسم بياني للاتجاهات الشهرية
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: [
            @foreach($monthlyTrends as $trend)
                '{{ $trend->month_name }} {{ $trend->year_name }}'@if(!$loop->last),@endif
            @endforeach
        ],
        datasets: [
            {
                label: 'إجمالي المواعيد',
                data: [
                    @foreach($monthlyTrends as $trend)
                        {{ $trend->total_appointments }}@if(!$loop->last),@endif
                    @endforeach
                ],
                borderColor: '#36b9cc',
                backgroundColor: 'rgba(54, 185, 204, 0.1)',
                borderWidth: 2,
                fill: false
            },
            {
                label: 'مواعيد مكتملة',
                data: [
                    @foreach($monthlyTrends as $trend)
                        {{ $trend->completed_appointments }}@if(!$loop->last),@endif
                    @endforeach
                ],
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                borderWidth: 2,
                fill: false
            },
            {
                label: 'مواعيد ملغية',
                data: [
                    @foreach($monthlyTrends as $trend)
                        {{ $trend->cancelled_appointments }}@if(!$loop->last),@endif
                    @endforeach
                ],
                borderColor: '#e74a3b',
                backgroundColor: 'rgba(231, 74, 59, 0.1)',
                borderWidth: 2,
                fill: false
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});
</script>
@endsection