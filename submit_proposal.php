<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'freelancer') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

if (!isset($_GET['job_id'])) {
    echo "<script>alert('Job not specified.'); window.location.href = 'dashboard_freelancer.php';</script>";
    exit;
}

$job_id = intval($_GET['job_id']);
$job = $conn->query("SELECT * FROM jobs WHERE id = $job_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cover = $conn->real_escape_string($_POST['cover']);
    $bid = floatval($_POST['bid']);
    $freelancer_id = $_SESSION['id'];

    $conn->query("INSERT INTO proposals (job_id, freelancer_id, cover_letter, bid_amount) VALUES ($job_id, $freelancer_id, '$cover', $bid)");

    echo "<script>alert('Proposal submitted successfully.'); window.location.href = 'dashboard_freelancer.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Proposal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #555;
        }
        textarea, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
        }
        .btn {
            margin-top: 20px;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Submit Proposal for: <?= htmlspecialchars($job['title']) ?></h2>
    <form method="POST">
        <label for="cover">Cover Letter:</label>
        <textarea name="cover" rows="6" required></textarea>

        <label for="bid">Bid Amount ($):</label>
        <input type="number" name="bid" min="1" required>

        <button type="submit" class="btn">Send Proposal</button>
    </form>
</div>
</body>
</html>
