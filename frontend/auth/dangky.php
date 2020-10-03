<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>Form dang ky</h1>

    <form name="frmDangNhap" id="frmDangNhap" method="POST" action="">
        <!-- <input type="hidden" name="token" value="AABBZZ@@" /> -->
        Tên tài khoản: <input type="text" name="username" id="username"  /><br />
        Mật khẩu: <input type="text" name="password" id="password"  /><br />
        Họ tên: <input type="text" name="full_name" id="full_name"  /><br />
        
        Tùy chọn khóa học:<br />
        <input type="checkbox" name="chkKhoaHoc[]" id="chkKhoaHoc-1" value="1" />Học online<br />
        <input type="checkbox" name="chkKhoaHoc[]" id="chkKhoaHoc-2" value="2" />Học tập trung<br />

        Giới tính: <br />
        <input type="radio" name="rdGioiTinh" id="rdGioiTinh-1" value="0" />Nam<br />
        <input type="radio" name="rdGioiTinh" id="rdGioiTinh-2" value="1" />Nữ<br />


        <!-- <input type="submit" name="btnDangKy" id="btnDangKy" value="Đăng ký" /> -->
        <button name="btnDangKy" id="btnDangKy">
            Font Awesome ... Đăng ký
        </button>
    </form>

    <div id="ketqua" style="border: 1px solid red;">
    <?php
    if(isset($_POST['btnDangKy'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $full_name = $_POST['full_name'];
        
        
        // Xử lý checkbox
        // Khai báo giá trị mặc định là mảng (array) rỗng
        $tuychonkhoahoc = []; 
        if( isset($_POST['chkKhoaHoc']) ) {
            $tuychonkhoahoc = $_POST['chkKhoaHoc'];
        }
        //[1, 2,3, 6, 7] => '1,2,3,6,7'

        // Xử lý radio
        // Khai báo giá trị mặc định là rỗng
        $gioitinh = null;
        if( isset($_POST['rdGioiTinh']) ) {
            $gioitinh = $_POST['rdGioiTinh'];
        }
        // var_dump($gioitinh);
        // die;


        echo '<ul>';
        echo "<li>Username là: {$username}</li>";
        echo "<li>password là: {$password}</li>";
        echo "<li>full_name là: {$full_name}</li>";

        // Xử lý khi in (render) HTML
        if( !empty($tuychonkhoahoc) ) {
            $chuoituychon = implode(',', $tuychonkhoahoc);
            echo "<li>tùy chọn là: {$chuoituychon}</li>";
        }

        // Xử lý khi in (render) HTML
        echo "<li>giới tính là: {$gioitinh}</li>";

        echo '</ul>';
    }
    ?>
    </div>
</body>
</html>