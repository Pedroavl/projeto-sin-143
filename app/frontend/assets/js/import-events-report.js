document.addEventListener('DOMContentLoaded', () => {
    const containerEvents = document.getElementById('tbody');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages;

    fetch('../../php/eventos.php')
        .then(res => res.json())
        .then(data => {
            const events = data;
            console.log(events);
            
            totalPages = Math.ceil(events.length / itemsPerPage);

            function renderPage(page) {
                containerEvents.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = events.slice(start, end);

                pageItems.forEach(event => {
                    const trevents = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdName = document.createElement('td');
                    const tdCreation = document.createElement('td');

                    tdId.textContent = event['id_evento'];
                    tdName.textContent = event['nome'];
                    tdCreation.textContent = event['data_criacao'];

                    trevents.appendChild(tdId);
                    trevents.appendChild(tdName);
                    trevents.appendChild(tdCreation);

                    containerEvents.appendChild(trevents);
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
        .catch(error => console.error('Erro ao carregar os events:', error));
});