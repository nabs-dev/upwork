
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $budget = $_POST['budget'];
    $deadline = $_POST['deadline'];
    $category = $_POST['category'];
    $client_id = $_SESSION['id'];

    $conn->query("INSERT INTO jobs (client_id, title, description, budget, deadline, category) 
                  VALUES ('$client_id', '$title', '$desc', '$budget', '$deadline', '$category')");

    echo "<script>alert('Job Posted!'); window.location.href='dashboard_client.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post a Job</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
        }
        .header {
            background: #2d9cdb;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 26px;
        }
        .form-box {
            max-width: 700px;
            background: white;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.08);
        }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            margin-top: 20px;
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="header">Post a New Job</div>

<div class="form-box">
    <form method="POST">
        <label>Job Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description" rows="5" required></textarea>

        <label>Budget ($):</label>
        <input type="number" name="budget" required>

        <label>Deadline:</label>
        <input type="date" name="deadline" required>

        <label>Category:</label>
        <select name="category" required>
            <option value="Design">Design</option>
            <option value="Writing">Writing</option>
            <option value="Development">Development</option>
        </select>

        <button type="submit">Post Job</button>
    </form>
</div>

</body>
</html>
