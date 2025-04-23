<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'freelancer') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$jobs = $conn->query("SELECT * FROM jobs ORDER BY id DESC");
?>ACA

<!DOCTYPE html>
<html>
<head>
    <title>Freelancer Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef1f5;
            margin: 0;
        }
        .header {
            background: #6c63ff;
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
        .btn {
            margin-top: 15px;
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0069d9;
        }
    </style>
</head>
<body>

<div class="header">Freelancer Dashboard</div>

<div class="container">
    <?php while($row = $jobs->fetch_assoc()) { ?>
        <div class="job-card">
            <div class="job-title"><?= htmlspecialchars($row['title']) ?></div>
            <div class="job-desc">Category: <?= $row['category'] ?> | Budget: $<?= $row['budget'] ?> | Deadline: <?= $row['deadline'] ?></div>
            <div class="job-desc"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
            <button class="btn" onclick="applyNow(<?= $row['id'] ?>)">Apply</button>
        </div>
    <?php } ?>
</div>

<script>
    function applyNow(jobId) {
        window.location.href = 'submit_proposal.php?job_id=' + jobId;
    }
</script>

</body>
</html>
