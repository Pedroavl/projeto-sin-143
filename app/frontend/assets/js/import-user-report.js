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
            console.log(users);
            
            totalPages = Math.ceil(users.length / itemsPerPage);

            function renderPage(page) {
                containerUsers.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = users.slice(start, end);

                pageItems.forEach(user => {
                    const trUsers = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdName = document.createElement('td');
                    const tdRole = document.createElement('td');

                    tdId.textContent = user['id_usuario'];
                    tdName.textContent = user['nome'];

                    if(user['role_id'] == 0){
                        tdRole.textContent = "Administrador";
                    } else {
                        tdRole.textContent = "Estudante";
                    }

                    trUsers.appendChild(tdId);
                    trUsers.appendChild(tdName);
                    trUsers.appendChild(tdRole);

                    containerUsers.appendChild(trUsers);
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
        .catch(error => console.error('Erro ao carregar os users:', error));
});