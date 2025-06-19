const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
});

// Добавляем анимацию при загрузке страницы
document.addEventListener("DOMContentLoaded", () => {
    // Плавное появление форм
    document.querySelector(".signin-signup").style.opacity = "0";
    setTimeout(() => {
        document.querySelector(".signin-signup").style.opacity = "1";
    }, 200);

    // Анимация появления панелей
    const panels = document.querySelectorAll(".panel");
    panels.forEach(panel => {
        panel.style.transform = "translateX(100px)";
        panel.style.opacity = "0";
    });

    setTimeout(() => {
        panels.forEach(panel => {
            panel.style.transform = "translateX(0)";
            panel.style.opacity = "1";
            panel.style.transition = "all 0.8s ease-out";
        });
    }, 300);
});

// Добавляем эффект при наведении на кнопки
const buttons = document.querySelectorAll(".btn");
buttons.forEach(button => {
    button.addEventListener("mouseover", () => {
        button.style.transform = "scale(1.05)";
    });
    
    button.addEventListener("mouseout", () => {
        button.style.transform = "scale(1)";
    });
});

// Анимация fade перехода между login и register
function fadeTransition(linkSelector) {
    document.querySelectorAll(linkSelector).forEach(link => {
        link.addEventListener('click', function(e) {
            const box = document.querySelector('.auth-box');
            if (box) {
                e.preventDefault();
                box.classList.add('fade-exit-active');
                setTimeout(() => {
                    window.location.href = link.href;
                }, 500);
            }
        });
    });
}

// Применяем fade к ссылкам входа/регистрации
fadeTransition('.auth-links a'); 