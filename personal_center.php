<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: register.php"); // 重定向到注册页面
    exit();
}
include 'db.php';

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM users WHERE student_id='$student_id'";
$user = $conn->query($sql)->fetch_assoc();

$sql_projects = "SELECT * FROM projects WHERE creator_id='$student_id' OR id IN (SELECT project_id FROM applications WHERE student_id='$student_id') ORDER BY id DESC";
$projects = $conn->query($sql_projects);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心</title>
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
        .project-list p {
            display: block; /* 每个项目单独占一行 */
            padding: 5px 10px;
            background-color: #E6F2FF;
            border-radius: 5px;
            border: 1px solid #007BFF;
            margin-top: 10px; /* 确保项目间隔 */
        }
        .project-list p a {
            color: #007BFF;
            text-decoration: none;
        }
        .project-list p a:hover {
            text-decoration: underline;
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
        <h2>个人信息</h2>
        <p>学号: <?php echo $user['student_id']; ?></p>
        <p>姓名: <?php echo $user['name']; ?></p>
        <p>专业: <?php echo $user['major']; ?></p>
        <p>邮箱: <?php echo $user['email']; ?></p>
        
        <h3>我发起/申请的项目</h3>
        <div class="project-list">
            <?php while ($project = $projects->fetch_assoc()) { ?>
                <p>
                    <a href="project_detail.php?id=<?php echo $project['id']; ?>">
                        <?php echo $project['id']; ?> - <?php echo htmlspecialchars($project['name']); ?>
                    </a>
                </p>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>
