document.addEventListener('DOMContentLoaded', () => {
    const containerUsers = document.getElementById('tbody');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages;

    fetch('../../php/users.php')
        .then(res => res.json())
        .then(data => {
            const users = data;
            
            totalPages = Math.ceil(users.length / itemsPerPage);

            function renderPage(page) {
                containerUsers.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = users.slice(start, end);

                pageItems.forEach(user => {
                    const trUser = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdNameUser = document.createElement('td');
                    const tdUserRole = document.createElement('td');
                    const tdActions = document.createElement('td');

                    tdId.textContent = user['id_usuario'];
                    tdNameUser.textContent = user['nome'];

                    if(user['role_id'] == 0){
                        tdUserRole.textContent = "Administrador";
                    }else if(user['role_id'] == 1){
                        tdUserRole.textContent = "Usuário";
                    }

                    const editLink = document.createElement('a');
                    editLink.textContent = 'Editar';
                    editLink.className = 'text-deco-none cursor-pointer';
                    editLink.style.marginRight = '20px';
                    editLink.addEventListener('click', () => {
                        document.getElementById('userId').value = user['id_usuario'];
                        document.getElementById('userOldRole').value = user['role_id'];
                        document.getElementById('editUserName').value = user['nome'];
                        document.getElementById('editUserRole').value = user['role_id'];

                        if(user['role_id'] == 1){
                            fetch('../../php/get-matricula.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `id_usuario=${user['id_usuario']}`
                            })
                            .then(res => res.json())
                            .then(data => {
                                document.getElementById('editMatricula').value = data['matricula'];
                            }) 
                        } else {
                            document.getElementById('editMatricula').value = '';
                        }

                        const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                        editUserModal.show();
                    });

                    const deleteLink = document.createElement('a');
                    deleteLink.textContent = 'Excluir';
                    deleteLink.className = 'text-deco-none cursor-pointer text-danger';
                    deleteLink.addEventListener('click', () => {
                        fetch('../../php/delete-user.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `delete_user=true&role=${user['role_id']}&id_usuario=${user['id_usuario']}`
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert('Usuario excluído com sucesso!');

                            trUser.remove();
                            updatePagination();
                        })
                        .catch(error => {
                            alert('Erro ao excluir o Usuario.');
                        });
                    });

                    tdActions.appendChild(editLink);
                    tdActions.appendChild(deleteLink);

                    trUser.appendChild(tdId);
                    trUser.appendChild(tdNameUser);
                    trUser.appendChild(tdUserRole);
                    trUser.appendChild(tdActions);

                    containerUsers.appendChild(trUser);
                });
            }

            function setupPagination() {
                paginationContainer.innerHTML = '';
            
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''} m-2`;
                    const a = document.createElement('a');
                    a.className = 'page-link rounded';
                    a.href = '#';
                    a.textContent = i;
                    a.addEventListener('click', (event) => {
                        event.preventDefault();
                        currentPage = i;
                        renderPage(currentPage);
                        updatePagination();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                    li.appendChild(a);
                    paginationContainer.appendChild(li);
                }
            }

            function updatePagination() {
                const paginationItems = document.querySelectorAll('.pagination .page-item');
                paginationItems.forEach((item, index) => {
                    if (index + 1 === currentPage) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            }

            renderPage(currentPage);
            setupPagination();
        })
        .catch(error => console.error('Erro ao carregar os usuários:', error));
});