let form = document.getElementById('form');

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(form.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById('date').value = ''
            document.getElementById('report').value = ''
            document.getElementById('amount').value = ''
            document.getElementById('type').value = 'Automático'
        });
});