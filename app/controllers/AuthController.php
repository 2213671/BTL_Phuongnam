<?php
// controllers/AuthController.php

class AuthController extends Controller
{
    /** Redirect sau đăng nhập: chỉ đường dẫn nội bộ (không open redirect). */
    private function sanitizeLoginRedirect(?string $raw): ?string
    {
        $path = trim((string) $raw);
        if ($path === '' || strlen($path) > 255) {
            return null;
        }
        if (strpos($path, '..') !== false || strpos($path, '//') !== false) {
            return null;
        }
        if (!preg_match('#^[a-zA-Z0-9/_\-]+$#', $path)) {
            return null;
        }
        return $path;
    }

    // Hiển thị form đăng nhập
    public function login()
    {
        // Tránh session hỏng (users_id = 0 từ DB/AUTO_INCREMENT lỗi trước đây): không coi là đã đăng nhập, cho phép đăng nhập lại
        if (isset($_SESSION['users_id']) && (int) $_SESSION['users_id'] <= 0) {
            unset(
                $_SESSION['users_id'],
                $_SESSION['users_username'],
                $_SESSION['user_name'],
                $_SESSION['users_role'],
                $_SESSION['users_email'],
                $_SESSION['users_avatar']
            );
        }

        // 1. Nếu đã đăng nhập thì đá về trang tương ứng (chỉ khi user_id > 0)
        $sid = (int) ($_SESSION['users_id'] ?? 0);
        if ($sid > 0) {
            if (isset($_SESSION['users_role']) && in_array(strtolower((string) $_SESSION['users_role']), ['admin', 'staff'], true)) {
                $this->redirect('admin');
            } else {
                $next = $this->sanitizeLoginRedirect($_GET['redirect'] ?? '');
                $this->redirect($next !== null ? $next : 'home');
            }
        }

        // 2. Xử lý khi bấm nút Đăng nhập (POST)
        if ($this->isPost()) {
            $emailOrPhone = trim($_POST['emailOrPhone'] ?? '');
            $password = $_POST['password'] ?? '';

            $errors = [];
            if ($emailOrPhone === '') $errors[] = 'Vui lòng nhập Email hoặc SĐT.';
            if ($password === '') $errors[] = 'Vui lòng nhập mật khẩu.';

            if (empty($errors)) {
                $userModel = $this->model('User');

                // Tìm user trong DB
                $user = $userModel->findUserByEmailOrPhone($emailOrPhone);

                // Kiểm tra mật khẩu
                if ($user && password_verify($password, $user['password'])) {
                    $acct = strtolower(trim((string) ($user['account_status'] ?? 'active')));
                    if (strtolower((string) ($user['role'] ?? '')) === 'customer' && $acct === 'locked') {
                        $errors[] = 'Tài khoản đã bị khóa. Vui lòng liên hệ nhà sách.';
                    } else {

                    // --- ĐĂNG NHẬP THÀNH CÔNG ---
                    $_SESSION['users_id'] = $user['user_id'];
                    $_SESSION['users_username'] = $user['fullname'] ?? $user['email'] ?? 'Người dùng';
                    $_SESSION['user_name'] = $_SESSION['users_username'];
                    $_SESSION['users_role'] = strtolower(trim((string) ($user['role'] ?? 'customer')));
                    $_SESSION['users_email'] = $user['email'] ?? '';
                    $_SESSION['users_avatar'] = !empty($user['avatar']) ? (string) $user['avatar'] : '';

                    // Bảng productreview.customer_id → customer(user_id): mọi tài khoản có thể cần dòng customer (khách, NV, admin đánh giá/bình luận liên quan)
                    $um = $this->model('UserModel');
                    $um->ensureCustomerMembership((int) $user['user_id']);

                    // Merge guest wishlist (nếu có)
                if (!empty($_SESSION['guest_wishlist'])) {
                    $wm = $this->model('WishlistModel'); // hoặc new WishlistModel() nếu model() ko autoload
                    foreach (array_unique($_SESSION['guest_wishlist']) as $pid) {
                       $pid = (int)$pid;
                       if ($pid <= 0) continue;
                       $wm->add($_SESSION['users_id'], $pid);
                    }
                    unset($_SESSION['guest_wishlist']);
                }
                    // Chuyển hướng đúng (Sửa lỗi Location /)
                    if (in_array(strtolower($user['role']), ['admin', 'staff'], true)) {
                        $this->redirect('admin');
                    } else {
                        $_SESSION['need_sync_cart'] = true;
                        $next = $this->sanitizeLoginRedirect($_POST['redirect'] ?? '');
                        $this->redirect($next !== null ? $next : 'home');
                    }
                    }
                } else {
                    $errors[] = 'Tài khoản hoặc mật khẩu không đúng.';
                }
            }

            $data = [
                'errors' => $errors,
                'old' => ['emailOrPhone' => $emailOrPhone],
                'redirect' => trim($_POST['redirect'] ?? ''),
            ];
            $this->view('auth/login', $data);
        }
        // 3. Hiển thị form (GET)
        else {
            $this->view('auth/login', ['redirect' => trim($_GET['redirect'] ?? '')]);
        }
    }

