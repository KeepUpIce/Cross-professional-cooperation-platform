<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: register.php"); // 重定向到注册页面
    exit();
}
include 'db.php';

$project_id = $_GET['id'];

// 获取项目详情及发起人信息
$project_sql = "
    SELECT p.*, u.name AS creator_name, u.major AS creator_major, u.email AS creator_email 
    FROM projects p 
    JOIN users u ON p.creator_id = u.student_id 
    WHERE p.id = '$project_id'";
$project_result = $conn->query($project_sql);
$project = $project_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>项目详情</title>
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
        .application-info {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #E6F2FF;
            border-radius: 5px;
        }
        .apply-link {
            position: fixed;
            bottom: 10%;
            width: 60%;
            text-align: center;
        }
        .apply-link a {
            font-size: 20px;
            color: blue;
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
        <h2><?php echo $project['id'] . " - " . htmlspecialchars($project['name']); ?></h2>
        <p><strong>发起人:</strong> <?php echo htmlspecialchars($project['creator_name']) . " (学号: " . $project['creator_id'] . ")"; ?></p>
        <p><strong>专业:</strong> <?php echo htmlspecialchars($project['creator_major']); ?></p>
        <p><strong>邮箱:</strong> <?php echo htmlspecialchars($project['creator_email']); ?></p>
        <p><strong>项目目标:</strong> <?php echo htmlspecialchars($project['goal']); ?></p>
        <p><strong>课程安排:</strong> <?php echo htmlspecialchars($project['schedule']); ?></p>
        <p><strong>个人能力:</strong> <?php echo htmlspecialchars($project['abilities']); ?></p>
        <p><strong>招募需求:</strong> <?php echo htmlspecialchars($project['recruitment']); ?></p>

        <h3>申请人信息</h3>
        <?php
        // 获取申请信息，连接 users 表
        $applications_sql = "
            SELECT a.student_id, a.schedule, a.abilities, u.name, u.major, u.email 
            FROM applications a 
            JOIN users u ON a.student_id = u.student_id 
            WHERE a.project_id = '$project_id'";

        $applications_result = $conn->query($applications_sql);
        
        if ($applications_result->num_rows > 0) {
            while ($application = $applications_result->fetch_assoc()) {
                echo "<div class='application-info'>"; // 使用一致的样式
                echo "<p><strong>学号:</strong> " . htmlspecialchars($application['student_id']) . "</p>";
                echo "<p><strong>姓名:</strong> " . htmlspecialchars($application['name']) . "</p>";
                echo "<p><strong>专业:</strong> " . htmlspecialchars($application['major']) . "</p>";
                echo "<p><strong>邮箱:</strong> " . htmlspecialchars($application['email']) . "</p>";
                echo "<p><strong>课程安排:</strong> " . htmlspecialchars($application['schedule']) . "</p>";
                echo "<p><strong>个人能力:</strong> " . htmlspecialchars($application['abilities']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>目前没有申请人。</p>";
        }
        ?>

<div class="apply-link">
    <a href='apply.php?id=<?php echo $project_id; ?>' class="apply-button">点击此处申请此项目</a>
</div>

<style>
.apply-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #66B2FF; /* 更浅的蓝色 */
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.2s;
}

.apply-button:hover {
    background-color: #4DA6FF; /* 悬停时的颜色 */
    transform: scale(1.05);
}
</style>


    </div>
</div>

</body>
</html>
