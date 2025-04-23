<?php
session_start();
include 'db.php';

$category = isset($_GET['category']) ? $_GET['category'] : '';
$jobs_query = $category 
    ? "SELECT * FROM jobs WHERE category='$category' ORDER BY id DESC" 
    : "SELECT * FROM jobs ORDER BY id DESC";
$jobs = $conn->query($jobs_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upwork Clone - Home</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f2f4f8;
        }
        .header {
            background: #2d9cdb;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
        }
        .nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            background: #e3eaf3;
            padding: 10px;
        }
        .nav button {
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: bold;
        }
        .nav button:hover {
            background: #d0e7f9;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }
        .job-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            padding: 20px;
        }
        .job-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }
        .job-desc {
            margin-top: 10px;
            color: #666;
        }
        .job-meta {
            margin-top: 15px;
            font-size: 14px;
            color: #888;
        }
        .apply-btn {
            margin-top: 15px;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
        }
        .apply-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="header">Upwork Clone</div>

<div class="nav">
    <button onclick="filterCategory('')">All</button>
    <button onclick="filterCategory('Design')">Design</button>
    <button onclick="filterCategory('Writing')">Writing</button>
    <button onclick="filterCategory('Development')">Development</button>
    <?php if (!isset($_SESSION['id'])) { ?>
        <button onclick="goTo('signup.php')">Sign Up</button>
        <button onclick="goTo('login.php')">Login</button>
    <?php } else { ?>
        <button onclick="goTo('dashboard_<?php echo $_SESSION['role']; ?>.php')">Dashboard</button>
        <button onclick="goTo('logout.php')">Logout</button>
    <?php } ?>
</div>

<div class="container">
    <?php while($row = $jobs->fetch_assoc()) { ?>
        <div class="job-card">
            <div class="job-title"><?= htmlspecialchars($row['title']) ?></div>
            <div class="job-desc"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
            <div class="job-meta">
                Budget: <strong>$<?= $row['budget'] ?></strong> &nbsp; | &nbsp;
                Deadline: <?= $row['deadline'] ?> &nbsp; | &nbsp;
                Category: <?= $row['category'] ?>
            </div>
            <button class="apply-btn" onclick="goTo('submit_proposal.php?job_id=<?= $row['id'] ?>')">Apply Now</button>
        </div>
    <?php } ?>
</div>

<script>
    function filterCategory(cat) {
        window.location.href = 'index.php' + (cat ? '?category=' + cat : '');
    }
    function goTo(page) {
        window.location.href = page;
    }
</script>

</body>
</html>
