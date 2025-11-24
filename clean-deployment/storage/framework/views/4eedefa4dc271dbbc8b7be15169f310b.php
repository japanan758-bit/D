<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'لوحة التحكم'); ?> - نظام إدارة العيادة</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts Arabic -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom Admin Styles -->
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #1e3a8a;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --border-color: #e5e7eb;
        }
        
        * {
            font-family: 'Cairo', sans-serif;
        }
        
        body {
            background-color: #f8fafc;
            font-size: 14px;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand h3 {
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-brand small {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .sidebar-item {
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
            border-radius: 0;
            position: relative;
        }
        
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
        }
        
        .sidebar-item.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-right: 4px solid white;
        }
        
        .sidebar-item i {
            width: 20px;
            margin-left: 0.75rem;
            text-align: center;
        }
        
        .sidebar.collapsed .sidebar-item span,
        .sidebar.collapsed .sidebar-brand h3,
        .sidebar.collapsed .sidebar-brand small {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-brand {
            padding: 1rem;
        }
        
        /* Main Content */
        .main-content {
            margin-right: 260px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-right: 80px;
        }
        
        /* Header */
        .admin-header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header-btn {
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .header-btn:hover {
            background-color: var(--light-color);
            color: var(--primary-color);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Statistics Cards */
        .stat-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
        }
        
        .stat-card.success {
            background: linear-gradient(135deg, var(--success-color), #047857);
        }
        
        .stat-card.warning {
            background: linear-gradient(135deg, var(--warning-color), #b45309);
        }
        
        .stat-card.danger {
            background: linear-gradient(135deg, var(--danger-color), #b91c1c);
        }
        
        .stat-card.info {
            background: linear-gradient(135deg, var(--info-color), #0e7490);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Tables */
        .table {
            font-size: 0.9rem;
        }
        
        .table th {
            background-color: var(--light-color);
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--dark-color);
            padding: 1rem 0.75rem;
        }
        
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }
        
        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }
        
        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        /* Badges */
        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
        }
        
        /* Forms */
        .form-control {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0.625rem 0.75rem;
            font-size: 0.9rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(44, 90, 160, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-right: 0;
            }
            
            .admin-header {
                padding: 1rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
        }
        
        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Utilities */
        .text-primary { color: var(--primary-color) !important; }
        .text-success { color: var(--success-color) !important; }
        .text-warning { color: var(--warning-color) !important; }
        .text-danger { color: var(--danger-color) !important; }
        .text-info { color: var(--info-color) !important; }
        
        .bg-primary { background-color: var(--primary-color) !important; }
        .bg-success { background-color: var(--success-color) !important; }
        .bg-warning { background-color: var(--warning-color) !important; }
        .bg-danger { background-color: var(--danger-color) !important; }
        .bg-info { background-color: var(--info-color) !important; }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h3>نظام إدارة العيادة</h3>
            <small>Dr. Abdulnasser Alakhsour</small>
        </div>
        
        <div class="sidebar-menu">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>لوحة التحكم</span>
            </a>
            
            <a href="<?php echo e(route('admin.appointments.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('admin.appointments.*') ? 'active' : ''); ?>">
                <i class="fas fa-calendar-check"></i>
                <span>المواعيد</span>
            </a>
            
            <a href="<?php echo e(route('admin.doctors.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('admin.doctors.*') ? 'active' : ''); ?>">
                <i class="fas fa-user-md"></i>
                <span>الأطباء</span>
            </a>
            
            <a href="<?php echo e(route('admin.medical-records.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('admin.medical-records.*') ? 'active' : ''); ?>">
                <i class="fas fa-file-medical"></i>
                <span>السجلات الطبية</span>
            </a>
            
            <a href="<?php echo e(route('admin.analytics')); ?>" class="sidebar-item <?php echo e(request()->routeIs('admin.analytics') ? 'active' : ''); ?>">
                <i class="fas fa-chart-bar"></i>
                <span>التحليلات</span>
            </a>
            
            <a href="<?php echo e(route('admin.messages.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('admin.messages.*') ? 'active' : ''); ?>">
                <i class="fas fa-envelope"></i>
                <span>الرسائل</span>
            </a>
            
            <a href="<?php echo e(route('admin.settings')); ?>" class="sidebar-item <?php echo e(request()->routeIs('admin.settings') ? 'active' : ''); ?>">
                <i class="fas fa-cog"></i>
                <span>الإعدادات</span>
            </a>
            
            <div class="mt-3 pt-3 border-top border-light border-opacity-25">
                <a href="#" class="sidebar-item" onclick="toggleSidebar()">
                    <i class="fas fa-arrow-right"></i>
                    <span>طي القائمة</span>
                </a>
                
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="sidebar-item w-100 text-start border-0 bg-transparent">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <header class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="header-title"><?php echo $__env->yieldContent('page_title', 'لوحة التحكم'); ?></h1>
                
                <div class="header-actions">
                    <button class="header-btn" onclick="toggleSidebar()" title="طي القائمة">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <a href="<?php echo e(route('home')); ?>" class="header-btn" title="زيارة الموقع">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                    
                    <div class="dropdown">
                        <button class="header-btn" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">الملف الشخصي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <div class="container-fluid py-4">
            <!-- Alerts -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php echo e(session('warning')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php echo e(session('info')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <!-- Page Content -->
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Admin JS -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
        
        // Auto hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);
        });
        
        // Loading states for forms
        document.addEventListener('submit', function(e) {
            if (e.target.matches('form[data-loading]')) {
                const submitBtn = e.target.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner"></span> جاري المعالجة...';
                }
            }
        });
        
        // Confirm deletions
        document.addEventListener('click', function(e) {
            if (e.target.matches('[data-confirm]') || e.target.closest('[data-confirm]')) {
                const element = e.target.matches('[data-confirm]') ? e.target : e.target.closest('[data-confirm]');
                const message = element.getAttribute('data-confirm') || 'هل أنت متأكد من الحذف؟';
                
                if (!confirm(message)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /workspace/final-project/resources/views/admin/layout.blade.php ENDPATH**/ ?>