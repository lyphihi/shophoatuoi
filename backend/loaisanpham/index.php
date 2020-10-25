<!DOCTYPE html>
<html lang="en">
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

            <h2>Danh sách loại sản phẩm</h2>
            <?php
            include_once(__DIR__ . '/../../dbconnect.php');
            $sql = <<<LPH
            SELECT lsp.*
            FROM `loaisanpham` lsp
LPH;
            $result = mysqli_query($conn, $sql);
            $data = [];
            while ($rowLoaiSanPham = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = array(
                    'lsp_ma' => $rowLoaiSanPham['lsp_ma'],
                    'lsp_ten' => $rowLoaiSanPham['lsp_ten'],
                    'lsp_mota' => $rowLoaiSanPham['lsp_mota'],
                );
            }
            ?>
            <a href="create.php" class="btn btn-primary">Thêm mới</a>
            <table id="tbDanhsach" class="table table-bordered table-hover mt-2">
            <thead>
            <tr>
                <td>Mã loại sản phẩm</td>
                <td>Tên loại sản phẩm</td>
                <td>Mô tả</td>
                <td>Hành động</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $sp): ?>
            <tr>
            <td> <?php echo $sp['lsp_ma']; ?> </td>
            <td> <?php echo $sp['lsp_ten']; ?> </td>
            <td> <?php echo $sp['lsp_mota']; ?> </td>
            <td>  
            <a href="edit.php?lsp_ma=<?php echo $sp['lsp_ma']; ?>" class="btn btn-success">Sua</a>
            <a href="delete.php?lsp_ma=<?php echo $sp['lsp_ma']; ?>" class="btn btn-danger">Xóa</a>
            </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table>

            </div>
        </div>
    </div>


    <!-- footer -->
    <?php 
    include_once(__DIR__ . '/../layouts/partials/footer.php');
    ?>
    <!-- end footer -->

    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
    <script src="/shophoatuoi/assets/vendor/DataTables/datatables.min.js"></script>
    <script src="/shophoatuoi/assets/vendor/DataTables/Buttons-1.6.3/js/buttons.bootstrap4.min.js"></script>
    <script src="/shophoatuoi/assets/vendor/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="/shophoatuoi/assets/vendor/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>

    <script src="/shophoatuoi/assets/vendor/sweetalert/sweetalert.min.js"></script>
    <script>
    $(document).ready(function() {
        // xử lý table danh sách
        $('#tbDanhsach').DataTable({
            dom: 'Blfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
        // Cảnh báo khi xóa
        // 1. Đăng ký sự kiện click cho các phần tử (element) đang áp dụng class .btnDelete
        $('.btnDelete').click(function() {
            // Click hanlder
            // Hiện cảnh báo khi bấm nút xóa
            swal({
                title: "Bạn có chắc chắn muốn xóa?",
                text: "Một khi đã xóa, không thể phục hồi....",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                debugger;
                if (willDelete) { // Nếu đồng ý xóa
                    var url = "delete.php?lsp_ma=" + lsp_ma;  
                    location.href = url;
                } else {
                    swal("Cẩn thận hơn nhé!");
                }
            });
           
        });
    });
    </script>
</body>
</html>