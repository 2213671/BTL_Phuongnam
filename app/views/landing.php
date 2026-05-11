<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .landing-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .landing-icon {
            font-size: 5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="landing-card p-5 text-center">
                    
                    <?php if(isset($is_404) && $is_404): ?>
                        <!-- Trang 404 -->
                        <i class="fas fa-exclamation-triangle landing-icon text-warning"></i>
                        <h1 class="mt-4 mb-3">Oops! Không tìm thấy trang</h1>
                        <p class="text-muted mb-4">URL bạn nhập không tồn tại hoặc đã bị thay đổi.</p>
                    <?php else: ?>
                        <!-- Trang Landing -->
                        <i class="fas fa-book-open landing-icon"></i>
                        <h1 class="mt-4 mb-3">Chào mừng đến với <?= APP_NAME ?></h1>
                        <p class="text-muted mb-4">Hệ thống quản lý sách trực tuyến</p>
                    <?php endif; ?>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="<?= BASE_URL ?>home" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                        <a href="<?= BASE_URL ?>product" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-book"></i> Sản phẩm
                        </a>
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle"></i> 
                            Mọi truy cập đều phải qua <code>public/index.php</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
