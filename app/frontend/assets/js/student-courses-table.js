document.addEventListener('DOMContentLoaded', () => {
    const containerUsers = document.getElementById('tbody');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 12;
    let currentPage = 1;
    let totalPages;

    fetch('../php/cursos-estudante.php')
        .then(res => res.text())
        .then(data => {
            const users = JSON.parse(data);
            console.log(users);
            
            totalPages = Math.ceil(users.length / itemsPerPage);

            function renderPage(page) {
                containerUsers.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = users.slice(start, end);

                
                pageItems.forEach(user => {
                    const trUsers = document.createElement('tr');

                    const tdEvent = document.createElement('td');
                    const tdCourse = document.createElement('td');
                    const tdDate = document.createElement('td');
                    const tdHour = document.createElement('td');
                    const tdPontuation = document.createElement('td');

                    tdEvent.textContent = user['nome_evento'];
                    tdCourse.textContent = user['nome_curso'];
                    tdDate.textContent = user['data'];
                    tdHour.textContent = user['horario'];
                    tdPontuation.textContent = user['pontuacao'];

                    trUsers.appendChild(tdEvent);
                    trUsers.appendChild(tdCourse);
                    trUsers.appendChild(tdDate);
                    trUsers.appendChild(tdHour);
                    trUsers.appendChild(tdPontuation);

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