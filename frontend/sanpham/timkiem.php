<?php
  if (isset($_REQUEST['Tukhoa'])) 
    {
      // Gán hàm addslashes để chống sql injection
      $search = addslashes($_GET['txttk']);
      // Nếu $search rỗng thì báo lỗi, tức là người dùng chưa nhập liệu mà đã nhấn submit.
      if (empty($search)) {
        echo "Yeu cau nhap du lieu vao o trong";
      }
      else {
        // Phan dung vong lap while show du lieu

      }
?>