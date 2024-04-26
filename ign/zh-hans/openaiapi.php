<?php
session_start();


// 初始化请求计数器
if (!isset($_SESSION['last_request_time'])) {
    $_SESSION['last_request_time'] = time();
    $_SESSION['request_count'] = 0;
}

// 检查请求频率
$currentTime = time();
$timeDiff = $currentTime - $_SESSION['last_request_time'];
$maxRequests = 20;
$timeSpan = 120; // 十分钟

if ($timeDiff > $timeSpan) {
    // 重置计数器和时间
    $_SESSION['request_count'] = 1;
    $_SESSION['last_request_time'] = $currentTime;
} else {
    $_SESSION['request_count']++;
    if ($_SESSION['request_count'] > $maxRequests) {
        die("请求过于频繁，请稍后再试。");
    }
}

$ch = curl_init();

curl_setopt_array($ch, array(
   CURLOPT_URL => 'https://agi.ylsap.com/tolinks/v1/chat/completions',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_POSTFIELDS =>'{
  "model": "gpt-3.5-turbo",
  "messages": [{"role": "user", "content": "您是一个专业、地道的Minecraft玩家档案名称生成器，只返回档案名称生成结果1个玩家档案名；注意，只有4~12个字符以内，一定要随机字符长度，且只有字母大小写，数字以及下划线，且不要有序号开头，就单纯一个档案名称，也不要说别的。"}]
}',
   CURLOPT_HTTPHEADER => array(
      'Accept: application/json',
      'Authorization: U2FsdGVkX19nEDWPvprok24/iQvyb7ETWjyCLdjYy4hilhgzyjT5hhDhVTv0etW2yXA7bWJZFx3bdWcurpytN2bhbK8Vx+UMYhHFzULYX73NH4e9qmKfC/R0uwKf+wBT',
      'User-Agent: Apifox/1.0.0 (https://apifox.com)',
      'Content-Type: application/json'
   ),
));

$response = curl_exec($ch);
curl_close($ch);


$responseData = json_decode($response, true);


$suggestedName = !empty($responseData['choices'][0]['message']['content']) ? trim($responseData['choices'][0]['message']['content']) : '';


if (empty($suggestedName)) {
    echo "连接OpenAI时繁忙";
} else {
    echo $suggestedName;
}

?>
