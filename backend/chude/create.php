<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shophoatuoi</title>
    <?php 
    include_once(__DIR__ . '/../layouts/styles.php');
    ?>
</head>
<body>
    
    <!-- header -->
    <?php 
    include_once(__DIR__ . '/../layouts/partials/header.php');
    ?>
    <!-- end header -->

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- sidebar -->
                <?php 
                include_once(__DIR__ . '/../layouts/partials/sidebar.php');
                ?>
                <!-- end sidebar -->
            </div>
            <div class="col-md-8" >
            <?php 
                include_once(__DIR__ . '/../../dbconnect.php');
                $sqlChude = "select * from `chudehoa`";
                $resultChude = mysqli_query($conn, $sqlChude);
                $dataChude = [];
                while ($rowChude = mysqli_fetch_array($resultChude, MYSQLI_ASSOC)) {
                    $dataLoaiSanPham[] = array(
                        'cd_ma' => $rowChude['cd_ma'],
                        'cd_ten' => $rowChude['cd_ten'],
                    );
                }
            ?>
            <h2>Thêm mới Chủ đề</h2>
                <form name="frmchude" id="frmchude" method="post" action="">
                    <div class="form-group">
                        <label for="cd_ten">Chủ đề</label>
                        <input type="text" class="form-control" id="cd_ten" name="cd_ten" placeholder="Tên Chủ đề" value="">
                    </div>
                    <button class="btn btn-primary" name="btnSave">Lưu dữ liệu</button>
                </form>

                <?php
                // 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
                if (isset($_POST['btnSave'])) {
                    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
                    $cd_ten = $_POST['cd_ten'];
                    // Câu lệnh INSERT
                    $sql = "INSERT INTO `chudehoa` (cd_ten) VALUES ('$cd_ten');";
                    // Thực thi INSERT
                    mysqli_query($conn, $sql);
                    // Đóng kết nối
                    mysqli_close($conn);
                    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
                    echo "<script>location.href = 'index.php';</script>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>