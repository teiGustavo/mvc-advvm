const form = document.getElementById('updateForm');
const dropdownPages = document.getElementById('dropdownPages');
const updateForm = document.getElementById('updateForm');

const updateButtons = document.querySelectorAll('[data-update]');
const deleteButtons = document.querySelectorAll('[data-delete]');

const tbody = document.getElementById('tbody');

let tr;

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
            .then((response) => response.json())
            .then((data) => {
                const report = data.report;

                if (report) {
                    document.getElementById('id').value = report.id;
                    document.getElementById('date').value = report.date;
                    document.getElementById('report').value = report.report;
                    document.getElementById('type').value = report.type;
                    document.getElementById('amount').value = report.amount;
                }
            });

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
        .then((response) => response.json())
        .then((data) => {
            const report = data.report;
            const td = tr.getElementsByTagName('td');

            document.getElementById('btnCloseUpdateModal').click();

            td[0].innerHTML = report.date;
            td[1].innerHTML = report.report;
            td[2].innerHTML = report.type;
            td[3].innerHTML = report.amount;
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
            .then((response) => response.json())
            .then((data) => {
                const isRemoved = data.remove;

                if (isRemoved === true) {
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
                }
            });
    });
};

document.querySelector(`.list-group-item-action[href='${location.href}']`).classList.add('active');