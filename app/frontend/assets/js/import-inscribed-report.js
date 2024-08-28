document.addEventListener('DOMContentLoaded', () => {
    const containerInscribed = document.getElementById('tbody');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages;

    fetch('../../php/inscribed-report.php')
        .then(res => res.json())
        .then(data => {
            const inscribed = data;
            console.log(inscribed);
            
            totalPages = Math.ceil(inscribed.length / itemsPerPage);

            function renderPage(page) {
                containerInscribed.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = inscribed.slice(start, end);

                pageItems.forEach(inscription => {
                    const trInscribed = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdName = document.createElement('td');
                    const tdScore = document.createElement('td');
                    const tdEvent = document.createElement('td');
                    const tdCourse = document.createElement('td');

                    tdId.textContent = inscription['matricula'];
                    tdName.textContent = inscription['nome'];
                    tdScore.textContent = inscription['pontuacao'];
                    tdEvent.textContent = inscription['evento'];
                    tdCourse.textContent = inscription['curso'];


                    trInscribed.appendChild(tdId);
                    trInscribed.appendChild(tdName);
                    trInscribed.appendChild(tdScore);
                    trInscribed.appendChild(tdEvent);
                    trInscribed.appendChild(tdCourse);
                    

                    containerInscribed.appendChild(trInscribed);
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
        .catch(error => console.error('Erro ao carregar os inscribed:', error));
});