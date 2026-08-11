
window.showBtnLoader = function showBtnLoader(element) {
    if (element) {
        let textElem = element.querySelector('.btn-text'),
            dotsLoader = element.querySelector('.dots-loader');
        
        if (!textElem && dotsLoader) return;

        element.disabled = true;
        element.classList.add("loading");

        if (textElem && dotsLoader) {
            textElem.classList.add("v-hidden");
            dotsLoader.classList.remove("v-hidden");
        }
    }
}

window.hideBtnLoader  = function hideBtnLoader(element) {
    if (element) {
        let textElem = element.querySelector('.btn-text'),
            dotsLoader = element.querySelector('.dots-loader');

        if (!textElem && dotsLoader) return;

        if (textElem && dotsLoader) {
            dotsLoader.classList.add("v-hidden");
            textElem.classList.remove("v-hidden");
        }

        element.removeAttribute("disabled");
        element.classList.remove("loading");
    }
}

window.initSubmitLoader = function initSubmit() {
    document.addEventListener("submit", function(e) {
        const form = e.target;

        if (form.tagName === "FORM") {
            const submitBtn = form.querySelector("button[type=submit]");
            if (submitBtn) {
                showBtnLoader(submitBtn);
            }
        }
    }, true);
};

window.initToggleViewPassword = function toggleViewPassword() {
    // Prevent Enter from triggering toggle
    document.addEventListener("keydown", function(e) {
        if (e.key === "Enter") {
            const activeElement = document.activeElement;
            if (activeElement && activeElement.closest(".password-toggle")) {
                e.preventDefault();
                e.stopPropagation();
            }
        }
    }, false);

    document.addEventListener("click", function(e) {
        const target = e.target;
        const toggleButton = target.closest(".password-toggle");
        const wrapper = target.closest(".password-input");

        if (!toggleButton || e.detail === 0) {
            return;
        }

        if (toggleButton && wrapper) {
            if (e instanceof KeyboardEvent && e.key === "Enter") {
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            const passwordInput = wrapper.querySelector("input");
            const iconView = wrapper.querySelector(".bi-eye-fill");
            const iconHide = wrapper.querySelector(".bi-eye-slash-fill");

            if (passwordInput && passwordInput.type === "password") {
                passwordInput.type = "text";
                if (iconView) iconView.style.display = "none";
                if (iconHide) iconHide.style.display = "block";
            } else {
                passwordInput.type = "password";
                if (iconView) iconView.style.display = "block";
                if (iconHide) iconHide.style.display = "none";
            }
        }
    }, false);
}

window.forcePageReload = function forcePageReload() {
    setTimeout(() => {
        window.location.reload();
    }, 1500);
}


document.addEventListener("DOMContentLoaded", function() {
    initSubmitLoader();
    initToggleViewPassword();
});

