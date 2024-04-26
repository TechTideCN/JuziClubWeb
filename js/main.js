// 获取元素
const clubName = document.getElementById('clubName');
const guildName = document.getElementById('guildName');
const themeToggle = document.getElementById('themeToggle');
const sections = document.querySelectorAll('.main');

// 获取文本内容
const text = clubName.textContent;
const textGuilds = ['A Hypixel Guild', 'A Player Group','一个 Hypixel 公会'];
let currentGuildIndex = 0;

// 清空文本内容
clubName.textContent = '';
guildName.textContent = '';

// 遍历文本内容，为每个字添加 span 元素，并设置渐变动画
for (const char of text) {
    const span = document.createElement('span');
    span.textContent = char;
    span.style.animation = 'textGradient 20s infinite';
    clubName.appendChild(span);
}

// 切换公会名字的函数
function toggleGuildName() {
    const textGuild = textGuilds[currentGuildIndex];
    guildName.textContent = '';
    for (const char of textGuild) {
        const span = document.createElement('span');
        span.textContent = char;
        span.style.animation = 'textGradient 10s infinite';
        guildName.appendChild(span);
    }
    currentGuildIndex = (currentGuildIndex + 1) % textGuilds.length;
}

// 初始调用切换公会名字函数
toggleGuildName();

// 设置定时器，每隔一段时间切换公会名字
setInterval(toggleGuildName, 4000); // 每隔4秒切换一次公会名字
// 滚动到页面顶部时切换到相应页面
document.addEventListener('scroll', function() {
    sections.forEach(section => {
        const rect = section.getBoundingClientRect();
        if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
            window.scrollTo({
                top: section.offsetTop,
                behavior: 'smooth' // 平滑滚动
            });
        }
    });
});
