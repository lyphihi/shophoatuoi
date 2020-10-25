<!-- Nhúng file cấu hình để xác định được Tên và Tiêu đề của trang hiện tại người dùng đang truy cập -->
<?php// include_once(__DIR__ . '/../layouts/config.php'); ?> 

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shophoatuoi</title>
    <?php 
    include_once(__DIR__ . '/../layouts/styles.php');
    ?>
    <link href="/shophoatuoi/assets/vendor/DataTables/datatables.css" type="text/css" rel="stylesheet" />
    <link href="/shophoatuoi/assets/vendor/DataTables/Buttons-1.6.3/css/buttons.bootstrap4.min.css" type="text/css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php'); ?>
    <!-- end header -->

    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include_once(__DIR__ . '/../layouts/partials/sidebar.php'); ?>
            <!-- end sidebar -->

            <main role="main" class="col-md-10 ml-sm-auto px-4 mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Hiệu chỉnh</h1>
                </div>

                <!-- Block content -->
                <?php 
                include_once(__DIR__ . '/../../dbconnect.php');
                $sqlChude = "select * from `chudehoa`";
                $resultChude = mysqli_query($conn, $sqlChude);
                $dataChude = [];
                while ($rowChude = mysqli_fetch_array($resultChude, MYSQLI_ASSOC)) {
                    $dataChude[] = array(
                        'cd_ten' => $rowChude['cd_ten'],
                    );
                }
                $cd_ma = $_GET['cd_ma'];
                $sqlSelect = "SELECT * FROM `chudehoa` WHERE cd_ma=$cd_ma;";
                $resultSelect = mysqli_query($conn, $sqlSelect);
                $ChudeRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC);
                ?>
                <form name="frmChude" id="frmChude" method="post" action="">
                    <div class="form-group">
                        <label for="cd_ma">Mã loại hoa</label>
                        <input type="text" class="form-control" id="cd_ma" name="cd_ma" placeholder="Mã Chủ đề" readonly value="<?= $ChudeRow['cd_ma'] ?>">
                        <small id="cd_maHelp" class="form-text text-muted">Mã Loại Sản phẩm không được hiệu chỉnh.</small>
                    </div>
                    <div class="form-group">
                        <label for="cd_ten">Tên Loại sản phẩm</label>
                        <input type="text" class="form-control" id="cd_ten" name="cd_ten" placeholder="Tên Loại Sản phẩm" value="<?= $ChudeRow['cd_ten'] ?>">
                    </div>
                    <button class="btn btn-primary" name="btnSave">Lưu dữ liệu</button>
                </form>

                <?php
                // 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
                if (isset($_POST['btnSave'])) {
                    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
                    $cd_ten = $_POST['cd_ten'];
                    $sql = "UPDATE `chudehoa` SET cd_ten='$cd_ten' WHERE cd_ma=$cd_ma";
                    mysqli_query($conn, $sql);
                    // Đóng kết nối
                    mysqli_close($conn);
                    echo "<script>location.href = 'index.php';</script>";
                }
                ?>
                <!-- End block content -->
            </main>
        </div>
    </div>

    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
</body>

</html>