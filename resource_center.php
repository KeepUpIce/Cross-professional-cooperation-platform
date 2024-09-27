<?php
session_start();
include 'db.php'; // 引入数据库连接

// 定义上传目录
$upload_dir = 'uploads/';

// 处理文件上传
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    $upload_file = $upload_dir . $file_name;

    

    //允许上传的文件类型
    $allowed_types=[
        'image/jpeg', 
        'image/png',  
        'application/pdf',  
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', 
        'application/zip', 
        'video/mp4', 
        'text/markdown', 
        'text/plain'
    ];
    
    // 检查文件类型
    if (in_array($_FILES['file']['type'], $allowed_types)) {
        // 检查上传文件是否成功
        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
        } else {
            echo "<p>文件上传失败，请重试。</p>";
        }
    } else {
        echo "<p>不支持的文件类型。</p>";
    }
}

// 获取已上传的文件
$files = scandir($upload_dir);

// 处理搜索请求
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = trim($_POST['search']);
    $files = array_filter($files, function($file) use ($search_query) {
        return stripos($file, $search_query) !== false && $file !== '.' && $file !== '..';
    });
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>资源中心</title>
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
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="file"] {
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
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
        <h2>资源中心</h2>
        
        <form action="" method="post" enctype="multipart/form-data">
            <label for="file">选择文件:</label>
            <input type="file" name="file" id="file" required>
            <input type="submit" value="上传">
        </form>

        <form action="" method="post">
            <label for="search">搜索文件名:</label>
            <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search_query); ?>">
            <input type="submit" value="搜索">
        </form>
        
        <h3>已上传文件列表</h3>
        <ul>
            <?php
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    echo "<li><a href='$upload_dir$file' target='_blank'>$file</a></li>";
                }
            }
            ?>
        </ul>
    </div>
</div>
</body>
</html>
