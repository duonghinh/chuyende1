function subscribeNewsletter() {
    const emailInput = document.getElementById('newsletterEmail');
    const messageBox = document.getElementById('newsletterMessage');
    const email = emailInput.value.trim();
    const btn = event.currentTarget;

    if (!email) {
        alert('Vui lòng nhập email!');
        return;
    }

    const originalIcon = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    btn.disabled = true;
    messageBox.innerHTML = '';

    fetch(window.appConfig.routes.newsletter, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ email: email })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = originalIcon;
        btn.disabled = false;
        if (data.success) {
            messageBox.className = 'd-block mt-2 text-success fw-bold';
            messageBox.innerText = data.message;
            emailInput.value = '';
        } else {
            messageBox.className = 'd-block mt-2 text-danger';
            messageBox.innerText = data.message;
        }
    })
    .catch(err => {
        btn.innerHTML = originalIcon;
        btn.disabled = false;
        messageBox.className = 'd-block mt-2 text-danger';
        messageBox.innerText = 'Lỗi hệ thống. Vui lòng thử lại sau.';
    });
}