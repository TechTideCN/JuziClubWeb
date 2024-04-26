<?php
require_once 'db.php'; // 引入数据库连接和操作的函数

// 获取IP地址的地理位置
function getIpLocation($ip) {
    $apiUrl = "https://tenapi.cn/v2/getip";
    $postData = http_build_query(['ip' => $ip]);
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $postData,
        ]
    ]);
    $response = file_get_contents($apiUrl, false, $context);
    $data = json_decode($response, true);
    if (isset($data['code']) && $data['code'] == 200 && isset($data['data'])) {
        return $data['data']['area'] ?? '未知位置';
    }
    return '未知位置';
}

function setCommentCookie($ip) {
    $cookieName = "comment_limit_" . md5($ip);
    setcookie($cookieName, 1, time() + 86400); // 设置24小时后过期
}

function incrementCommentCount($ip) {
    $cookieName = "comment_limit_" . md5($ip);
    if (isset($_COOKIE[$cookieName])) {
        $newCount = $_COOKIE[$cookieName] + 1;
        setcookie($cookieName, $newCount, time() + 86400);
        return $newCount;
    }
    return 1;
}

function checkCommentLimit($ip) {
    $cookieName = "comment_limit_" . md5($ip);
    return isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName] >= 3;
}

// 检查表单是否提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $comment = $_POST['comment'] ?? null;
    $ip = $_SERVER['REMOTE_ADDR'];

    // 检查IP地址评论次数限制
    if (checkCommentLimit($ip)) {
        $error = '您已达到每日评论次数限制。请24小时后再试。';
    } else {
        $ipLocation = getIpLocation($ip);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = '无效的邮箱地址。';
        } elseif (strlen($comment) < 5) {
            $error = '评论内容至少需要5个字符。';
        } else {
            // 保存数据到数据库
            saveComment($email, $comment, $ip, $ipLocation);
            $newCount = incrementCommentCount($ip);
            if ($newCount >= 3) {
                setCommentCookie($ip); // 限制用户评论
            }
            header('Location: index.php');
            exit;
        }
    }
}

// 如果有错误，回到首页并显示错误信息
if (isset($error)) {
    header("Location: index.php?error=" . urlencode($error));
    exit;
}
?>
