<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: register.php"); // 重定向到注册页面
    exit();
}

include 'db.php';

$id = $_GET['id'];

// 查询项目名称
$result = mysqli_query($conn, "SELECT name FROM projects WHERE id = $id");
$project = mysqli_fetch_assoc($result);
$project_name = $project ? htmlspecialchars($project['name']) : '未知项目'; // 防止未找到项目的情况
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请项目</title>
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
        h2 {
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
        <h2>你申请的项目为：<?php echo htmlspecialchars($id); ?> - <?php echo $project_name; ?></h2>
        <form method="post" action="submit_application.php?id=<?php echo htmlspecialchars($id); ?>">
            <label for="schedule">课程安排:</label>
            <textarea name="schedule" id="schedule" required></textarea><br>
            <label for="abilities">个人能力:</label>
            <textarea name="abilities" id="abilities" required></textarea><br>
            <input type="submit" value="提交申请">
        </form>
    </div>
</div>

</body>
</html>
