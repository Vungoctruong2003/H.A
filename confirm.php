<?php
session_start();
//nếu mảng session bên form input chưa đủ dữ liệu thì quay lại nhập đủ
if (empty($_SESSION['user']) && count($_SESSION['user']) != 6) {
    header("location:index.php");
}
//khi nhấn vào btn "Xác nhận" thì xoá session đồng thời quay trở lại màn input
if (!empty($_POST)) {
    session_destroy();
    header("location:index.php");;
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <title>Confirm</title>
</head>

<!-- style -->
<style>
    body {
        display: flex;
        justify-content: center;
    }

    .confirm {
        margin-top: 50px;
        border: 1px solid #41719c;
        display: inline-block;
        padding: 30px;
    }

    .input-box {
        display: flex;
        margin-bottom: 10px;
    }

    .text-label {
        border: 1px solid #42729d;
        color: white;
        background-color: #70ad47;
        padding: 5px 7px;
        width: 110px;
        text-align: center;
        margin-right: 10px;
    }

    .btn {
        display: flex;
        justify-content: center;
    }

    .btn-submit {
        border: 1px solid #41719c;
        border-radius: 6px;
        padding: 7px 20px;
        background-color: #70ad47;
        color: white;
        margin-top: 10px;
    }


    /* Create a custom radio button */
</style>
<!-- end style -->

<body>
<div class="confirm">
    <form action="" enctype="multipart/form-data" method="post">
        <div class="input-box">
            <label for="" class="text-label">
                Họ và tên
            </label>
            <p><?php echo $_SESSION['user']['name'] ?></p>
        </div>
        <div class="input-box">
            <label for="" class="text-label">
                Giới tính
            </label>
            <p><?php echo $_SESSION['user']['gender'] ?></p>
        </div>
        <div class="input-box">
            <label for="department" class="text-label">
                Phân khoa
            </label>
            <p><?php echo $_SESSION['user']['department'] ?></p>
        </div>
        <div class="input-box">
            <label for="" class="text-label">
                Ngày sinh
            </label>
            <p><?php echo $_SESSION['user']['birthday'] ?></p>
        </div>
        <div class="input-box">
            <label for="" class="text-label">
                Địa chỉ
            </label>
            <p><?php echo $_SESSION['user']['address'] ?></p>
        </div>
        <div class="input-box">
            <label for="" class="text-label">
                Hình ảnh
            </label>
            <?php
            if ($_SESSION['user']['image'] != '') {
                echo '<img width="250" height="150" src="uploads/' . $_SESSION['user']['image'] . '">';
            }
            ?>
        </div>
        <div class="btn">
            <button class="btn-submit" type="submit" name="submit">Xác nhận</button>
        </div>
    </form>
</div>
</body>
</html>
