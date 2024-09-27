<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: register.php"); // 重定向到注册页面
    exit();
}
include 'db.php';

$tag = isset($_GET['tag']) ? $_GET['tag'] : '';
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>标签页面</title>
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
        .tags, .project-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px; /* 确保标签和项目在标题下方 */
        }
        .tags span {
            display: inline-block; /* 保持标签样式 */
            padding: 5px 10px;
            background-color: #E6F2FF;
            border-radius: 5px;
            border: 1px solid #007BFF;
        }
        .tags span a {
            color: #007BFF;
            text-decoration: none;
        }
        .tags span a:hover {
            text-decoration: underline;
        }
        .project-list p {
            display: block; /* 每个项目单独占一行 */
            padding: 5px 10px;
            background-color: #E6F2FF;
            border-radius: 5px;
            border: 1px solid #007BFF;
            width: calc(100% - 20px); /* 使项目占满整行，减去内边距 */
        }
        .project-list p a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold; /* 加粗项目名称 */
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
        <h2>标签：<?php echo htmlspecialchars($tag); ?></h2>
        
        <h3>相关项目</h3>
        <div class="project-list">
            <?php
            // 根据标签获取相关项目
            $sql = "SELECT * FROM projects WHERE tags LIKE '%" . $conn->real_escape_string($tag) . "%' ORDER BY created_at DESC";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p><a href='project_detail.php?id=" . $row['id'] . "'>" . $row['id'] . " - " . htmlspecialchars($row['name']) . "</a></p>";
                }
            } else {
                echo "<p>没有相关项目可显示</p>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
