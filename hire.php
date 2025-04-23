<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

if (!isset($_GET['freelancer_id']) || !isset($_GET['job_id'])) {
    echo "<script>alert('Missing information.'); window.location.href = 'client_dashboard.php';</script>";
    exit;
}

$freelancer_id = intval($_GET['freelancer_id']);
$job_id = intval($_GET['job_id']);

$conn->query("UPDATE jobs SET hired_freelancer = $freelancer_id WHERE id = $job_id");

echo "<script>alert('Freelancer hired successfully!'); window.location.href = 'client_dashboard.php';</script>";
?>
