<?php
if (session_id() === '') {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shophoatuoi.vn</title>

    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../layouts/styles.php'); ?>
    <style>
        .homepage-slider-img {
            width: 100%;
            height: 450px;
            object-fit: cover; 
        }
        .d-flex {
            overflow-x:hidden;
        }
    </style>
    <link href="/shophoatuoi/assets/frontend/css/styles.css" type="text/css" rel="stylesheet"/>
</head>

<body class="d-flex flex-column h-100">
   <!-- header -->
        <?php 
            include_once(__DIR__ . '/../layouts/partials/header.php');
        ?>
    <!-- end header -->
    <!-- menu -->
        <?php 
        include_once(__DIR__ . '/../layouts/partials/menu.php');
        ?>
    <!-- end menu -->

    <main role="main" class="mb-2">
        <!-- Block content -->
        <?php
        include_once(__DIR__ . '/../../dbconnect.php');
        $sqlDanhSachSanPham = <<<EOT
        SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_motangan, sp.sp_soluong, lsp.lsp_ten, MAX(hsp.hsp_tentaptin) AS hsp_tentaptin
        FROM `sanpham` sp
        JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
        JOIN `chudehoa` cd ON sp.cd_ma = cd.cd_ma
        LEFT JOIN `hinhsanpham` hsp ON sp.sp_ma = hsp.sp_ma
        where lsp.lsp_ma=7
        GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_motangan, sp.sp_soluong, cd.cd_ten;
EOT;
        $result = mysqli_query($conn, $sqlDanhSachSanPham);
        $dataDanhSachSanPham = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $dataDanhSachSanPham[] = array(
                'sp_ma' => $row['sp_ma'],
                'sp_ten' => $row['sp_ten'],
                'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ',
                'sp_giacu' => number_format($row['sp_giacu'], 2, ".", ","),
                'sp_motangan' => $row['sp_motangan'],
                'sp_soluong' => $row['sp_soluong'],
                'lsp_ten' => $row['lsp_ten'],
                'hsp_tentaptin' => $row['hsp_tentaptin'],
            );
        }

        ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-4"><img src="/shophoatuoi/assets/shared/img/hoaly.png" width="350px" height="350px"></div>
                    <div class="col-md-8">
                        <h3>Hoa ly</h3>
                        
                        <p>Hoa ly hay còn có tên gọi khác là hoa bách hợp, hoa loa kèn hay Huệ Tây, chúng được trồng chủ yếu ở Châu Âu và thích hợp với miền khí hậu lạnh. Hoa ly tượng trưng cho sự thanh lịch sang trọng và nhã nhặn. Bởi vẻ đẹp của hoa ly rất thanh khiết và hoa ly có nét đẹp riêng nên mỗi một màu hoa ly mang một ý nghĩa khác nhau. </p>
                    </div>
                </div>
            </div>

        <!-- Giải thuật duyệt và render Danh sách sản phẩm theo dòng, cột của Bootstrap -->
        <div class="sanphams py-5 bg-light">
            <div class="container">
                <div class="row row-cols-3">
                    <?php foreach ($dataDanhSachSanPham as $sanpham) : ?>
                        <div class="col">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon red">MỚI</div>
                                    </div>

                                    <!-- Nếu có hình sản phẩm thì hiển thị -->
                                    <?php if (!empty($sanpham['hsp_tentaptin'])) : ?>
                                        <div class="container-img">
                                            <a href="/shophoatuoi/frontend/sanpham/detail.php?sp_ma=<?= $sanpham['sp_ma'] ?>">
                                                <img class="bd-placeholder-img card-img-top img-fluid hdd" width="100%" src="/shophoatuoi/assets/shared/img/<?= $sanpham['hsp_tentaptin'] ?>" />
                                            </a>
                                        </div>
                                        <!-- Nếu không có hình sản phẩm thì hiển thị ảnh mặc định -->
                                    <?php else : ?>
                                        <div class="container-img">
                                            <a href="/shophoatuoi/frontend/sanpham/detail.php?sp_ma=<?= $sanpham['sp_ma'] ?>">
                                                <img class="bd-placeholder-img card-img-top img-fluid hdd" width="100%" src="/shophoatuoi/assets/shared/img/default.png" />
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <a href="/shophoatuoi/frontend/sanpham/detail.php?sp_ma=<?= $sanpham['sp_ma'] ?>">
                                        <h5><?= $sanpham['sp_ten'] ?></h5>
                                    </a>
                                    <h6><?= $sanpham['lsp_ten'] ?></h6>
                                    <p class="card-text"><?= $sanpham['sp_motangan'] ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-outline-secondary" href="/shophoatuoi/frontend/sanpham/detail.php?sp_ma=<?= $sanpham['sp_ma'] ?>">Xem chi tiết</a>
                                        </div>
                                        <small class="text-muted text-right">
                                            <s><?= $sanpham['sp_giacu'] ?></s>
                                            <b><?= $sanpham['sp_gia'] ?></b>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- End block content -->
    </main>
    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>

    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại đây -->
</body>
</html>