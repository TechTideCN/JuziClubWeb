<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // 使用 Mojang API 从用户名获取 UUID
    $uuidJson = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $username);
    $uuidData = json_decode($uuidJson, true);
    $uuid = $uuidData['id'];

    // 使用 UUID 获取皮肤信息
    $skinJson = file_get_contents('https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid);
    $skinData = json_decode($skinJson, true);
    $skinProperties = $skinData['properties'][0];
    $skinBase64 = $skinProperties['value'];
    $skinDecoded = base64_decode($skinBase64);
    $skinArray = json_decode($skinDecoded, true);
    $skinUrl = $skinArray['textures']['SKIN']['url'];

    // 返回皮肤 URL 的 JSON 数据
    header('Content-Type: application/json');
    echo json_encode(['skinUrl' => $skinUrl]);
}
?>
