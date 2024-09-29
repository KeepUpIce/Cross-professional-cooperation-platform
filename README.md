# 跨专业合作平台

开发语言：PHP+MySQL+HTML+JS+CSS

此跨专业合作平台用于提供大学生发起和参与跨学科项目的渠道。

该平台具备包括但不限于以下功能和特点：

1、系统支持不同角色用户的注册和认证。学生可以自主发起或加入项目，教师也可发起项目，并上传和分享相关资源。

2、用户可以在平台上发布需要多学科支持的项目并为其添加标签，用户可通过点击标签查看对应项目。

3、系统提供预定格式，用户需按格式填写表单内容，包括个人专业、课程安排、项目目标、个人能力、联系方式和招募需求等。申请者需提交相同的表单以申请参与项目。

4、平台需具备高频率使用场景，并确保操作简便。从使用频率、便捷性和合作有效性三方面出发，设计易用的界面和简化的操作流程，以提升用户体验。

5、平台内的项目合作应保持相对封闭，仅限已认证用户查看和参与，以防止项目核心内容外泄。

# 目录结构

uploads文件夹包含用户上传的资源文件，user_images文件夹包含用户注册时上传的身份证件照片，其它为功能文件，实现前后端功能：

![image](https://github.com/user-attachments/assets/cf37a12e-c4ec-4e04-bbf1-ff830e0fa4b1)

# 使用说明

1、将项目源文件解压后放置于服务器 WWW 目录下。

2、创建数据库
```sql
CREATE DATABASE project_management;  -- 创建数据库
```


3、初始化数据库
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- 用户ID，自动递增主键
    student_id VARCHAR(50) NOT NULL UNIQUE,  -- 学号/工号，唯一
    name VARCHAR(100) NOT NULL,  -- 用户姓名
    password VARCHAR(255) NOT NULL,  -- 用户密码
    major VARCHAR(100) NOT NULL,  -- 用户专业
    email VARCHAR(100) NOT NULL  -- 用户邮箱
);
-- users表存储学号/工号、姓名、密码、专业、邮箱

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- 项目ID，自动递增主键
    creator_id VARCHAR(50) NOT NULL,  -- 发起者ID
    name VARCHAR(100) NOT NULL,  -- 项目名称
    goal TEXT NOT NULL,  -- 项目目标
    schedule TEXT NOT NULL,  -- 课程安排
    abilities TEXT NOT NULL,  -- 所需能力
    recruitment TEXT NOT NULL,  -- 招募需求
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- 创建时间
    tags VARCHAR(255)  -- 项目标签
);
-- projects表存储项目编号、发起者ID、项目名称、项目目标、课程安排、个人能力、招募需求、创建时间、项目标签

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- 申请ID，自动递增主键
    project_id INT NOT NULL,  -- 项目编号
    student_id VARCHAR(50) NOT NULL,  -- 学号/工号
    schedule TEXT NOT NULL,  -- 课程安排
    abilities TEXT NOT NULL,  -- 个人能力
    FOREIGN KEY (project_id) REFERENCES projects(id)  -- 外键，关联到projects表
);
-- applications表存储项目编号、学号/工号、课程安排、个人能力、外键

CREATE TABLE pending_users (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- 待审核用户ID，自动递增主键
    student_id VARCHAR(50) NOT NULL,  -- 学号/工号
    name VARCHAR(100) NOT NULL,  -- 用户姓名
    password VARCHAR(255) NOT NULL,  -- 用户密码
    major VARCHAR(100) NOT NULL,  -- 用户专业
    email VARCHAR(100) NOT NULL,  -- 用户邮箱
    id_photo VARCHAR(255) NOT NULL,  -- 身份证明照片
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',  -- 审核状态
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- 创建时间
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- 管理员ID，自动递增主键
    username VARCHAR(50) NOT NULL UNIQUE,  -- 管理员用户名，唯一
    password VARCHAR(255) NOT NULL  -- 管理员密码，存储加密后的值
);
-- admin表存储管理员的用户名和密码
```

4、开启服务器及数据库(Apache/Nginx、Mysql)

5、访问 https://Your-Ip/plateform/register.php 进入用户注册界面

6、访问 http://Your-Ip/plateform/admin_login.php 进入管理员登录界面，在管理员界面登录前，请在 admin 表添加管理员用户名密码。

