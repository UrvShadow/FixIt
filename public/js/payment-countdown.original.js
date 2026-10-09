(() => {
    document.querySelectorAll("[data-payment-countdown]").forEach((timerElement) => {
        const valueElement = timerElement.querySelector(".payment-countdown-value");
        const messageElement = timerElement.querySelector(".payment-countdown-message");

        const expiresAt = Number(timerElement.dataset.expiresAt);
        const format = timerElement.dataset.format || "minutes";
        const warningMessage = timerElement.dataset.warningMessage;
        const expiredMessage = timerElement.dataset.expiredMessage;

        let intervalId = null;
        let expired = false;

        const formatTime = (remainingSeconds) => {
            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;

            const pad = (number) => String(number).padStart(2, "0");

            if (format === "hours") {
                return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
            }

            const totalMinutes = Math.floor(remainingSeconds / 60);
            return `${pad(totalMinutes)}:${pad(seconds)}`;
        };

        const disableElement = (element) => {
            if (element instanceof HTMLButtonElement ||
                element instanceof HTMLInputElement) {
                element.disabled = true;
                return;
            }

            element.setAttribute("aria-disabled", "true");
            element.classList.add("is-disabled");

            element.addEventListener("click", (event) => {
                event.preventDefault();
            }, true);
        };

        const expire = () => {
            if (expired) return;

            expired = true;
            timerElement.classList.remove("is-warning");
            timerElement.classList.add("is-expired");

            if (valueElement) {
                valueElement.textContent = formatTime(0);
            }

            if (messageElement) {
                messageElement.textContent =
                    expiredMessage || "This payment session has expired.";
            }

            const buttonSelector = timerElement.dataset.buttonTarget;

            if (buttonSelector) {
                document.querySelectorAll(buttonSelector).forEach(disableElement);
            }

            const disableSelector = timerElement.dataset.disableSelector;

            if (disableSelector) {
                document.querySelectorAll(disableSelector).forEach(disableElement);
            }

            if (intervalId !== null) {
                clearInterval(intervalId);
            }
        };

        if (!Number.isFinite(expiresAt) || expiresAt <= 0 || !valueElement) {
            if (valueElement) valueElement.textContent = "--:--:--";

            if (messageElement) {
                messageElement.textContent =
                    "The payment session deadline is unavailable. Please reopen the payment page.";
            }

            timerElement.classList.add("is-expired");
            return;
        }

        const updateCountdown = () => {
            const remainingSeconds = Math.max(
                0,
                Math.floor(expiresAt - Date.now() / 1000)
            );

            valueElement.textContent = formatTime(remainingSeconds);

            if (remainingSeconds <= 0) {
                expire();
                return;
            }

            if (remainingSeconds <= 300) {
                timerElement.classList.add("is-warning");

                if (messageElement && warningMessage) {
                    messageElement.textContent = warningMessage;
                }
            } else {
                timerElement.classList.remove("is-warning");
            }
        };

        updateCountdown();

        if (!expired) {
            intervalId = setInterval(updateCountdown, 1000);
        }
    });
})();