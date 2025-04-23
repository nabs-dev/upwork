<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$client_id = $_SESSION['id'];
$jobs = $conn->query("SELECT * FROM jobs WHERE client_id = '$client_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef1f5;
            margin: 0;
        }
        .header {
            background: #2d9cdb;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }
        .job-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.06);
            margin-bottom: 20px;
        }
        .job-title {
            font-size: 20px;
            color: #333;
            font-weight: bold;
        }
        .job-desc {
            margin-top: 10px;
            color: #666;
        }
        .btns {
            margin-top: 15px;
        }
        .btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            margin-right: 10px;
            cursor: pointer;
        }
        .btn:hover {
            background: #218838;
        }
        .post-btn {
            float: right;
            background: #007bff;
        }
        .post-btn:hover {
            background: #0069d9;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

<div class="header">
    Client Dashboard
    <button class="btn post-btn" onclick="goTo('post_job.php')">Post New Job</button>
    <div class="clear"></div>
</div>

<div class="container">
    <?php while($row = $jobs->fetch_assoc()) { 
        $job_id = $row['id'];
        $proposals = $conn->query("SELECT * FROM proposals WHERE job_id = '$job_id'");
    ?>
        <div class="job-card">
            <div class="job-title"><?= htmlspecialchars($row['title']) ?></div>
            <div class="job-desc"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
            <div class="btns">
                <button class="btn" onclick="viewProposals(<?= $job_id ?>)">View Proposals (<?= $proposals->num_rows ?>)</button>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    function goTo(page) {
        window.location.href = page;
    }
    function viewProposals(jobId) {
        window.location.href = 'view_proposals.php?job_id=' + jobId;
    }
</script>

</body>
</html>
