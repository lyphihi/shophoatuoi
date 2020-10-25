<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

            <h2>Danh sach san pham</h2>
            <?php
            include_once(__DIR__ . '/../../dbconnect.php');
            $sql = <<<LPH
            SELECT sp.*
            , lsp.lsp_ten
            , ncc.ncc_ten
            , km.km_ten, km.km_noidung, km.km_tungay, km.km_denngay
            FROM `sanpham` sp
            JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
            JOIN `nhacungcap` ncc ON sp.ncc_ma = ncc.ncc_ma
            LEFT JOIN `khuyenmai` km ON sp.km_ma = km.km_ma
            ORDER BY sp.sp_ma DESC
LPH;
            $result = mysqli_query($conn, $sql);
            $data = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $km_tomtat = '';
                if (!empty($row['km_ten'])) {
                    // Sử dụng hàm sprintf() để chuẩn bị mẫu câu với các giá trị truyền vào tương ứng từng vị trí placeholder
                    $km_tomtat = sprintf(
                        "Khuyến mãi %s, nội dung: %s, thời gian: %s-%s",
                        $row['km_ten'],
                        $row['km_noidung']
                        // Sử dụng hàm date($format, $timestamp) để chuyển đổi ngày thành định dạng Việt Nam (ngày/tháng/năm)
                        // Do hàm date() nhận vào là đối tượng thời gian, chúng ta cần sử dụng hàm strtotime() 
                        // để chuyển đổi từ chuỗi có định dạng 'yyyy-mm-dd' trong MYSQL thành đối tượng ngày tháng
                        //date('d/m/Y', strtotime($row['km_tungay'])),    //vd: '2019-04-25'
                        //date('d/m/Y', strtotime($row['km_denngay']))
                    );  //vd: '2019-05-10'
                }
                $data[] = array(
                'sp_ma' => $row['sp_ma'],
                'sp_ten' => $row['sp_ten'],
                'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ',
                'sp_giacu' => number_format($row['sp_giacu'], 2, ".", ",") . ' vnđ',
                'lsp_ten' => $row['lsp_ten'],
                'ncc_ten' => $row['ncc_ten'],
                'km_tomtat' => $km_tomtat
                );
            }
            ?>
            <a href="create.php" class="btn btn-primary">Thêm mới</a>
            <table id="tbDanhsach" class="table table-bordered table-hover mt-2">
            <thead>
            <tr>
                <td>Mã sản phẩm</td>
                <td>Tên sản phẩm</td>
                <td>Giá</td>
                <td>Giá cũ</td>
                <td>Tên loại sản phẩm</td>
                <td>Tên nhà sản xuất</td>
                <td>Khuyến mãi</td>
                <td>Hành động</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $sp): ?>
            <tr>
            <td> <?php echo $sp['sp_ma']; ?> </td>
            <td> <?php echo $sp['sp_ten']; ?> </td>
            <td> <?php echo $sp['sp_gia']; ?> </td>
            <td> <?php echo $sp['sp_giacu']; ?> </td>
            <td> <?php echo $sp['lsp_ten']; ?> </td>
            <td> <?php echo $sp['ncc_ten']; ?> </td>
            <td> <?php echo $sp['km_tomtat']; ?> </td>
            <td>  
            <a href="edit.php?sp_ma=<?php echo $sp['sp_ma']; ?>" class="btn btn-success">Sua</a>
            <a href="delete.php?sp_ma=<?php echo $sp['sp_ma']; ?>" class="btn btn-danger">Xóa</a>
            <!-- <button class="btn btn-danger btnDelete" data-sp_ma=" //$sp['sp_ma']; ">Xóa</button> -->
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
                    
                    // 2. Lấy giá trị của thuộc tính (custom attribute HTML) 'sp_ma'
                    // var sp_ma = $(this).attr('data-sp_ma');
                    var sp_ma = $(this).data('sp_ma');
                    var url = "delete.php?sp_ma=" + sp_ma;
                    
                    // Điều hướng qua trang xóa với REQUEST GET, có tham số sp_ma=...
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