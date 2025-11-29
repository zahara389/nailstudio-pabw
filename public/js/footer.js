
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

        // Listener untuk notifikasi yang membutuhkan redirect (Hanya terjadi saat BELUM LOGIN)
    Livewire.on('alert-redirect', (data) => {
        const message = data[0].message;
        const url = data[0].redirectUrl;

        // Tampilkan alert
        alert(message);

        // Redirect ke halaman login setelah user menekan OK
        window.location.href = url;
    });

    // Listener untuk notifikasi sukses/error yang TIDAK membutuhkan redirect (Terjadi saat SUDAH LOGIN)
    Livewire.on('alert-show', (data) => {
        const message = data[0].message;
        // Tampilkan alert sukses/error
        alert(message);
    });