    // Hiển thị form đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $emailOrPhoneRaw = trim($_POST['emailOrPhone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirmPassword'] ?? '';

            $errors = [];
            if ($fullname === '') $errors[] = 'Vui lòng nhập họ và tên.';
            if ($emailOrPhoneRaw === '') $errors[] = 'Vui lòng nhập Email hoặc Số điện thoại.';
            if (strlen($password) < 6) $errors[] = 'Mật khẩu tối thiểu 6 ký tự.';
            if ($password !== $confirm) $errors[] = 'Mật khẩu xác nhận không khớp.';

            $isEmail = strpos($emailOrPhoneRaw, '@') !== false;
            $lookupKey = $emailOrPhoneRaw;
            if (!$isEmail) {
                $digits = preg_replace('/\D+/', '', $emailOrPhoneRaw);
                if (str_starts_with($digits, '84') && strlen($digits) >= 10) {
                    $digits = '0' . substr($digits, 2);
                }
                $lookupKey = $digits;
                if ($lookupKey === '') {
                    $errors[] = 'Số điện thoại không hợp lệ.';
                } elseif (!preg_match('/^0(3|5|7|8|9)[0-9]{8}$/', $lookupKey)) {
                    $errors[] = 'Số điện thoại không đúng định dạng (10 số, đầu 03/05/07/08/09).';
                }
            } elseif (!filter_var($emailOrPhoneRaw, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ.';
            }

            $userModel = $this->model('User');

            if (empty($errors) && $userModel->findUserByEmailOrPhone($isEmail ? $emailOrPhoneRaw : $lookupKey)) {
                $errors[] = 'Email hoặc Số điện thoại đã được sử dụng.';
            }

            if (empty($errors) && (function_exists('mb_strlen') ? mb_strlen($fullname, 'UTF-8') : strlen($fullname)) > 50) {
                $errors[] = 'Họ và tên không quá 50 ký tự (giới hạn cơ sở dữ liệu).';
            }

            if (empty($errors)) {
                try {
                    $userModel->create([
                        'fullname' => $fullname,
                        'email_or_phone' => $isEmail ? $emailOrPhoneRaw : $lookupKey,
                        'password' => $password,
                    ]);
                } catch (Throwable $e) {
                    $errors[] = 'Có lỗi khi tạo tài khoản, thử lại sau.';
                }

                if (empty($errors)) {
                    $user = $userModel->findUserByEmailOrPhone($isEmail ? $emailOrPhoneRaw : $lookupKey);
                    if ($user && password_verify($password, $user['password'])) {
                        $um = $this->model('UserModel');
                        $um->ensureCustomerMembership((int) $user['user_id']);

                        $_SESSION['users_id'] = $user['user_id'];
                        $_SESSION['users_username'] = $user['fullname'] ?? $user['email'] ?? 'Khách hàng';
                        $_SESSION['user_name'] = $_SESSION['users_username'];
                        $_SESSION['users_role'] = strtolower(trim((string) ($user['role'] ?? 'customer')));
                        $_SESSION['users_email'] = $user['email'] ?? '';

                        if (!empty($_SESSION['guest_wishlist'])) {
                            $wm = $this->model('WishlistModel');
                            foreach (array_unique($_SESSION['guest_wishlist']) as $pid) {
                                $pid = (int) $pid;
                                if ($pid <= 0) {
                                    continue;
                                }
                                $wm->add($_SESSION['users_id'], $pid);
                            }
                            unset($_SESSION['guest_wishlist']);
                        }

                        $_SESSION['need_sync_cart'] = true;
                        $this->redirect('home');
                        return;
                    }
                    $this->redirect('auth/login');
                    return;
                }
            }

            $data = [
                'errors' => $errors,
                'old' => ['fullname' => $fullname, 'emailOrPhone' => $emailOrPhoneRaw],
            ];
            $this->view('auth/register', $data);
            return;
        }

