<?php
// 使用cURL获取用户IP属地信息
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://tenapi.cn/v2/getip");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['ip' => $_SERVER['REMOTE_ADDR']]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $data = json_decode($response, true);
    if ($data && $data['code'] == 200 && isset($data['data']['country'])) {
        $country = $data['data']['country'];
        $province = $data['data']['province'];

        // 根据国家或省份设置语言
        if ($country == "中国") {
            if (strpos($province, "台湾") !== false) {
                header("Location: https://juzi.club/ign/zh-hant/");
            } else if (strpos($province, "香港") !== false || strpos($province, "澳门") !== false) {
                header("Location: https://juzi.club/ign/zh-hant/");
            } else {
                header("Location: https://juzi.club/ign/zh-hans/");
            }
        } else if ($country == "日本") {
            header("Location: https://juzi.club/ign/ja-jp/");
        } else if ($country == "韩国") {
            header("Location: https://juzi.club/ign/ko-kr/");
        } else {
            header("Location: https://juzi.club/ign/en-us/");
        }
    } else {
        // 如果API没有返回国家信息，重定向到英文版
        header("Location: https://juzi.club/ign/en-us/");
    }
} else {
    // 如果请求失败，也重定向到英文版
    header("Location: https://juzi.club/ign/en-us/");
}
exit();
?>
