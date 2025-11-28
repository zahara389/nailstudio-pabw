
        // --- MESSAGE HANDLER (Replaces alert()) ---
        function showMessage(text) {
            const box = document.getElementById('message-box');
            box.innerText = text;
            box.classList.remove('ns-opacity-0', 'ns-pointer-events-none');
            box.classList.add('ns-opacity-100');
            setTimeout(() => {
                box.classList.remove('ns-opacity-100');
                box.classList.add('ns-opacity-0');
                setTimeout(() => {
                    box.classList.add('ns-pointer-events-none');
                }, 300);
            }, 3000);
        }

        // --- FORM HANDLER (Simulasi) ---
        function handleSubscription(event) {
            event.preventDefault();
            const emailInput = event.target.querySelector('.ns-newsletter-input').value;
            showMessage(`Simulasi: Terima kasih! Email "${emailInput}" telah didaftarkan.`);
        }