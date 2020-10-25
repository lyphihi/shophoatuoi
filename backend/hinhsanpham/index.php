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
            <?php 
                include_once(__DIR__ . '/../../dbconnect.php');
                // 2. Chuẩn bị câu truy vấn $sql
                // Sử dụng HEREDOC của PHP để tạo câu truy vấn SQL với dạng dễ đọc, thân thiện với việc bảo trì code
                $sql = <<<EOT
                SELECT *
                FROM `hinhsanpham` hsp
                JOIN `sanpham` sp on hsp.sp_ma = sp.sp_ma
EOT;
                // 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
                $result = mysqli_query($conn, $sql);
                // 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
                // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
                // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
                $data = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                  // Sử dụng hàm sprintf() để chuẩn bị mẫu câu với các giá trị truyền vào tương ứng từng vị trí placeholder
                  $sp_tomtat = sprintf(
                    "Sản phẩm %s, giá: %2f",
                    $row['sp_ten'],
                    number_format($row['sp_gia'], 2, ".", ",") . 'vnđ'
                  );
                  $data[] = array(
                    'hsp_ma' => $row['hsp_ma'],
                    'hsp_tentaptin' => $row['hsp_tentaptin'],
                    'sp_tomtat' => $sp_tomtat,
                  );
                }
                /* --- End Truy vấn dữ liệu sản phẩm --- */
            ?>
            <h2>Danh sach hinh san pham</h2>
                <!-- Nút thêm mới, bấm vào sẽ hiển thị form nhập thông tin Thêm mới -->
                <a href="create.php" class="btn btn-primary">
                Thêm mới
                </a>
                <table class="table table-bordered table-hover mt-2">
                <thead class="thead-dark">
                    <tr>
                    <th>Mã Hình Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $hinhsanpham): ?>
                    <tr>
                    <td><?= $hinhsanpham['hsp_ma'] ?></td>
                    <td>
                        <img src="/shophoatuoi/assets/shared/img/<?= $hinhsanpham['hsp_tentaptin'] ?>" class="img-fluid" width="100px" />
                    </td>
                    <td><?= $hinhsanpham['sp_tomtat'] ?></td>
                    <td>
                        <!-- Nút sửa, bấm vào sẽ hiển thị form hiệu chỉnh thông tin dựa vào khóa chính `hsp_ma` -->
                        <a href="edit.php?hsp_ma=<?= $hinhsanpham['hsp_ma'] ?>" class="btn btn-warning">
                        Sửa
                        </a>
                        <!-- Nút xóa, bấm vào sẽ xóa thông tin dựa vào khóa chính `sp_ma` -->
                        <a href="delete.php?hsp_ma=<?= $hinhsanpham['hsp_ma'] ?>" class="btn btn-danger">
                        Xóa
                        </a>
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
    
</body>
</html>