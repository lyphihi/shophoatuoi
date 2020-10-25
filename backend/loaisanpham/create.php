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
            <!-- day la noi dung -->
            <?php 
                // Truy vấn database
                // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
                include_once(__DIR__ . '/../../dbconnect.php');
                /* --- 
                --- 2.Truy vấn dữ liệu Loại sản phẩm 
                --- 
                */
                // Chuẩn bị câu truy vấn Loại sản phẩm
                $sqlLoaiSanPham = "select * from `loaisanpham`";
                // Thực thi câu truy vấn SQL để lấy về dữ liệu
                $resultLoaiSanPham = mysqli_query($conn, $sqlLoaiSanPham);
                $dataLoaiSanPham = [];
                while ($rowLoaiSanPham = mysqli_fetch_array($resultLoaiSanPham, MYSQLI_ASSOC)) {
                    $dataLoaiSanPham[] = array(
                        'lsp_ma' => $rowLoaiSanPham['lsp_ma'],
                        'lsp_ten' => $rowLoaiSanPham['lsp_ten'],
                        'lsp_mota' => $rowLoaiSanPham['lsp_mota'],
                    );
                }
                /* --- End Truy vấn dữ liệu Loại sản phẩm --- */
            ?>
            <h2>Thêm mới loại sản phẩm</h2>
                <form name="frmloaisanpham" id="frmloaisanpham" method="post" action="">
                    <div class="form-group">
                        <label for="lsp_ten">Loại sản phẩm</label>
                        <input type="text" class="form-control" id="lsp_ten" name="lsp_ten" placeholder="Tên Loại Sản phẩm" value="">
                    </div>
                    <div class="form-group">
                        <label for="lsp_mota">Mô tả loại sản phẩm</label>
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
                    // Câu lệnh INSERT
                    $sql = "INSERT INTO `loaisanpham` (lsp_ten, lsp_mota) VALUES ('$lsp_ten', '$lsp_mota');";
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