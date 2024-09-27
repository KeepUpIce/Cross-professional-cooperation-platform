<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: register.php"); // 重定向到注册页面
    exit();
}
include 'db.php';

// 设置每页显示的项目数
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// 获取项目总数
$total_sql = "SELECT COUNT(*) as total FROM projects";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>项目大厅</title>
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
        }
        .project-list p a:hover {
            text-decoration: underline;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            color: #007BFF;
            text-decoration: none;
        }
        .pagination a:hover {
            background-color: #E6F2FF;
        }
        .pagination span {
            margin: 0 5px;
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
        <h2>项目大厅</h2>
        
        <!-- 标签部分 -->
        <h3>项目标签</h3>
        <div class="tags">
            <?php
            // 获取去重的标签
            $tags_sql = "SELECT DISTINCT tags FROM projects WHERE tags IS NOT NULL";
            $tags_result = $conn->query($tags_sql);
            while ($tag_row = $tags_result->fetch_assoc()) {
                echo "<span><a href='tag_detail.php?tag=" . urlencode($tag_row['tags']) . "'>" . htmlspecialchars($tag_row['tags']) . "</a></span>";
            }
            ?>
        </div>

        <!-- 项目列表 -->
        <h3>项目列表</h3>
        <div class="project-list">
            <?php
            $sql = "SELECT * FROM projects ORDER BY created_at DESC LIMIT $items_per_page OFFSET $offset";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p><a href='project_detail.php?id=" . $row['id'] . "'>" . $row['id'] . " - " . htmlspecialchars($row['name']) . "</a></p>";
                }
            } else {
                echo "<p>没有项目可显示</p>";
            }
            ?>
        </div>

        <!-- 分页 -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=1">首页</a>
        <a href="?page=<?php echo $page - 1; ?>">上一页</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($i == $page): ?>
            <span class="active-page"><?php echo $i; ?></span>
        <?php else: ?>
            <a href="?page=<?php echo $i; ?>" class="page-number"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    
    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>">下一页</a>
        <a href="?page=<?php echo $total_pages; ?>">末页</a>
    <?php endif; ?>
</div>

<style>
.pagination {
    display: flex;
    align-items: center;
    gap: 10px;
}

.page-number, .active-page {
    display: inline-block;
    padding: 5px 10px;
    border: 1px solid #007BFF;
    border-radius: 4px;
    text-decoration: none;
    color: #007BFF;
}

.active-page {
    background-color: #e0f7fa; /* 或其他高亮颜色 */
    color: #0056b3;
}
</style>



    </div>
</div>

</body>
</html>
