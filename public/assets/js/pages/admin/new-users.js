const updateButtons = document.querySelectorAll('[data-update]');
const deleteButtons = document.querySelectorAll('[data-delete]');
const updateUserForm = document.getElementById('updateUserForm');

let tr;

for (const updateButton of updateButtons) {
    updateButton.addEventListener('click', (e) => {
        e.preventDefault();

        const url = updateButton.getAttribute('href');
        const formData = new FormData();

        formData.append('id', updateButton.getAttribute('data-update'));

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then((response) => response.json())
            .then((data) => {
                const user = data.user;

                if (user) {
                    document.getElementById('id').value = user.id;
                    document.getElementById('role').value = user.adm;
                }
            });

        tr = updateButton.parentElement.parentElement;
    });
};

updateUserForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const url = updateUserForm.getAttribute('action');
    const formData = new FormData(updateUserForm);

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then((data) => {
            const user = data.user;
            const td = tr.getElementsByTagName('td');

            document.getElementById('btnCloseUserUpdateModal').click();

            if (user) {
                td[1].innerHTML = user.role;
            }
        });
});

for (const deleteButton of deleteButtons) {
    deleteButton.addEventListener('click', (e) => {
        e.preventDefault();

        const url = deleteButton.getAttribute('href');
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
                            }
                        }, 50);
                    }

                    fadeOut(deleteButton.parentNode.parentNode);
                }
            });
    });
};