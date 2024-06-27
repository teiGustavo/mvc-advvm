const dropdownPages = document.getElementById('dropdownPages');
const updateForm = document.getElementById('updateForm');

const updateButtons = document.querySelectorAll('[data-update]');
const deleteButtons = document.querySelectorAll('[data-delete]');

const tbody = document.getElementById('tbody');

let tr;
let statusCode;

dropdownPages.addEventListener('click', () => {
    document.querySelector(`.active[href='${location.href}']`).focus();
});

for (const updateButton of updateButtons) {
    updateButton.addEventListener('click', (e) => {
        e.preventDefault();

        const url = updateButton.getAttribute('data-target');
        const formData = new FormData();

        formData.append('id', updateButton.getAttribute('data-update'));

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then((response) => {
                statusCode = response.status;

                return response.json();
            })
            .then((data) => {
                const btnSubmit = document.getElementById('btnSubmitUpdateModal');
                const report = data.report;
                const alert = document.getElementById('danger-alert');
                const inputId = document.getElementById('id');
                const inputDate = document.getElementById('date');
                const inputReport = document.getElementById('report');
                const inputType = document.getElementById('type');
                const inputAmount = document.getElementById('amount');

                function toggleAttributes() {
                    btnSubmit.toggleAttribute('disabled');

                    inputId.toggleAttribute('disabled');
                    inputDate.toggleAttribute('disabled');
                    inputReport.toggleAttribute('disabled');
                    inputType.toggleAttribute('disabled');
                    inputAmount.toggleAttribute('disabled');
                }

                if (statusCode !== 200) {
                    alert.innerHTML = data.message;

                    if (alert.classList.contains('d-none')) {
                        alert.classList.remove('d-none');

                        toggleAttributes();
                    }

                    inputId.value = '';
                    inputDate.value = '';
                    inputReport.value = '';
                    inputType.value = '';
                    inputAmount.value = '';
                } else {
                    if (!alert.classList.contains('d-none')) {
                        alert.classList.add('d-none');

                        toggleAttributes();
                    }

                    inputId.value = report.id;
                    inputDate.value = report.date;
                    inputReport.value = report.report;
                    inputType.value = report.type;
                    inputAmount.value = report.amount;

                    if (updateForm.classList.contains('was-validated')) {
                        updateForm.classList.remove('was-validated')
                    }
                }
            })

        tr = updateButton.parentElement.parentElement;
    });
};

updateForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const url = updateForm.getAttribute('action');
    const formData = new FormData(updateForm);

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then((response) => {
            statusCode = response.status;

            return response.json();
        })
        .then((data) => {
            const alert = document.getElementById('danger-alert');
            const tableAlert = document.getElementById('success-table-alert');
            const report = data.report;
            const td = tr.getElementsByTagName('td');

            if (data.errors) {
                const errors = data.errors;

                updateForm.classList.add('was-validated');

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

            if (statusCode === 500) {
                alert.innerHTML = data.message;

                if (alert.classList.contains('d-none')) {
                    alert.classList.remove('d-none');

                    setTimeout(() => alert.classList.add('d-none'), 2000);
                }
            } else if (statusCode === 200) {
                document.getElementById('btnCloseUpdateModal').click();

                tableAlert.innerHTML = 'Atualizado com sucesso!';
                tableAlert.classList.toggle('d-none');
                setTimeout(() => tableAlert.classList.toggle('d-none'), 2000);

                td[0].innerHTML = report.date;
                td[1].innerHTML = report.report;
                td[2].innerHTML = report.type;
                td[3].innerHTML = report.amount;

                updateForm.classList.remove('was-validated');
            }
        });
});

for (const deleteButton of deleteButtons) {
    deleteButton.addEventListener('click', (e) => {
        e.preventDefault();

        const url = deleteButton.getAttribute('data-target');
        const formData = new FormData();

        formData.append('id', deleteButton.getAttribute('data-delete'));

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then((response) => {
                statusCode = response.status;
            })
            .then(() => {
                if (statusCode === 204) {
                    function fadeOut(element) {
                        element.style.opacity = 1;

                        let opacity = 1;
                        const interval = setInterval(() => {
                            opacity -= 0.25;
                            element.style.opacity = opacity;

                            if (opacity <= 0) {
                                clearInterval(interval);
                                element.remove();

                                if (tbody.childElementCount <= 0) {
                                    document.getElementById('previousPageButton').click();
                                }
                            }
                        }, 50);
                    }

                    fadeOut(deleteButton.parentNode.parentNode);

                } else {
                    const alert = document.getElementById('danger-table-alert');

                    alert.innerHTML = 'Não foi possível excluir este lançamento!';
                    alert.classList.toggle('d-none');
                    setTimeout(() => alert.classList.toggle('d-none'), 2000);
                }
            });
    });
};

document.querySelector(`.list-group-item-action[href='${location.href}']`).classList.add('active');