<?php
$conn = mysqli_connect('127.0.0.1','root','','shophoatuoi') or die('Xin loi');

$conn->query("SET NAMES 'utf8mb4'"); 
$conn->query("SET CHARACTER SET UTF8MB4");  
$conn->query("SET SESSION collation_connection = 'utf8mb4_unicode_ci'");
?>