document.addEventListener('DOMContentLoaded', () => {
    const containerCursos = document.getElementById('tbody');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages;

    fetch('../../php/cursos.php')
        .then(res => res.json())
        .then(data => {
            const cursos = data;
            console.log(cursos);
            
            totalPages = Math.ceil(cursos.length / itemsPerPage);

            function renderPage(page) {
                containerCursos.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = cursos.slice(start, end);

                pageItems.forEach(curso => {
                    const trcursos = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdName = document.createElement('td');
                    const tdDate = document.createElement('td');
                    const tdCreation = document.createElement('td');

                    tdId.textContent = curso['idCurso'];
                    tdName.textContent = curso['titulo'];
                    tdCreation.textContent = curso['data_criacao'];

                    trcursos.appendChild(tdId);
                    trcursos.appendChild(tdName);
                    trcursos.appendChild(tdCreation);

                    containerCursos.appendChild(trcursos);
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
        .catch(error => console.error('Erro ao carregar os cursos:', error));
});