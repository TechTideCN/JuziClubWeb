<?php
require_once 'db.php'; // 引入数据库连接文件
session_start();

// 简单的管理员验证
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'szez') {
    header('Location: admin_login.php'); // 重定向到登录页面
    exit;
}

// 获取所有评论
$comments = fetchAllComments();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>管理员页面</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
            <div class="mb-4">
                <h2 class="block text-gray-700 text-xl font-bold mb-2">评论管理</h2>
                <a href="logout.php" class="text-sm text-blue-500 hover:text-blue-800">退出登录</a>
            </div>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            邮箱
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            评论
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php echo htmlspecialchars($comment['email']); ?>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php echo htmlspecialchars($comment['comment']); ?>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <form action="admin_process.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                                <input type="text" name="comment" value="<?php echo htmlspecialchars($comment['comment']); ?>" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <button type="submit" name="delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    删除
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
