const form = document.getElementById('form');
const redefinePasswordModal = new bootstrap.Modal(document.getElementById('redefinePasswordModal'));
const redefinePasswordForm = document.getElementById('redefinePasswordForm');
const inputEmail = document.getElementById('email');

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(form.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then((data) => {
            const user = data.user;

            if (user) {
                redefinePasswordModal.show();
            }
        });
});

redefinePasswordForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(redefinePasswordForm);

    formData.append('email', inputEmail.value);

    fetch(redefinePasswordForm.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then((data) => {
            const user = data.user;

            if (user) {
                redefinePasswordModal.hide();
                document.getElementById('return').click();
            }
        });
});