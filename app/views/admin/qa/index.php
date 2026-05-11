<div class="page-header d-print-none mb-3">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Danh sách Hỏi/Đáp (Q&A)
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= BASE_URL ?>admin/createQa" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="fa-solid fa-plus"></i> &nbsp;
                        Thêm câu hỏi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>Câu hỏi</th>
                            <th>Trả lời</th>
                            <th>Danh mục</th>
                            <th class="w-1">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($qaList)): ?>
                            <?php foreach($qaList as $qa): ?>
                            <tr>
                                <td class="text-wrap" style="max-width: 300px;">
                                    <div class="font-weight-medium"><?= htmlspecialchars($qa['question']) ?></div>
                                </td>
                                <td class="text-muted text-wrap" style="max-width: 400px;">
                                    <?= htmlspecialchars($qa['answer']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-blue-lt"><?= htmlspecialchars($qa['category']) ?></span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>admin/deleteQa?id=<?= $qa['id'] ?>" 
                                       class="btn btn-danger btn-sm btn-icon" 
                                       onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                                       title="Xóa">
                                       <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">Chưa có dữ liệu nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">
             <a href="<?= BASE_URL ?>admin" class="btn btn-secondary">Quay lại Dashboard</a>
        </div>
        <?php $paginationBaseUrl = BASE_URL . 'admin/qa'; require APP_ROOT . '/views/admin/partials/pagination.php'; ?>
    </div>
</div>
