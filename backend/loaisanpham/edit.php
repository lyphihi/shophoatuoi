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
                // Truy vấn database
                // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
                include_once(__DIR__ . '/../../dbconnect.php');
                /* --- 
                --- 2.Truy vấn dữ liệu Loại sản phẩm 
                --- 
                */
                $sqlLoaiSanPham = "select * from `loaisanpham`";
                $resultLoaiSanPham = mysqli_query($conn, $sqlLoaiSanPham);
                $dataLoaiSanPham = [];
                while ($rowLoaiSanPham = mysqli_fetch_array($resultLoaiSanPham, MYSQLI_ASSOC)) {
                    $dataLoaiSanPham[] = array(
                        'lsp_ten' => $rowLoaiSanPham['lsp_ten'],
                        'lsp_mota' => $rowLoaiSanPham['lsp_mota'],
                    );
                }

                $lsp_ma = $_GET['lsp_ma'];
                $sqlSelect = "SELECT * FROM `loaisanpham` WHERE lsp_ma=$lsp_ma;";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
                $resultSelect = mysqli_query($conn, $sqlSelect);
                $loaisanphamRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC);
                /* --- End Truy vấn dữ liệu Loại sản phẩm --- */
                ?>
                <form name="frmloaisanpham" id="frmloaisanpham" method="post" action="">
                    <div class="form-group">
                        <label for="lsp_ma">Mã loại hoa</label>
                        <input type="text" class="form-control" id="lsp_ma" name="lsp_ma" placeholder="Mã Loại Sản phẩm" readonly value="<?= $loaisanphamRow['lsp_ma'] ?>">
                        <small id="lsp_maHelp" class="form-text text-muted">Mã Loại Sản phẩm không được hiệu chỉnh.</small>
                    </div>
                    <div class="form-group">
                        <label for="lsp_ten">Tên Loại sản phẩm</label>
                        <input type="text" class="form-control" id="lsp_ten" name="lsp_ten" placeholder="Tên Loại Sản phẩm" value="<?= $loaisanphamRow['lsp_ten'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="lsp_mota">Mô tả Loại sản phẩm</label>
                        <input type="text" class="form-control" id="lsp_mota" name="lsp_mota" placeholder="Mô tả Loại Sản phẩm" value="">
                    </div>
                    <button class="btn btn-primary" name="btnSave">Lưu dữ liệu</button>
                </form>

                <?php
                // 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
                if (isset($_POST['btnSave'])) {
                    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
                    $lsp_ten = $_POST['lsp_ten'];
                    $lsp_mota = $_POST['lsp_mota'];
                    $sql = "UPDATE `loaisanpham` SET lsp_ten='$lsp_ten', lsp_mota='$lsp_mota' WHERE lsp_ma=$lsp_ma";
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