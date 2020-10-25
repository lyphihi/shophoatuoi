<?php 
    // Truy vấn database để lấy danh sách
    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once(__DIR__.'/../../dbconnect.php');
    // 2. Chuẩn bị câu truy vấn $sql
    $sqlSoLuongDondathang = "select count(*) as SoLuong from `dondathang`";
    // 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
    $result = mysqli_query($conn, $sqlSoLuongDondathang);
    // 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
    // Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
    // Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
    $sqlSoLuongDondathang = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $sqlSoLuongDondathang[] = array(
            'SoLuong' => $row['SoLuong']
        );
    }
    // 5. Chuyển đổi dữ liệu về định dạng JSON
    // Dữ liệu JSON, từ array PHP -> JSON 
    echo json_encode($sqlSoLuongDondathang[0]);
?>