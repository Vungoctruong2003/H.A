<?php
session_start();

$gender = array("Nam", "Nữ");
$department = array("MAT" => "Khoa học máy tính", "KDL" => "Khoa học vật liệu");

function is_format_date($date, $format = 'd/m/Y')
{
    $_date = DateTime::createFromFormat($format, $date);
    return $_date && $_date->format($format) === $date;
}

$errors = "";

if (!empty($_POST)) {

    // xử lí ảnh
    $img = $_FILES['image']['name'];
    $target_dir = "uploads/" . $_FILES['image']['name'];
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $file = $_FILES['image']['tmp_name'];
    move_uploaded_file($file, $target_dir);

    //nếu vượt qua validate thì cho vào mảng session
    if (($_POST["user_name"]) == '') {
        $errors = $errors . '<div class="text-danger">Hãy nhập tên.<br></div>';
    } else {
        $_SESSION['user']['name'] = $_POST['user_name'];
    }

    if (!isset($_POST["gender"])) {
        $errors = $errors . '<div class="text-danger">Hãy chọn giới tính.<br></div>';
    } else {
        $_SESSION['user']['gender'] = $_POST['gender'];
    }

    if (($_POST["department"]) == '') {
        $errors = $errors . '<div class="text-danger">Hãy chọn phân khoa.<br></div>';
    } else {
        $_SESSION['user']['department'] = $_POST['department'];
    }


    if (($_POST["birthday"]) == '') {
        $errors = $errors . '<div class="text-danger">Hãy nhập ngày sinh.<br></div>';
    }
    if (!is_format_date($_POST["birthday"])) {
        $errors = $errors . '<div class="text-danger">Hãy nhập ngày sinh đúng định dạng.<br></div>';
    }
    if (($_POST["birthday"] != '') && is_format_date($_POST["birthday"])) {
        $_SESSION['user']['birthday'] = $_POST['birthday'];
    }

    $_SESSION['user']['address'] = $_POST['address'];

    $_SESSION['user']['image'] = $img;

    //kiểm tra nếu nhập đủ dữ liệu thì mới sang màn confirm
    if (count($_SESSION['user']) == 6) {
        header("location:confirm.php");;
    }
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
    <title>Register</title>
</head>

<!-- style -->
<style>
    body {
        display: flex;
        justify-content: center;
    }

    .register {
        margin-top: 50px;
        border: 1px solid #41719c;
        display: inline-block;
        padding: 30px;
    }

    .input-box {
        margin-bottom: 10px;
    }

    .text-label {
        border: 1px solid #42729d;
        color: white;
        background-color: #70ad47;
        padding: 5px 7px;
        display: inline-block;
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

    .text-field {
        height: 30px;
        border: 1px solid #41719c;
        width: 250px;
    }

    .select-field {
        height: 30px;
        border: 1px solid #41719c;
    }

    .text-danger {
        color: red;
    }

    .input-group {
        width: 150px;
        float: right;
        margin-right: 100px;
    }

    /* Create a custom radio button */
</style>
<!-- end style -->

<body>
<div class="register">
    <?php
    if (!empty($errors)) {
        echo $errors . "<br>";
    }
    ?>
    <form action="" enctype="multipart/form-data" method="post">
        <div class="input-box">
            <label for="" class="text-label">
                Họ và tên
                <span class="text-danger">*</span>
            </label>
            <input type="text" class="text-field" name="user_name">
        </div>
        <div class="input-box">
            <label for="" class="text-label">
                Giới tính
                <span class="text-danger">*</span>
            </label>
            <?php
            for ($i = 0; $i < count($gender); $i++) {
                echo "<input  type='radio' name='gender' value=$i><label style='color: black'>$gender[$i]</label>";
            }
            ?>
        </div>
        <div class="input-box">
            <label for="department" class="text-label">
                Phân khoa
                <span class="text-danger">*</span>
            </label>
            <select name="department" id="department" class="select-field">
                <option value=''>Chọn phân khoa</option>
                <?php
                foreach ($department as $key => $value) {
                    echo "<option value='$key'>$value</option>";
                }
                ?>
            </select>
        </div>
        <div class="input-box">
            <label for="" class="text-label">
                Ngày sinh
                <span class="text-danger">*</span>
            </label>
            <div class='input-group' id='date-picker'>
                <input type='text' class="form-control" placeholder="dd/mm/yyyy" name="birthday"/>
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </span>
            </div>
        </div>
        <div class="input-box">
            <label for="" class="text-label">
                Địa chỉ
            </label>
            <input type="text" class="text-field" name="address">
        </div>
        <div class="input-box" style="display: flex;">
            <label for="" class="text-label">
                Hình ảnh
            </label>
            <input type="file" class="image-field" name="image">
        </div>
        <div class="btn">
            <button class="btn-submit" type="submit" name="submit">Đăng ký</button>
        </div>
    </form>
</div>
<!-- script -->
<script>
    $(function () {
        $('#date-picker').datetimepicker({
            format: 'DD/MM/YYYY',
        })
    });
</script>
<!-- end script -->
</body>
</html>
