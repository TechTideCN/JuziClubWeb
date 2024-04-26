function showNotification() {
        const notification = document.getElementById('notification');
        notification.style.display = 'block'; 
        setTimeout(() => {
            notification.style.opacity = 1; 
        }, 100); 

        setTimeout(() => {
            notification.style.opacity = 0; 
            setTimeout(() => notification.style.display = 'none', 2000); 
        }, 10000);
    }

    function detectLanguage() {
        const language = navigator.language;
        if (language.includes('zh-CN') || language.includes('zh-TW')) {
            showNotification();
        }
    }

    window.onload = detectLanguage;
    
    