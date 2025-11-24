<?php $__env->startSection('title', 'إدارة الرسائل'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة الرسائل</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" id="markAllRead">
                <i class="fas fa-check-double"></i> تعليم الكل كمقروء
            </button>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي الرسائل
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($messages->total()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                رسائل مقروءة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($messages->where('is_read', true)->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                رسائل غير مقروءة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($messages->where('is_read', false)->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
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
            <form method="GET" action="<?php echo e(route('admin.messages.index')); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label for="is_read" class="form-label">حالة القراءة</label>
                        <select name="is_read" id="is_read" class="form-control">
                            <option value="">جميع الرسائل</option>
                            <option value="1" <?php echo e(request('is_read') == '1' ? 'selected' : ''); ?>>مقروءة</option>
                            <option value="0" <?php echo e(request('is_read') == '0' ? 'selected' : ''); ?>>غير مقروءة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="search" class="form-label">البحث</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               placeholder="البحث في الاسم، البريد الإلكتروني، أو الرسالة..." 
                               value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة الرسائل -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">قائمة الرسائل</h6>
        </div>
        <div class="card-body">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($messages->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>الحالة</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>الموضوع</th>
                                <th>تاريخ الإرسال</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e(!$message->is_read ? 'table-warning' : ''); ?>">
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$message->is_read): ?>
                                        <span class="badge bg-danger">جديد</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">مقروء</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td><?php echo e($message->name); ?></td>
                                <td><?php echo e($message->email); ?></td>
                                <td><?php echo e($message->phone ?? 'غير محدد'); ?></td>
                                <td><?php echo e(Str::limit($message->message, 50)); ?></td>
                                <td><?php echo e($message->created_at->format('Y-m-d H:i')); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" 
                                                onclick="viewMessage(<?php echo e($message->id); ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$message->is_read): ?>
                                        <button type="button" class="btn btn-sm btn-success" 
                                                onclick="markAsRead(<?php echo e($message->id); ?>)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="deleteMessage(<?php echo e($message->id); ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- ترقيم الصفحات -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        عرض <?php echo e($messages->firstItem()); ?> إلى <?php echo e($messages->lastItem()); ?> من <?php echo e($messages->total()); ?> نتيجة
                    </div>
                    <div>
                        <?php echo e($messages->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-envelope fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">لا توجد رسائل</h5>
                    <p class="text-gray-500">لم يتم العثور على أي رسائل تطابق المعايير المحددة.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<!-- نافذة عرض الرسالة -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل الرسالة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="messageContent">
                <!-- محتوى الرسالة سيتم تحميله هنا -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function viewMessage(id) {
    // سيتم تنفيذ هذا لاحقاً
    console.log('View message:', id);
}

function markAsRead(id) {
    fetch(`/admin/messages/${id}/read`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteMessage(id) {
    if (confirm('هل أنت متأكد من حذف هذه الرسالة؟')) {
        fetch(`/admin/messages/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

document.getElementById('markAllRead').addEventListener('click', function() {
    if (confirm('هل تريد تعليم جميع الرسائل كمقروءة؟')) {
        // سيتم تنفيذ هذا لاحقاً
        console.log('Mark all as read');
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/final-project/resources/views/admin/messages/index.blade.php ENDPATH**/ ?>