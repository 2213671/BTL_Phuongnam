<?php if (!empty($category_errors ?? [])): ?>
<div class="alert alert-danger mb-3" role="alert">
    <ul class="mb-0">
        <?php foreach ($category_errors as $err): ?>
            <li><?= htmlspecialchars((string) $err, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<div class="admin-card">
    <div class="card-header-actions">
        <h2 class="card-title">Danh sách danh mục sản phẩm</h2>
        <button onclick="openCreateModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục
        </button>
    </div>

    <!-- Search -->
    <div style="padding: 20px 25px; border-bottom: 1px solid #e0e0e0; background: #f9fafb;">
        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input type="text"
                       id="searchCategory"
                       placeholder="🔍 Tìm kiếm theo ID hoặc tên danh mục..."
                       style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
            </div>
            <button onclick="resetCategoryFilters()"
                    style="padding: 10px 20px; background: #64748b; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">
                <i class="fas fa-redo"></i> Reset
            </button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Số sản phẩm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach($categories as $cat): ?>
                    <tr>
                        <td class="fw-bold"><?= $cat['category_id'] ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($cat['category_name']) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($cat['description'] ?? 'Chưa có mô tả') ?></td>
                        <td>
                            <span class="badge primary"><?= $cat['total_products'] ?? 0 ?> sản phẩm</span>
                        </td>
                        <td>
                            <button onclick='openEditModal(<?= json_encode($cat) ?>)' class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <a href="<?= BASE_URL ?>admin/deleteCategory?id=<?= $cat['category_id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc muốn xóa danh mục này? Các sản phẩm thuộc danh mục sẽ bị ảnh hưởng!')">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (empty($categories)): ?>
                    <tr class="no-results-row">
                        <td colspan="5" class="text-center" style="padding: 40px;">Chưa có danh mục nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $paginationBaseUrl = BASE_URL . 'admin/categories'; require APP_ROOT . '/views/admin/partials/pagination.php'; ?>

<!-- Create/Edit Modal -->
<div id="categoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Thêm danh mục mới</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form id="categoryForm" method="POST">
            <input type="hidden" name="category_id" id="category_id">

            <div class="form-group">
                <label for="category_name">Tên danh mục <span style="color: #ef4444;">*</span></label>
                <input type="text" name="category_name" id="category_name" required placeholder="Nhập tên danh mục">
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" placeholder="Nhập mô tả cho danh mục (tùy chọn)"></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Search functionality
const searchInput = document.getElementById('searchCategory');
const tbody = document.querySelector('tbody');
const categoryRows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.classList.contains('no-results-row'));

function filterCategories() {
    const searchTerm = searchInput.value.toLowerCase();
    let visibleCount = 0;

    categoryRows.forEach(row => {
        const categoryId = row.cells[0]?.textContent.toLowerCase() || '';
        const categoryName = row.cells[1]?.textContent.toLowerCase() || '';
        const description = row.cells[2]?.textContent.toLowerCase() || '';

        const matchesSearch = !searchTerm ||
                              categoryId.includes(searchTerm) ||
                              categoryName.includes(searchTerm) ||
                              description.includes(searchTerm);

        if (matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    let noResultsRow = tbody.querySelector('.no-results-row');

    if (visibleCount === 0) {
        if (!noResultsRow) {
            noResultsRow = document.createElement('tr');
            noResultsRow.className = 'no-results-row';
            noResultsRow.innerHTML = '<td colspan="5" class="text-center" style="padding: 40px;">Không có kết quả phù hợp</td>';
            tbody.appendChild(noResultsRow);
        }
        noResultsRow.style.display = '';
    } else {
        if (noResultsRow) {
            noResultsRow.style.display = 'none';
        }
    }
}

function resetCategoryFilters() {
    searchInput.value = '';
    filterCategories();
}

searchInput.addEventListener('input', filterCategories);

// Modal functions
const modal = document.getElementById('categoryModal');
const modalTitle = document.getElementById('modalTitle');
const categoryForm = document.getElementById('categoryForm');

function openCreateModal() {
    modalTitle.textContent = 'Thêm danh mục mới';
    categoryForm.action = '<?= BASE_URL ?>admin/createCategory';
    document.getElementById('category_id').value = '';
    document.getElementById('category_name').value = '';
    document.getElementById('description').value = '';
    modal.classList.add('active');
}

function openEditModal(category) {
    modalTitle.textContent = 'Sửa danh mục';
    categoryForm.action = '<?= BASE_URL ?>admin/updateCategory';
    document.getElementById('category_id').value = category.category_id;
    document.getElementById('category_name').value = category.category_name;
    document.getElementById('description').value = category.description || '';
    modal.classList.add('active');
}

function closeModal() {
    modal.classList.remove('active');
}

// Close modal when clicking outside
modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        closeModal();
    }
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.classList.contains('active')) {
        closeModal();
    }
});

<?php if (!empty($category_old)): ?>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (!empty($category_old['category_id'])): ?>
    openEditModal(<?= json_encode([
        'category_id' => (int) $category_old['category_id'],
        'category_name' => (string) ($category_old['category_name'] ?? ''),
        'description' => (string) ($category_old['description'] ?? ''),
    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);
    <?php else: ?>
    openCreateModal();
    document.getElementById('category_name').value = <?= json_encode((string) ($category_old['category_name'] ?? ''), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    document.getElementById('description').value = <?= json_encode((string) ($category_old['description'] ?? ''), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    <?php endif ?>
});
<?php endif; ?>
</script>
