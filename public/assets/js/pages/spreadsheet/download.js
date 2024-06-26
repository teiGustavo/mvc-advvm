const form = document.getElementById('form');
const selectYear = document.getElementById('selectYear');
const selectMonth = document.getElementById('selectMonth');
const button = document.getElementById('button');

selectYear.addEventListener('change', () => {
    const formData = new FormData(form);

    fetch(selectYear.getAttribute('data-action'), {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then((data) => {
            const months = data.months;

            if (months) {
                selectMonth.removeAttribute('disabled');
                selectMonth.innerHTML = '';
                selectMonth.style.cursor = 'pointer';

                months.forEach(month => {
                    const option = new Option(month, month);

                    selectMonth.add(option);
                });

                button.removeAttribute('disabled');
                button.style.cursor = 'pointer';
            } else {
                button.setAttribute('disabled', 'true');
                button.style.cursor = 'not-allowed';

                selectMonth.setAttribute('disabled', 'true');
                selectMonth.innerHTML = '<option selected>Selecione o mês</option>';
                selectMonth.style.cursor = 'not-allowed';
            }
        });
});

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(form.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then((data) => {
            window.location = data.download_url;
        });
});