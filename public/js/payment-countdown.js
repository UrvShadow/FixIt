(() => {
    "use strict";

    const initializePaymentCountdowns = () => {
        const timers = document.querySelectorAll(
            "[data-payment-countdown]"
        );

        timers.forEach((timerElement) => {
            // Prevent duplicate timers if the script initializes twice.
            if (timerElement.dataset.countdownInitialized === "true") {
                return;
            }

            timerElement.dataset.countdownInitialized = "true";

            const valueElement = timerElement.querySelector(
                ".payment-countdown-value"
            );

            const messageElement = timerElement.querySelector(
                ".payment-countdown-message"
            );

            const rawExpiresAt = timerElement.dataset.expiresAt;
            const expiresAt = rawExpiresAt?.trim()
                ? Number(rawExpiresAt)
                : NaN;

            const format = timerElement.dataset.format || "minutes";

            const warningMessage =
                timerElement.dataset.warningMessage ||
                "Less than five minutes remain.";

            const expiredMessage =
                timerElement.dataset.expiredMessage ||
                "This payment session has expired.";

            const initialMessage = messageElement?.textContent.trim() || "";

            let intervalId = null;
            let expired = false;

            const pad = (number) =>
                String(number).padStart(2, "0");

            const formatTime = (remainingSeconds) => {
                const hours = Math.floor(remainingSeconds / 3600);
                const minutes = Math.floor(
                    (remainingSeconds % 3600) / 60
                );
                const seconds = remainingSeconds % 60;

                if (format === "hours") {
                    return [
                        pad(hours),
                        pad(minutes),
                        pad(seconds),
                    ].join(":");
                }

                const totalMinutes = Math.floor(
                    remainingSeconds / 60
                );

                return `${pad(totalMinutes)}:${pad(seconds)}`;
            };

            const disableElement = (element) => {
                if (
                    element instanceof HTMLButtonElement ||
                    element instanceof HTMLInputElement
                ) {
                    element.disabled = true;
                    return;
                }

                // Handle links such as the bank-verification link.
                element.setAttribute("aria-disabled", "true");
                element.classList.add("is-disabled");
                element.setAttribute("tabindex", "-1");

                // Attach this handler only once per element.
                if (element.dataset.paymentDisabled !== "true") {
                    element.dataset.paymentDisabled = "true";

                    element.addEventListener(
                        "click",
                        (event) => {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                        },
                        true
                    );
                }
            };

            const disableTargets = () => {
                const selectors = [
                    timerElement.dataset.buttonTarget,
                    timerElement.dataset.disableSelector,
                ].filter(Boolean);

                selectors.forEach((selector) => {
                    try {
                        const targets = document.querySelectorAll(selector);

                        targets.forEach(disableElement);

                        if (targets.length === 0) {
                            console.warn(
                                `[Payment Countdown] No elements matched: ${selector}`
                            );
                        }
                    } catch (error) {
                        console.error(
                            `[Payment Countdown] Invalid selector: ${selector}`,
                            error
                        );
                    }
                });
            };

            const stopCountdown = () => {
                if (intervalId !== null) {
                    clearInterval(intervalId);
                    intervalId = null;
                }
            };

            const markExpired = (
                message = expiredMessage,
                showZero = true
            ) => {
                if (expired) {
                    return;
                }

                expired = true;

                timerElement.classList.remove("is-warning");
                timerElement.classList.add("is-expired");

                if (valueElement) {
                    valueElement.textContent = showZero
                        ? formatTime(0)
                        : "--:--:--";
                }

                if (messageElement) {
                    messageElement.textContent = message;
                }

                disableTargets();
                stopCountdown();
            };

            // A missing deadline must fail safely.
            if (
                !Number.isFinite(expiresAt) ||
                expiresAt <= 0 ||
                !valueElement
            ) {
                console.error(
                    "[Payment Countdown] Missing or invalid deadline.",
                    {
                        rawExpiresAt,
                        timerElement,
                    }
                );

                markExpired(
                    "Payment deadline unavailable. Please reopen the payment page.",
                    false
                );

                return;
            }

            const updateCountdown = () => {
                // The server sends a Unix timestamp in seconds.
                const remainingSeconds = Math.max(
                    0,
                    Math.ceil(expiresAt - Date.now() / 1000)
                );

                valueElement.textContent =
                    formatTime(remainingSeconds);

                if (remainingSeconds <= 0) {
                    markExpired();
                    return;
                }

                if (remainingSeconds <= 300) {
                    timerElement.classList.add("is-warning");

                    if (messageElement) {
                        messageElement.textContent = warningMessage;
                    }
                } else {
                    timerElement.classList.remove("is-warning");

                    if (messageElement) {
                        messageElement.textContent = initialMessage;
                    }
                }
            };

            // Update immediately, then every second.
            updateCountdown();

            if (!expired) {
                intervalId = setInterval(updateCountdown, 1000);
            }
        });
    };

    if (document.readyState === "loading") {
        document.addEventListener(
            "DOMContentLoaded",
            initializePaymentCountdowns,
            { once: true }
        );
    } else {
        initializePaymentCountdowns();
    }
})();