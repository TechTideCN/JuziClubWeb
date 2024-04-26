<?php
require_once 'db.php';
require_once 'process_feedback.php';

// 获取HTTP头部的Referer值
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$refererHost = parse_url($referer, PHP_URL_HOST);

$whitelist = ['juziclub.net', 'juzi.club', 'join.juzi.club'];

// // 检查是否有引用页
// if ($refererHost != '填写你的嵌入页面域名') {
//     if (empty($referer)) {
//         echo '请您访问 <a href="你的嵌入网站页面网址">你的嵌入网站页面网址</a> 获取完整服务';
//         exit;
//     } else {
//         if (!in_array($refererHost, $whitelist)) {
//             header('Content-Security-Policy: frame-ancestors \'none\'');
//             echo '嵌入验证失败，您无法嵌入该页面，请访问 <a href="https://web.hypcvgm.top">https://web.hypcvgm.top</a>获取完整服务，或者联系管理员提供域名验证。';
//             exit;
//         }
//     }
// }
$ip = $_SERVER['REMOTE_ADDR'];
$canSubmit = checkIpLimit($ip);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户反馈</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto p-5">
        <div class="bg-white rounded-lg shadow p-6 space-y-6">
            <h2 class="text-xl font-bold">用户评论&反馈</h2>
            <h5>一个IP只能评论三次，超过三次需要等24小时之后才能评论。</h5>
            <?php if ($canSubmit): ?>
                <form action="process_feedback.php" method="POST" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">邮箱:</label>
                        <input type="email" name="email" id="email" required placeholder="输入邮箱地址" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700">评论:</label>
                        <textarea name="comment" id="comment" required minlength="5" placeholder="一个IP只能评论三次，评论至少要输入五个字" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                    <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">提交</button>
                </form>
            <?php else: ?>
                <p>您已达到今日评论次数限制，请24小时后再试。</p>
            <?php endif; ?>
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">评论&反馈</h3>
                <div class="space-y-4">
                    <?php
                    $comments = fetchComments();
                    foreach ($comments as $comment) {
                        echo "<div class='bg-gray-100 rounded-lg p-4 shadow'>";
                        echo "<p class='font-semibold'>" . htmlspecialchars($comment['email']) . "</p>";
                        echo "<p class='text-gray-700'>" . htmlspecialchars($comment['comment']) . "</p>";
                        echo "<p class='text-right text-xs text-gray-500'>用户IP: " . htmlspecialchars($comment['ip_address']) . "</p>";
                        if (isset($comment['ip_location'])) {
                            echo "<p class='text-right text-xs text-gray-500'>IP位置: " . htmlspecialchars($comment['ip_location']) . "</p>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
