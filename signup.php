<?php
session_start();
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists!')</script>";
    } else {
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
        echo "<script>alert('Signup successful!'); window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 350px;
        }
        input, select {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2 style="text-align:center;">Create Account</h2>
        <input type="text" name="name" required placeholder="Full Name">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <select name="role" required>
            <option value="">Choose Role</option>
            <option value="client">Client</option>
            <option value="freelancer">Freelancer</option>
        </select>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
