<?php
session_start();

header('Content-Type: application/json');

// 定义速率限制参数
$limit = 30; // 限制请求次数
$period = 60; // 时间周期，以秒为单位
$cooldown = 300; // 冷却时间，超过限制后的等待时间

// 初始化或更新会话中的请求计数器和时间戳
if (!isset($_SESSION['requests_count']) || !isset($_SESSION['first_request_time'])) {
    $_SESSION['requests_count'] = 0;
    $_SESSION['first_request_time'] = time();
}

// 计算自第一次请求以来经过的时间
$timeSinceFirstRequest = time() - $_SESSION['first_request_time'];

// 检查是否达到冷却时间，如果是，则重置会话
if ($timeSinceFirstRequest > $cooldown) {
    $_SESSION['requests_count'] = 0;
    $_SESSION['first_request_time'] = time();
}

if (isset($_GET['ign'])) {
    if ($_SESSION['requests_count'] < $limit || $timeSinceFirstRequest > $period) {
        if ($timeSinceFirstRequest <= $period) {
            // 更新请求计数
            $_SESSION['requests_count']++;
        } else {
            // 超过时间周期，重置计数器和时间戳
            $_SESSION['requests_count'] = 1;
            $_SESSION['first_request_time'] = time();
        }

        $playerName = htmlspecialchars($_GET['ign']);
        $url = "https://api.mojang.com/users/profiles/minecraft/" . $playerName;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpcode == 200) {
            echo $result;
        } else {
            echo json_encode(["errorMessage" => "Couldn't find any profile with name $playerName"]);
        }
    } else {
        // 超过限制，显示404错误
        http_response_code(404);
        echo json_encode(["error" => "Request limit exceeded. Please wait a few minutes before trying again."]);
    }
} else {
    echo json_encode(["error" => "No IGN parameter provided."]);
}
?>