        $this->view('auth/register');
    }

    // Logout
    public function logout()
    {
        if (!session_id()) session_start();
        session_destroy();
        $this->redirect('auth/login');
    }
    public function forgot()
{
    require_once APP_ROOT . '/models/User.php';
    $userModel = new User();
    
    // Nếu form gửi yêu cầu tạo OTP
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'send') {
        $email = trim($_POST['email'] ?? '');
        $errors = [];

        if ($email === '') $errors[] = 'Vui lòng nhập email.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';

        if (!empty($errors)) {
            $this->view('auth/forgot', ['errors' => $errors, 'old' => ['email' => $email]]);
            return;
        }

        $user = $userModel->findByEmail($email);
        if (!$user) {
            // Không tiết lộ tồn tại hay không -> thông báo chung
            $this->view('auth/forgot', ['success' => 'Nếu email tồn tại, bạn sẽ nhận OTP qua email.']);
            return;
        }

        // Tạo OTP 6 chữ số
        $otp = random_int(100000, 999999);
        $expires = date('Y-m-d H:i:s', time() + 15*60); // 15 phút

        $userModel->createPasswordResetOTP((int)$user['id'], (string)$otp, $expires);

        // Gửi email bằng PHPMailer (cần composer require)
        $subject = "Mã OTP đặt lại mật khẩu Nhà sách Phương Nam";
        $body = "Xin chào {$user['fullname']}\n\n";
        $body .= "Mã OTP đặt lại mật khẩu của bạn là: {$otp}\n";
        $body .= "Mã có hiệu lực trong 15 phút.\n\n";
        $body .= "Nếu bạn không yêu cầu, hãy bỏ qua email này.\n\nNhà sách Phương Nam";

        $sent = $this->sendMailPHPMailer($user['email'], $subject, $body);

        if ($sent) {
            // Hiển thị form nhập OTP & mật khẩu mới
            $this->view('auth/forgot', [
                'sent' => true,
                'email' => $user['email'],
                'message' => 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra (hộp thư đến hoặc spam).'
            ]);
            return;
        } else {
            $this->view('auth/forgot', ['errors' => ['Không thể gửi email. Vui lòng thử lại sau.']]);
            return;
        }
    }

    // Nếu form gửi xác thực OTP và mật khẩu mới
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'verify') {
        $email = trim($_POST['email'] ?? '');
        $otp = trim($_POST['otp'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirmPassword'] ?? '';
        $errors = [];

        if ($email === '' || $otp === '') $errors[] = 'Vui lòng nhập email và mã OTP.';
        if (strlen($password) < 6) $errors[] = 'Mật khẩu tối thiểu 6 ký tự.';
        if ($password !== $confirm) $errors[] = 'Mật khẩu xác nhận không khớp.';

        if (!empty($errors)) {
            $this->view('auth/forgot', ['errors' => $errors, 'email' => $email]);
            return;
        }

        $record = $userModel->findResetByOtp($email, $otp);
        if (!$record) {
            $this->view('auth/forgot', ['errors' => ['OTP không hợp lệ hoặc đã hết hạn.'], 'email' => $email]);
            return;
        }

        // cập nhật mật khẩu
        $userModel->updatePassword((int)$record['user_id'], $password);
        // đánh dấu otp đã dùng
        $userModel->useResetOtp($otp, (int)$record['user_id']);

        // tự động login (tuỳ bạn)
        $_SESSION['user'] = ['id' => $record['user_id'], 'email' => $record['email'], 'name' => $record['email']];

        // redirect về trang account hoặc login
        header('Location: ' . (defined('BASE_URL') ? BASE_URL . 'account' : '/account'));
        exit;
    }

    // GET: hiển thị form nhập email
    $this->view('auth/forgot');
}

/**
 * Gửi mail qua PHPMailer
 */
private function sendMailPHPMailer($toEmail, $subject, $body)
{
    // load config
    $cfgPath = APP_ROOT . '/config/config.php';
    $cfg = file_exists($cfgPath) ? include $cfgPath : [];
    $smtp = $cfg['smtp'] ?? null;

    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        // nếu chưa cài PHPMailer, fallback to mail()
        $headers = "From: " . ($smtp['from_email'] ?? 'no-reply@yourdomain.com') . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        return @mail($toEmail, $subject, $body, $headers);
    }

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $smtp['host'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $smtp['user'] ?? '';
        $mail->Password = $smtp['pass'] ?? '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtp['port'] ?? 587;

        $fromEmail = $smtp['from_email'] ?? $smtp['user'] ?? 'no-reply@yourdomain.com';
        $fromName = $smtp['from_name'] ?? 'Nhà sách Phương Nam';

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        // bạn có thể log $e->getMessage()
        return false;
    }
}
}
