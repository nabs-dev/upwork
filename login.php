<?php
session_start();
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
    if ($check->num_rows == 1) {
        $row = $check->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        echo "<script>
            alert('Login Successful!');
            if ('{$row['role']}' == 'client') {
                window.location.href='dashboard_client.php';
            } else {
                window.location.href='dashboard_freelancer.php';
            }
        </script>";
    } else {
        echo "<script>alert('Invalid credentials!')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            background: #e6e9ef;
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
        input {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2 style="text-align:center;">Login</h2>
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Login</button>
    </form>
</body>
</html>
