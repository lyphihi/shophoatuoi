<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    <!-- menu -->
    <?php 
    include_once(__DIR__ . '/../layouts/partials/menu.php');
    ?>
    <!-- end menu -->

    <div class="container">
        <div class="row">
                <!-- sidebar -->
            <div class="col-md-4">
                <?php 
                include_once(__DIR__ . '/../layouts/partials/sidebar.php');
                ?>
            </div>
                <!-- end sidebar -->
            <div class="col-md-8">
                
              dhjkxhgiglk,dgkl
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