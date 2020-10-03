<?php
if (session_id() === '') {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../layouts/styles.php'); ?>

</head>
<body>
    <!-- header -->
    <?php 
    include_once(__DIR__ . '/../layouts/partials/header.php');
    ?>
    <!-- end header -->
<form name="frmdangky" id="frmdangky" method="post" action="">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mx-4">
                    <div class="card-body p-4">
                        <h1>Đăng ký</h1>
                        <p class="text-muted">Tạo tài khoản</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" placeholder="Tên tải khoản" name="kh_tendangnhap" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="password" placeholder="Mật khẩu" name="kh_matkhau" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" placeholder="Họ tên" name="kh_ten" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <select name="kh_gioitinh" class="form-control">
                                <option value="0">Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" placeholder="Địa chỉ" name="kh_diachi" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" placeholder="Điện thoại" name="kh_dienthoai" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="email" placeholder="Email" name="kh_email" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" placeholder="Ngày sinh" name="kh_ngaysinh" />
                            <input class="form-control" type="text" placeholder="Tháng sinh" name="kh_thangsinh" />
                            <input class="form-control" type="text" placeholder="Năm sinh" name="kh_namsinh" />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input class="form-control" type="text" placeholder="CMND" name="kh_cmnd" />
                        </div>
                        <button class="btn btn-block btn-success" name="btnDangKy">Tạo tài khoản</button>
                    </div>
                    <div class="card-footer p-4">
                        <div class="row">
                            <div class="col-12">
                                <center>Nếu bạn đã có Tài khoản, xin mời Đăng nhập</center>
                                <a class="btn btn-primary form-control" href="/php/twig/frontend/pages/login.php">Đăng nhập</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh INSERT
if(isset($_POST['btnDangKy']))
{
    // Xử lý đăng ký
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $kh_tendangnhap = $_POST['kh_tendangnhap'];
    $kh_matkhau = sha1($_POST['kh_matkhau']);
    $kh_ten = $_POST['kh_ten'];
    $kh_gioitinh = $_POST['kh_gioitinh'];
    $kh_diachi = $_POST['kh_diachi'];
    $kh_diachi = $_POST['kh_diachi'];
    $kh_dienthoai = $_POST['kh_dienthoai'];
    $kh_email = $_POST['kh_email'];
    $kh_ngaysinh = $_POST['kh_ngaysinh'];
    $kh_thangsinh = $_POST['kh_thangsinh'];
    $kh_namsinh = $_POST['kh_namsinh'];
    $kh_cmnd = $_POST['kh_cmnd'];
    $kh_makichhoat = sha1(time());
    $kh_trangthai = 0; 
    $kh_quantri = 0; 
    // Câu lệnh INSERT
    $sql = "INSERT INTO khachhang(kh_tendangnhap, kh_matkhau, kh_ten, kh_gioitinh, kh_diachi, kh_dienthoai, kh_email, kh_ngaysinh, kh_thangsinh, kh_namsinh, kh_cmnd, kh_makichhoat, kh_trangthai, kh_quantri) VALUES ('$kh_tendangnhap', '$kh_matkhau', '$kh_ten', $kh_gioitinh, '$kh_diachi', '$kh_dienthoai', '$kh_email', $kh_ngaysinh, $kh_thangsinh, '$kh_namsinh', '$kh_cmnd', '$kh_makichhoat', $kh_trangthai, $kh_quantri)";

    // Thực thi SELECT
    $result = mysqli_query($conn, $sql);
    
     // Đóng kết nối
    mysqli_close($conn);
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"> Đã đăng kí thành công </div>';
}
        
?>
      
     <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
     <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>

<!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
</body>
</html>