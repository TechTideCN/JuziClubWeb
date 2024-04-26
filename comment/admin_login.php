<?php
session_start();

// 检查是否已登录
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: admin.php');
    exit;
}

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // 假设这是从数据库中检索到的散列密码
    $stored_hash = '$2y$10$somecrazystringsaltjuzi'; // 应从数据库中获取

    if ($username === 'juzi' && password_verify($password, $stored_hash)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: admin.php');
        exit;
    } else {
        $loginError = '无效的用户名或密码，请重新输入。';
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>管理员登录</title>
    <style>
        .login-container {
    width: 300px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    background-color: #5cb85c;
    color: white;
    cursor: pointer;
}

button:hover {
    background-color: #4cae4c;
}

.error {
    color: red;
    margin-bottom: 15px;
}

    </style>
</head>
<body>
    <div class="login-container">
        <h2>管理员登录</h2>
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <label for="username">用户名:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">密码:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <?php if ($loginError): ?>
                <p class="error"><?php echo $loginError; ?></p>
            <?php endif; ?>
            <button type="submit">登录</button>
        </form>
    </div>
</body>
</html>
