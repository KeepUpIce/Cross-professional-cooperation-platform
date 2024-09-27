<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: register.php"); // 重定向到注册页面
    exit();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schedule = $_POST['schedule'];
    $name = $_POST['name'];
    $goal = $_POST['goal'];
    $abilities = $_POST['abilities'];
    $recruitment = $_POST['recruitment'];
    $tags = $_POST['tags']; // 获取标签
    $creator_id = $_SESSION['student_id'];

    $sql = "INSERT INTO projects (creator_id, name, goal, schedule, abilities, recruitment, tags) 
            VALUES ('$creator_id', '$name', '$goal', '$schedule', '$abilities', '$recruitment', '$tags')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: personal_center.php");
        exit();
    } else {
        echo "发起招募失败: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发起招募</title>
    <link rel="stylesheet" href="styles.css"> <!-- 引入CSS样式 -->
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #E6F2FF;
        color: #333;
        padding: 20px;
    }
    .container {
        display: flex;
    }
    .sidebar {
        width: 20%;
        background-color: #FFFFFF;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-right: 20px;
    }
    .sidebar h3 {
        color: #007BFF;
    }
    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }
    .sidebar ul li {
        margin: 10px 0;
    }
    .sidebar ul li a {
        color: #007BFF;
        text-decoration: none;
    }
    .sidebar ul li a:hover {
        text-decoration: underline;
    }
    .main-content {
        width: 80%;
        background-color: #FFFFFF;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h2, h3 {
        color: #007BFF;
    }
    textarea {
        width: calc(100% - 20px);
        height: 60px; /* 设置高度为两行 */
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #007BFF;
        border-radius: 5px;
        font-size: 16px; /* 增大字体 */
        resize: none; /* 禁止调整大小 */
    }
    input[type="text"] {
        width: calc(100% - 20px);
        padding: 12px; /* 增大内边距 */
        margin: 10px 0;
        border: 1px solid #007BFF;
        border-radius: 5px;
        font-size: 16px; /* 增大字体 */
    }
    input[type="submit"] {
        background-color: #007BFF;
        color: #FFFFFF;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px; /* 增大字体 */
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>


</head>
<body>

<div class="container">
    <div class="sidebar">
        <h3>标签栏</h3>
        <ul>
            <li><a href="project_hall.php">项目大厅</a></li>
            <li><a href="recruit.php">发起招募</a></li>
            <li><a href="personal_center.php">个人中心</a></li>
            <li><a href="resource_center.php">资源中心</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <h2>发起招募</h2>
        <form method="post">
    项目名称: <input type="text" name="name" required placeholder="好的名称能让更多人看到你~"><br>
    课程安排: <textarea name="schedule" required></textarea><br>
    项目目标: <textarea name="goal" required></textarea><br>
    个人能力: <textarea name="abilities" required></textarea><br>
    招募需求: <input type="text" name="recruitment" required></><br>
    标签: <input type="text" name="tags" required><br>
    <input type="submit" value="发起招募">
</form>


    </div>
</div>

</body>
</html>
