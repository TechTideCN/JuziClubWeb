<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minecraft | 編輯檔案名稱查詢</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" type="image/x-icon"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/favicon.ico" />
    <link rel="icon" type="image/x-icon"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/favicon.ico" />

    <link rel="icon" type="image/png" sizes="192x192"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/android-icon-192x192.png" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="96x96"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/favicon-96x96.png" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/favicon-16x16.png" />

    <link rel="apple-touch-icon" sizes="57x57"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://www.minecraft.net/etc.clientlibs/minecraft/clientlibs/main/resources/apple-icon-180x180.png" />
    <script>
        function validateInput() {
            const inputValue = document.getElementById('javaProfileName').value;
            const messageBox = document.getElementById('messageBox');
            const message = document.getElementById('message');
            const submitButton = document.getElementById('submitButton');

            messageBox.style.display = 'none';

            if (inputValue.length === 0) {
                submitButton.disabled = true;
                return;
            }

            if (/^[a-zA-Z0-9_]{1,3}$/.test(inputValue)) {
                message.textContent = '您的檔案名稱必須至少包含 4 個字元';
                messageBox.className = 'p-4 border-l-4 border-red-500 bg-red-100 rounded-r shadow-md';
                messageBox.style.display = 'block';
                submitButton.disabled = true;
            } else if (!/^[a-zA-Z0-9_]+$/.test(inputValue)) {
                message.textContent = '您的檔案名稱僅能包含字母、數字和底線';
                messageBox.className = 'p-4 border-l-4 border-red-500 bg-red-100 rounded-r shadow-md';
                messageBox.style.display = 'block';
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }

        function checkIGN(event) {
            event.preventDefault();
            const ign = document.getElementById('javaProfileName').value;
            const messageBox = document.getElementById('messageBox');
            const message = document.getElementById('message');

            if (ign.length === 0) {
                return;
            }

            if (ign.length > 3 && /^[a-zA-Z0-9_]+$/.test(ign)) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `https://juzi.club/ign.php?ign=${ign}`, true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        const data = JSON.parse(this.responseText);
                        messageBox.style.display = 'block';
                        if (data.id) {
                            message.textContent = '此檔案名稱已存在';
                            messageBox.className = 'p-4 border-l-4 border-red-500 bg-red-100 rounded-r shadow-md';
                        } else {
                            message.textContent = '此檔案名稱未使用，您可以使用此檔案名稱';
                            messageBox.className = 'p-4 border-l-4 border-green-500 bg-green-100 rounded-r shadow-md';
                        }
                    } else {
                        messageBox.style.display = 'block';
                        message.textContent = '發生錯誤，請稍後再試';
                        messageBox.className = 'p-4 border-l-4 border-yellow-500 bg-yellow-100 rounded-r shadow-md';
                    }
                }
                xhr.send();
            }
        }
    </script>
    
</head>

<body class="bg-gray-100">
    <main class="flex-grow">
        <div class="max-w-lg mx-auto py-12">
            <div class="bg-white p-8 border border-gray-200">
                <img class="mc-globalheader__logo"
                    src="https://www.minecraft.net/content/dam/games/minecraft/logos/logo-minecraft.svg"
                    alt="Minecraft 徽標 ">
                <h2 class="text-xl font-bold mb-4"></h2>
                <h2 class="text-xl font-bold mb-4">Minecraft | 編輯檔案名稱查詢</h2>
                <p class="text-gray-700 mb-4">在您修改您的遊戲檔案名稱時，您可以在這裡查詢你的檔案名稱是否已存在</p>
                <form onsubmit="checkIGN(event)">
                    <label for="javaProfileName"
                        class="block text-gray-700 text-sm font-bold mb-2">請在這裡輸入你想要的檔案名稱</label>
                    <input type="text" id="javaProfileName" name="javaProfileName" autocomplete="off"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="僅限JAVA 檔案名稱查詢" onkeyup="validateInput()">

                    <div id="messageBox" class="hidden mt-4">
                        <p id="message"></p>
                    </div>

                    <button type="submit" id="submitButton"
                        class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        點擊查詢
                    </button>
                </form>
                <div class="mt-4">
                    <select id="languageSelector" onchange="changeLanguage()"
                        class="bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 rounded focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="Language">語言選擇</option>
                        <option value="zh-CN">简体中文</option>
                        <option value="zh-TW">繁體中文</option>
                        <option value="ja">日本語</option>
                        <option value="en">English</option>
                        <option value="ko">한국어</option>
                    </select>
                </div>
            </div>
            <p class="text-center mt-4">© JCLY TEAM 此網站與Mojang AB沒有任何從屬關係</p>
        </div>
    </main>
      <script>
          function changeLanguage() {
            var selectedLanguage = document.getElementById("languageSelector").value;
            switch(selectedLanguage) {
              case 'zh-CN':
                window.location.href = 'https://juzi.club/ign/zh-hans/';
                break;
              case 'zh-TW':
                window.location.href = 'https://juzi.club/ign/zh-hant/';
                break;
              case 'ja':
                window.location.href = 'https://juzi.club/ign/ja-jp/';
                break;
              case 'en':
                window.location.href = 'https://juzi.club/ign/en-us/';
                break;
              case 'ko':
                window.location.href = 'https://juzi.club/ign/ko-kr/';
                break;
            }
          }
        </script>
</body>

</html>