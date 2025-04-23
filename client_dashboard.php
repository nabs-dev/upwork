<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$client_id = $_SESSION['id'];
$jobs = $conn->query("SELECT * FROM jobs WHERE client_id = $client_id ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            margin: 0;
        }
        .header {
            background: #20c997;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 26px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }
        .job-box {
            background: white;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .job-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .proposal {
            background: #f8f9fa;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border-left: 4px solid #20c997;
        }
        .btn {
            margin-top: 10px;
            background: #007bff;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0069d9;
        }
    </style>
</head>
<body>

<div class="header">Client Dashboard</div>
<div class="container">
    <?php while ($job = $jobs->fetch_assoc()) { 
        $job_id = $job['id'];
        $proposals = $conn->query("SELECT p.*, u.name FROM proposals p JOIN users u ON p.freelancer_id = u.id WHERE p.job_id = $job_id");
    ?>
    <div class="job-box">
        <div class="job-title">Job: <?= htmlspecialchars($job['title']) ?></div>
        <div><strong>Budget:</strong> $<?= $job['budget'] ?> | <strong>Deadline:</strong> <?= $job['deadline'] ?></div>
        <div style="margin-top:10px;"><strong>Proposals:</strong></div>
        <?php if ($proposals->num_rows > 0) { while ($p = $proposals->fetch_assoc()) { ?>
            <div class="proposal">
                <strong><?= htmlspecialchars($p['name']) ?></strong><br>
                <?= nl2br(htmlspecialchars($p['cover_letter'])) ?><br>
                <strong>Bid:</strong> $<?= $p['bid_amount'] ?><br>
                <button class="btn" onclick="hireNow(<?= $p['freelancer_id'] ?>, <?= $job_id ?>)">Hire</button>
            </div>
        <?php }} else { echo "<p>No proposals yet.</p>"; } ?>
    </div>
    <?php } ?>
</div>

<script>
    function hireNow(freelancerId, jobId) {
        window.location.href = 'hire.php?freelancer_id=' + freelancerId + '&job_id=' + jobId;
    }
</script>

</body>
</html>
