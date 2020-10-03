<?php
// Hiển thị tất cả lỗi trong PHP
// Chỉ nên hiển thị lỗi khi đang trong môi trường Phát triển (Development)
// Không nên hiển thị lỗi trên môi trường Triển khai (Production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load các thư viện (packages) do Composer quản lý vào chương trình
require_once __DIR__ . '/../../vendor/autoload.php';

// Sử dụng thư viện PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// hàm `session_id()` sẽ trả về giá trị SESSION_ID (tên file session do Web Server tự động tạo)
// - Nếu trả về Rỗng hoặc NULL => chưa có file Session tồn tại
if (session_id() === '') {
    // Yêu cầu Web Server tạo file Session để lưu trữ giá trị tương ứng với CLIENT (Web Browser đang gởi Request)
    session_start();
}

// Đã người dùng chưa đăng nhập -> hiển thị thông báo yêu cầu người dùng đăng nhập
if (!isset($_SESSION['kh_tendangnhap_logged']) || empty($_SESSION['kh_tendangnhap_logged'])) {
    echo 'Vui lòng Đăng nhập trước khi Thanh toán! <a href="/shophoatuoi/frontend/auth/dangnhap.php">Click vào đây để đến trang Đăng nhập</a>';
    die;
} else {
    // Nếu giỏ hàng trong session rỗng, return
    if (!isset($_SESSION['giohangdata']) || empty($_SESSION['giohangdata'])) {
        echo 'Giỏ hàng rỗng. Vui lòng chọn Sản phẩm trước khi Thanh toán!';
        die;
    }

    // Nếu đã đăng nhập, tạo Đơn hàng
    // Truy vấn database
    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once(__DIR__ . '/../../dbconnect.php');

    /* --- 
    --- 2.Truy vấn dữ liệu Khách hàng 
    --- Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
    --- 
    */
    $kh_tendangnhap = $_SESSION['kh_tendangnhap_logged'];
    // var_dump($kh_tendangnhap);die;
    $sqlSelectKhachHang = <<<EOT
        SELECT *
        FROM `khachhang` kh
        WHERE kh.kh_tendangnhap = '$kh_tendangnhap'
EOT;
    // var_dump($sqlSelectKhachHang);die;

    // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record 
    $resultSelectKhachHang = mysqli_query($conn, $sqlSelectKhachHang);

    // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
    // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
    // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
    $khachhangRow;
    while ($row = mysqli_fetch_array($resultSelectKhachHang, MYSQLI_ASSOC)) {
        $khachhangRow = array(
            'kh_tendangnhap' => $row['kh_tendangnhap'],
            'kh_ten' => $row['kh_ten'],
            'kh_email' => $row['kh_email'],
            'kh_diachi' => $row['kh_diachi'],
        );
    }
    /* --- End Truy vấn dữ liệu Khách hàng --- */

    // Thông tin đơn hàng
    $dh_ngaylap = date('Y-m-d'); // Lấy ngày hiện tại theo định dạng yyyy-mm-dd
    $dh_ngaygiao = date('Y-m-d');
    $dh_noigiao = '';
    $dh_trangthaithanhtoan = 0; // Mặc định là 0 chưa thanh toán
    $httt_ma = 1; // Mặc định là 1

    // 2. Thực hiện câu lệnh Tạo mới (INSERT) Đơn hàng
    // Câu lệnh INSERT
    $sqlInsertDonHang = <<<EOT
    INSERT INTO `dondathang` (`dh_ngaylap`, `dh_ngaygiao`, `dh_noigiao`, `dh_trangthaithanhtoan`, `httt_ma`, `kh_tendangnhap`) 
        VALUES ('$dh_ngaylap', '$dh_ngaygiao', N'$dh_noigiao', '$dh_trangthaithanhtoan', '$httt_ma', '$kh_tendangnhap');
EOT;
    // print_r($sqlInsertDonHang); die;

    // Thực thi INSERT Đơn hàng
    mysqli_query($conn, $sqlInsertDonHang);

    // 3. Lấy ID Đơn hàng mới nhất vừa được thêm vào database
    // Do ID là tự động tăng (PRIMARY KEY và AUTO INCREMENT), nên chúng ta không biết được ID đă tăng đến số bao nhiêu?
    // Cần phải sử dụng biến `$conn->insert_id` để lấy về ID mới nhất
    // Nếu thực thi câu lệnh INSERT thành công thì cần lấy ID mới nhất của Đơn hàng để làm khóa ngoại trong Chi tiết đơn hàng
    $dh_ma = $conn->insert_id;
    // var_dump($dh_ma);die;

    // Thông tin các dòng chi tiết đơn hàng
    $giohangdata = $_SESSION['giohangdata'];

    // 4. Duyệt vòng lặp qua mảng các dòng Sản phẩm của chi tiết đơn hàng được gởi đến qua request POST
    foreach ($giohangdata as $item) {
        // 4.1. Chuẩn bị dữ liệu cho câu lệnh INSERT vào table `sanpham_dondathang`
        $sp_ma = $item['sp_ma'];
        $sp_dh_soluong = $item['soluong'];
        $sp_dh_dongia = $item['gia'];

        // 4.2. Câu lệnh INSERT
        $sqlInsertSanPhamDonDatHang = <<<EOT
        INSERT INTO `sanpham_dondathang` (`sp_ma`, `dh_ma`, `sp_dh_soluong`, `sp_dh_dongia`) 
            VALUES ($sp_ma, $dh_ma, $sp_dh_soluong, $sp_dh_dongia);
EOT;

        // 4.3. Thực thi INSERT
        mysqli_query($conn, $sqlInsertSanPhamDonDatHang);
    }


//     5. Thực thi hoàn tất, điều hướng về trang Danh sách
//     Hủy dữ liệu giỏ hàng trong session
    unset($_SESSION['giohangdata']);
    echo 'Đặt hàng thành công. <a href="/shophoatuoi/frontend/">Bấm vào đây để quay về trang chủ</a>';
}
