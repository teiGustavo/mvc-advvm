let form = document.getElementById('form');
let statusCode = 200;

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(form.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
        .then((response) => {
            statusCode = response.status;

            return response.json();
        })
        .then((data) => {
            if (data.errors) {
                const errors = data.errors;

                form.classList.add('was-validated');

                if (errors.date) {
                    document.getElementById('date-feedback').innerHTML = errors.date;
                }

                if (errors.report) {                    
                    document.getElementById('report-feedback').innerHTML = errors.report;
                }

                if (errors.type) {                    
                    document.getElementById('type-feedback').innerHTML = errors.type;
                }

                if (errors.amount) {                    
                    document.getElementById('amount-feedback').innerHTML = errors.amount;
                }
            } 

            if (data.message) {
                let alert;

                if (statusCode === 201) {
                    alert = document.getElementById('success-alert');
                    
                    document.getElementById('date').value = ''
                    document.getElementById('report').value = ''
                    document.getElementById('amount').value = ''
                    document.getElementById('type').value = 'Automático'

                } else {
                    alert = document.getElementById('danger-alert');
                }

                alert.innerHTML = data.message;

                if (alert.classList.contains('d-none')) {
                    alert.classList.remove('d-none');

                    setTimeout(() => alert.classList.add('d-none'), 2000);
                }

                form.classList.remove('was-validated');
            }
        });
});