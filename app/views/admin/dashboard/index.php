<div class="welcome-card">
    <h2>Chào mừng trở lại, <?= $_SESSION['users_username'] ?? 'Admin' ?>!</h2>
    <p>Đây là trang quản trị hệ thống Phương Nam.</p>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon products">
            <i class="fa-solid fa-box"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Tổng sản phẩm</div>
            <div class="stat-value"><?= (int) ($stats['total_products'] ?? 0) ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orders">
            <i class="fa-solid fa-shopping-cart"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Đơn hàng</div>
            <div class="stat-value"><?= (int) ($stats['total_orders'] ?? 0) ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon news">
            <i class="fa-solid fa-newspaper"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Bài viết</div>
            <div class="stat-value"><?= (int) ($stats['total_news'] ?? 0) ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon customers">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Khách hàng</div>
            <div class="stat-value"><?= (int) ($stats['total_customers'] ?? 0) ?></div>
        </div>
    </div>
</div>

<div class="chart-card">
    <h2 class="h6 mb-3 fw-semibold">Doanh thu 6 tháng gần nhất (đơn hoàn thành)</h2>
    <div class="dashboard-chart-wrap">
        <canvas id="revenueChart" aria-label="Biểu đồ doanh thu"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('revenueChart');
    if (!canvas || typeof Chart === 'undefined') return;

    if (window.__pnRevenueChart && typeof window.__pnRevenueChart.destroy === 'function') {
        window.__pnRevenueChart.destroy();
    }

    const revenueLabels = <?= json_encode(array_column($revenueData ?? [], 'month_label'), JSON_UNESCAPED_UNICODE) ?>;
    const revenueValues = <?= json_encode(array_map(fn($item) => (float) ($item['revenue'] ?? 0), $revenueData ?? []), JSON_UNESCAPED_UNICODE) ?>;

    window.__pnRevenueChart = new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Doanh thu (VND)',
                data: revenueValues,
                fill: true,
                borderColor: '#c92127',
                backgroundColor: 'rgba(201, 33, 39, 0.15)',
                tension: 0.35,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 400 },
            plugins: { legend: { display: true } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (v) => new Intl.NumberFormat('vi-VN').format(v) + ' đ'
                    }
                }
            }
        }
    });
});
</script>
