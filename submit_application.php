<?php
session_start();
include 'db.php';

$id = $_GET['id'];
$schedule = $_POST['schedule'];
$abilities = $_POST['abilities'];
$student_id = $_SESSION['student_id'];

$sql = "INSERT INTO applications (project_id, student_id, schedule, abilities) VALUES ('$id', '$student_id', '$schedule', '$abilities')";
$conn->query($sql);

header("Location: personal_center.php");
?>
