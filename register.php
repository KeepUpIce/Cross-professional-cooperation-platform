<?php
include 'db.php';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $major = $_POST['major'];
    $email = $_POST['email'];

    // 处理文件上传
    $target_dir = "user_images/";
    $target_file = $target_dir . basename($_FILES["id_photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 检查是否为有效图片
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["id_photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "文件不是一个图像.";
            $uploadOk = 0;
        }
    }

    // 仅允许特定格式的文件
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "抱歉，仅支持 JPG, JPEG, PNG 文件.";
        $uploadOk = 0;
    }

    // 检查 $uploadOk 是否设置为 0
    if ($uploadOk == 0) {
        echo "抱歉，您的文件未上传.";
    } else {
        if (move_uploaded_file($_FILES["id_photo"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO pending_users (student_id, name, password, major, email, id_photo) 
                    VALUES ('$student_id', '$name', '$password', '$major', '$email', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                $success_message = "注册申请已提交，审核结果将以邮件形式通知！";
            } else {
                echo "错误: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "抱歉，上传您的文件时出错.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注册</title>
    <link rel="stylesheet" href="styles.css"> <!-- 引入CSS样式 -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #E6F2FF;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 2.5em;
            color: #007BFF;
            margin: 0;
        }
        form {
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #007BFF;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #FFFFFF;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%; /* 使按钮宽度占满 */
            margin-top: 10px; /* 顶部间距 */
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        /* 弹窗样式 */
        .modal {
            display: none; /* 默认隐藏 */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* 半透明背景 */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px; /* 最大宽度 */
            text-align: center;
            border-radius: 10px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>跨专业合作平台</h1>
</div>

<form method="post" enctype="multipart/form-data">
    <h2>注册账户</h2>
    <label for="student_id">学号/工号:</label>
    <input type="text" name="student_id" required>
    
    <label for="name">姓名:</label>
    <input type="text" name="name" required>
    
    <label for="password">密码:</label>
    <input type="password" name="password" required>
    
    <label for="major">专业:</label>
    <input type="text" name="major" required>
    
    <label for="email">邮箱:</label>
    <input type="email" name="email" required>
    
    <label for="id_photo">身份证明照片:</label>
    <input type="file" name="id_photo" accept="image/*" required>
    
    <input type="submit" value="注册" name="submit">
</form>

<p>已有账户？<a href="login.php">点击登录</a></p>

<!-- 弹窗 -->
<div id="successModal" class="modal" style="<?php echo $success_message ? 'display: block;' : ''; ?>">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
        <p><?php echo $success_message; ?></p>
    </div>
</div>

<script>
    // 点击窗口外部关闭弹窗
    window.onclick = function(event) {
        var modal = document.getElementById('successModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>