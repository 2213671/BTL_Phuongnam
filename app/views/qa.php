<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<div class="qa-page">

<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hỏi/Đáp</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <div class="qa-hero">
        <div class="container">
            <h1 class="h2 mb-3"><i class="fas fa-question-circle" aria-hidden="true"></i> Câu hỏi thường gặp</h1>
            <p>Tìm câu trả lời nhanh chóng cho các thắc mắc của bạn</p>
            <div class="search-qa">
                <input type="text" id="searchInput" placeholder="Tìm kiếm câu hỏi..." autocomplete="off">
                <button type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="category-tabs">
                <a href="?category=all" class="category-tab <?php echo ($selectedCategory ?? 'all') === 'all' ? 'active' : ''; ?>" data-category="all">
                    <i class="fas fa-th"></i> Tất cả
                </a>
                <a href="?category=order" class="category-tab <?php echo ($selectedCategory ?? 'all') === 'order' ? 'active' : ''; ?>" data-category="order">
                    <i class="fas fa-shopping-cart"></i> Đặt hàng
                </a>
                <a href="?category=payment" class="category-tab <?php echo ($selectedCategory ?? 'all') === 'payment' ? 'active' : ''; ?>" data-category="payment">
                    <i class="fas fa-credit-card"></i> Thanh toán
                </a>
                <a href="?category=shipping" class="category-tab <?php echo ($selectedCategory ?? 'all') === 'shipping' ? 'active' : ''; ?>" data-category="shipping">
                    <i class="fas fa-truck"></i> Vận chuyển
                </a>
                <a href="?category=return" class="category-tab <?php echo ($selectedCategory ?? 'all') === 'return' ? 'active' : ''; ?>" data-category="return">
                    <i class="fas fa-undo"></i> Đổi trả
                </a>
            </div>

            <div id="qa-container">

                <div class="qa-group" data-category="order">
                    <h2 class="page-title">Về đặt hàng</h2>
                    <div class="accordion" id="orderAccordion">
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#order1">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Làm thế nào để đặt hàng trên website?
                                </button>
                            </div>
                            <div id="order1" class="accordion-collapse collapse show" data-bs-parent="#orderAccordion">
                                <div class="accordion-body">
                                    <strong>Các bước đặt hàng:</strong>
                                    <ol>
                                        <li>Tìm kiếm sản phẩm bạn muốn mua</li>
                                        <li>Nhấn nút "Thêm vào giỏ hàng"</li>
                                        <li>Vào giỏ hàng và kiểm tra lại đơn hàng</li>
                                        <li>Nhấn "Thanh toán" và điền thông tin giao hàng</li>
                                        <li>Chọn phương thức thanh toán và hoàn tất đơn hàng</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order2">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Tôi có thể đặt hàng qua điện thoại không?
                                </button>
                            </div>
                            <div id="order2" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                                <div class="accordion-body">
                                    Có, bạn có thể gọi đến hotline <strong>1900-6656</strong> để được hỗ trợ đặt hàng.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order3">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Tôi có thể hủy đơn hàng không?
                                </button>
                            </div>
                            <div id="order3" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                                <div class="accordion-body">
                                    Bạn có thể hủy đơn hàng trước khi đơn hàng được xác nhận và chuẩn bị giao.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="qa-group" data-category="payment">
                    <h2 class="page-title mt-4">Về thanh toán</h2>
                    <div class="accordion" id="paymentAccordion">
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment1">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Có những phương thức thanh toán nào?
                                </button>
                            </div>
                            <div id="payment1" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <strong>Chúng tôi hỗ trợ các phương thức thanh toán sau:</strong>
                                    <ul>
                                        <li>COD, Chuyển khoản, Thẻ ATM/Visa, Ví điện tử...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment2">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Thanh toán online có an toàn không?
                                </button>
                            </div>
                            <div id="payment2" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    Hoàn toàn an toàn với bảo mật SSL 256-bit.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="qa-group" data-category="shipping">
                    <h2 class="page-title mt-4">Về vận chuyển</h2>
                    <div class="accordion" id="shippingAccordion">
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping1">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Thời gian giao hàng là bao lâu?
                                </button>
                            </div>
                            <div id="shipping1" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    Nội thành 1-2 ngày, ngoại thành 2-4 ngày.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping2">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Phí vận chuyển là bao nhiêu?
                                </button>
                            </div>
                            <div id="shipping2" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    Miễn phí cho đơn hàng trên 150k.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="qa-group" data-category="return">
                    <h2 class="page-title mt-4">Về đổi trả hàng</h2>
                    <div class="accordion" id="returnAccordion">
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return1">
                                    <i class="fas fa-question-circle me-2" aria-hidden="true"></i> Chính sách đổi trả như thế nào?
                                </button>
                            </div>
                            <div id="return1" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                                <div class="accordion-body">
                                    Đổi trả trong vòng 7 ngày nếu lỗi nhà sản xuất.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="no-results" class="text-center mt-5 hidden" style="display:none;">
                    <i class="fas fa-search fa-3x text-muted mb-3" aria-hidden="true"></i>
                    <p class="qa-no-results-title fw-semibold fs-5">Không tìm thấy kết quả phù hợp</p>
                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="popular-questions">
                <p class="popular-questions-heading"><i class="fas fa-fire" aria-hidden="true"></i> Câu hỏi phổ biến</p>
                <ul>
                    <li><a href="#order1" onclick="triggerFilter('order'); return false;"><i class="fas fa-chevron-right"></i> Cách đặt hàng</a></li>
                    <li><a href="#payment1" onclick="triggerFilter('payment'); return false;"><i class="fas fa-chevron-right"></i> Phương thức thanh toán</a></li>
                    <li><a href="#return1" onclick="triggerFilter('return'); return false;"><i class="fas fa-chevron-right"></i> Chính sách đổi trả</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="contact-box">
    </div>
</div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.category-tab');
        const groups = document.querySelectorAll('.qa-group');
        const searchInput = document.getElementById('searchInput');
        const selectedCategory = '<?php echo $selectedCategory ?? 'all'; ?>';

        function filterQA(category) {
            tabs.forEach(t => {
                if (t.getAttribute('data-category') === category) {
                    t.classList.add('active');
                } else {
                    t.classList.remove('active');
                }
            });

            groups.forEach(group => {
                const groupCategory = group.getAttribute('data-category');

                if (category === 'all' || category === groupCategory) {
                    group.classList.remove('hidden');
                    setTimeout(() => {
                        group.style.opacity = '1';
                        group.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    group.style.opacity = '0';
                    group.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        group.classList.add('hidden');
                    }, 300);
                }
            });
        }

        filterQA(selectedCategory);

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const category = this.getAttribute('data-category');
                filterQA(category);
            });
        });

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const term = this.value.toLowerCase();
                if (term === '') {
                    const activeTab = document.querySelector('.category-tab.active');
                    filterQA(activeTab.getAttribute('data-category'));
                    return;
                }

                groups.forEach(group => group.classList.remove('hidden'));

                const buttons = document.querySelectorAll('.accordion-button');
                buttons.forEach(btn => {
                    const text = btn.textContent.toLowerCase();
                    const item = btn.closest('.accordion-item');
                    if (text.includes(term)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        window.triggerFilter = function(cat) {
            filterQA(cat);
            document.getElementById('qa-container').scrollIntoView({behavior: 'smooth'});
        };
    });
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
