<?php

$cacheFile = 'cached_data.json';
$cacheTime = 3600;

// 忽略用户中断，允许脚本在用户断开连接后继续运行
ignore_user_abort(true);

// 检查缓存文件是否存在
if (file_exists($cacheFile)) {
    $lastModified = filemtime($cacheFile);
    $currentTime = time();
    $timeDiff = $currentTime - $lastModified;

    // 检查时间差是否超过缓存时间
    if ($timeDiff > $cacheTime) {
        // 需要刷新缓存，但首先发送当前缓存的内容
        $cachedData = file_get_contents($cacheFile);
        $output = json_decode($cachedData, true);
        
        if (is_null($output) || empty($output)) {
            echo "Notice: Cache file exists but contains invalid or empty JSON. Fetching new data.\n";
        } else {
            // 输出旧的缓存数据
            echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            // 准备在后台更新数据
            $needRefresh = true;
        }
    } else {
        // 使用缓存的数据
        $cachedData = file_get_contents($cacheFile);
        $output = json_decode($cachedData, true);
        echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
} else {
    echo "Cache file does not exist. Fetching new data.\n";
    $needRefresh = true;
}

if (isset($needRefresh) && $needRefresh) {
    // 完成请求，继续后台执行
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }
    
    // 读取远程JSON数据
    $remoteData = file_get_contents("https://api.hypcvgm.top/guild_players.json");
    if ($remoteData === false) {
        echo "Error: Unable to fetch remote data.\n";
        exit;
    }

    $data = json_decode($remoteData, true);
    if (is_null($data)) {
        echo "Error: Remote data is not valid JSON.\n";
        exit;
    }

    $output = [];
    $rankPriority = [
        'Guild Master' => 1,
        '副会长' => 2,
        '公会骨干' => 3,
        '公会高管' => 4,
        '公会协管' => 5,
        '公会成员' => 6
    ];

    foreach ($data as $player) {
        $uuid = $player['uuid'];
        $mojangApiUrl = "https://sessionserver.mojang.com/session/minecraft/profile/$uuid";
        $mojangResponse = file_get_contents($mojangApiUrl);
        if ($mojangResponse === false) {
            continue;
        }

        $mojangData = json_decode($mojangResponse, true);
        if (!isset($mojangData['name'])) {
            continue;
        }

        $minecraftName = $mojangData['name'];
        $rank = json_decode('"' . $player['rank'] . '"');
        $joined = date('Y年m月d日H时i分s秒', $player['joined'] / 1000);

        $output[] = [
            'name' => $minecraftName,
            'rank' => $rank,
            'joined' => $joined,
            'rankPriority' => $rankPriority[$rank]
        ];
    }

    // 对输出进行排序
    usort($output, function($a, $b) use ($rankPriority) {
        return $rankPriority[$a['rank']] - $rankPriority[$b['rank']];
    });

    // 移除临时排序键
    foreach ($output as &$player) {
        unset($player['rankPriority']);
    }

    // 保存新的数据到缓存文件
    file_put_contents($cacheFile, json_encode($output, JSON_UNESCAPED_UNICODE));
}

?>
