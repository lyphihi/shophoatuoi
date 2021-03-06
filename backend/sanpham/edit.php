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
                // Chuẩn bị câu truy vấn Loại sản phẩm
                $sqlLoaiSanPham = "select * from `loaisanpham`";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu
                $resultLoaiSanPham = mysqli_query($conn, $sqlLoaiSanPham);

                // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
                // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
                // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
                $dataLoaiSanPham = [];
                while ($rowLoaiSanPham = mysqli_fetch_array($resultLoaiSanPham, MYSQLI_ASSOC)) {
                    $dataLoaiSanPham[] = array(
                        'lsp_ma' => $rowLoaiSanPham['lsp_ma'],
                        'lsp_ten' => $rowLoaiSanPham['lsp_ten'],
                        'lsp_mota' => $rowLoaiSanPham['lsp_mota'],
                    );
                }
                /* --- End Truy vấn dữ liệu Loại sản phẩm --- */

                /* --- 
                --- 3. Truy vấn dữ liệu Nhà sản xuất 
                --- 
                */
                // Chuẩn bị câu truy vấn Nhà sản xuất
                $sqlNhaCungCap = "select * from `nhacungcap`";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu
                $resultNhaCungCap = mysqli_query($conn, $sqlNhaCungCap);

                // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
                // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
                // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
                $dataNhaCungCap = [];
                while ($rowNhaCungCap = mysqli_fetch_array($resultNhaCungCap, MYSQLI_ASSOC)) {
                    $dataNhaCungCap[] = array(
                        'ncc_ma' => $rowNhaCungCap['ncc_ma'],
                        'ncc_ten' => $rowNhaCungCap['ncc_ten'],
                    );
                }
                /* --- End Truy vấn dữ liệu Nhà sản xuất --- */

                /* --- 
                --- 4. Truy vấn dữ liệu Khuyến mãi
                --- 
                */
                // Chuẩn bị câu truy vấn Khuyến mãi
                $sqlKhuyenMai = "select * from `khuyenmai`";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu
                $resultKhuyenMai = mysqli_query($conn, $sqlKhuyenMai);

                // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
                // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
                // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
                $dataKhuyenMai = [];
                while ($rowKhuyenMai = mysqli_fetch_array($resultKhuyenMai, MYSQLI_ASSOC)) {
                    $km_tomtat = '';
                    if (!empty($rowKhuyenMai['km_ten'])) {
                        // Sử dụng hàm sprintf() để chuẩn bị mẫu câu với các giá trị truyền vào tương ứng từng vị trí placeholder
                        $km_tomtat = sprintf(
                            "Khuyến mãi %s, nội dung: %s, thời gian: %s-%s",
                            $rowKhuyenMai['km_ten'],
                            $rowKhuyenMai['km_noidung'],
                            // Sử dụng hàm date($format, $timestamp) để chuyển đổi ngày thành định dạng Việt Nam (ngày/tháng/năm)
                            // Do hàm date() nhận vào là đối tượng thời gian, chúng ta cần sử dụng hàm strtotime() để chuyển đổi từ chuỗi có định dạng 'yyyy-mm-dd' trong MYSQL thành đối tượng ngày tháng
                            date('d/m/Y', strtotime($rowKhuyenMai['km_tungay'])),    //vd: '2019-04-25'
                            date('d/m/Y', strtotime($rowKhuyenMai['km_denngay']))
                        );  //vd: '2019-05-10'
                    }
                    $dataKhuyenMai[] = array(
                        'km_ma' => $rowKhuyenMai['km_ma'],
                        'km_tomtat' => $km_tomtat,
                    );
                }
                /* --- End Truy vấn dữ liệu Khuyến mãi --- */

                /* --- 
                --- 5. Truy vấn dữ liệu Sản phẩm theo khóa chính
                --- 
                */
                // Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
                // Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
                $sp_ma = $_GET['sp_ma'];
                $sqlSelect = "SELECT * FROM `sanpham` WHERE sp_ma=$sp_ma;";

                // Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
                $resultSelect = mysqli_query($conn, $sqlSelect);
                $sanphamRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record
                /* --- End Truy vấn dữ liệu Sản phẩm theo khóa chính --- */
                ?>

                <form name="frmsanpham" id="frmsanpham" method="post" action="edit.php?sp_ma=<?= $sanphamRow['sp_ma'] ?>">
                    <div class="form-group">
                        <label for="sp_ma">Mã hoa</label>
                        <input type="text" class="form-control" id="sp_ma" name="sp_ma" placeholder="Mã Sản phẩm" readonly value="<?= $sanphamRow['sp_ma'] ?>">
                        <small id="sp_maHelp" class="form-text text-muted">Mã Sản phẩm không được hiệu chỉnh.</small>
                    </div>
                    <div class="form-group">
                        <label for="sp_ten">Tên hoa</label>
                        <input type="text" class="form-control" id="sp_ten" name="sp_ten" placeholder="Tên Sản phẩm" value="<?= $sanphamRow['sp_ten'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="sp_gia">Giá hoa</label>
                        <input type="text" class="form-control" id="sp_gia" name="sp_gia" placeholder="Giá Sản phẩm" value="<?= $sanphamRow['sp_gia'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="sp_giacu">Giá cũ hoa</label>
                        <input type="text" class="form-control" id="sp_giacu" name="sp_giacu" placeholder="Giá cũ Sản phẩm" value="<?= $sanphamRow['sp_giacu'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="sp_mota_ngan">Mô tả ngắn</label>
                        <input type="text" class="form-control" id="sp_mota_ngan" name="sp_mota_ngan" placeholder="Mô tả ngắn Sản phẩm" value="<?= $sanphamRow['sp_motangan'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="sp_mota_chitiet">Mô tả chi tiết</label>
                        <input type="text" class="form-control" id="sp_mota_chitiet" name="sp_mota_chitiet" placeholder="Mô tả chi tiết Sản phẩm" value="<?= $sanphamRow['sp_mota_chitiet'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="sp_ngaycapnhat">Ngày cập nhật</label>
                        <input type="text" class="form-control" id="sp_ngaycapnhat" name="sp_ngaycapnhat" placeholder="Ngày cập nhật Sản phẩm" value="<?= $sanphamRow['sp_ngaycapnhat'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="sp_soluong">Số lượng</label>
                        <input type="text" class="form-control" id="sp_soluong" name="sp_soluong" placeholder="Số lượng Sản phẩm" value="<?= $sanphamRow['sp_soluong'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="lsp_ma">Loại sản phẩm</label>
                        <select class="form-control" id="lsp_ma" name="lsp_ma">
                            <?php foreach ($dataLoaiSanPham as $loaisanpham) : ?>
                                <?php if ($loaisanpham['lsp_ma'] == $sanphamRow['lsp_ma']) : ?>
                                    <option value="<?= $loaisanpham['lsp_ma'] ?>" selected><?= $loaisanpham['lsp_ten'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $loaisanpham['lsp_ma'] ?>"><?= $loaisanpham['lsp_ten'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ncc_ma">Nhà sản xuất</label>
                        <select class="form-control" id="ncc_ma" name="ncc_ma">
                            <?php foreach ($dataNhaCungCap as $nhacungcap) : ?>
                                <?php if ($nhacungcap['ncc_ma'] == $sanphamRow['ncc_ma']) : ?>
                                    <option value="<?= $nhacungcap['ncc_ma'] ?>" selected><?= $nhacungcap['ncc_ten'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $nhacungcap['ncc_ma'] ?>"><?= $nhacungcap['ncc_ten'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="km_ma">Khuyến mãi</label>
                        <select class="form-control" id="km_ma" name="km_ma">
                            <option value="">Không áp dụng khuyến mãi</option>
                            <?php foreach ($dataKhuyenMai as $khuyenmai) : ?>
                                <?php if ($khuyenmai['km_ma'] == $sanphamRow['km_ma']) : ?>
                                    <option value="<?= $khuyenmai['km_ma'] ?>" selected><?= $khuyenmai['km_tomtat'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $khuyenmai['km_ma'] ?>"><?= $khuyenmai['km_tomtat'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-primary" name="btnSave">Cập nhật</button>
                </form>

                <?php
                // 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
                if (isset($_POST['btnSave'])) {
                    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
                    $ten = $_POST['sp_ten'];
                    $gia = $_POST['sp_gia'];
                    $giacu = $_POST['sp_giacu'];
                    $motangan = $_POST['sp_motangan'];
                    $motachitiet = $_POST['sp_mota_chitiet'];
                    $ngaycapnhat = $_POST['sp_ngaycapnhat'];
                    $soluong = $_POST['sp_soluong'];
                    $lsp_ma = $_POST['lsp_ma'];
                    $ncc_ma = $_POST['ncc_ma'];
                    $km_ma = empty($_POST['km_ma']) ? 'NULL' : $_POST['km_ma'];

                    // Câu lệnh INSERT
                    $sql = "UPDATE `sanpham` SET sp_ten='$ten', sp_gia=$gia, sp_giacu=$giacu, sp_motangan='$motangan', sp_mota_chitiet='$motachitiet', sp_ngaycapnhat='$ngaycapnhat', sp_soluong=$soluong, lsp_ma=$lsp_ma, ncc_ma=$ncc_ma, km_ma=$km_ma WHERE sp_ma=$sp_ma;";

                    // Thực thi INSERT
                    mysqli_query($conn, $sql);

                    // Đóng kết nối
                    mysqli_close($conn);

                    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
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

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
    <!-- <script src="..."></script> -->
</body>

</html>