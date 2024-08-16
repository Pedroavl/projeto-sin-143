document.addEventListener('DOMContentLoaded', () => {
    const containerEventos = document.getElementById('tbody');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages;

    fetch('../../php/teste2.php')
        .then(res => res.json())
        .then(data => {
            const eventos = data;
            
            totalPages = Math.ceil(eventos.length / itemsPerPage);

            function renderPage(page) {
                containerEventos.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = eventos.slice(start, end);

                pageItems.forEach(evento => {
                    const trEvento = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdNameEvent = document.createElement('td');
                    const tdBeginDate = document.createElement('td');
                    const tdEndDate = document.createElement('td');
                    const tdActions = document.createElement('td');

                    tdId.textContent = evento['id_evento'];
                    tdNameEvent.textContent = evento['nome'];
                    tdBeginDate.textContent = evento['data_inicio'];
                    tdEndDate.textContent = evento['data_fim'];

                    const editLink = document.createElement('a');
                    editLink.textContent = 'Editar';
                    editLink.className = 'text-deco-none cursor-pointer';
                    editLink.style.marginRight = '20px';
                    editLink.addEventListener('click', () => {
                        alert(`Editar evento ${evento['id_evento']}`);
                    });

                    const deleteLink = document.createElement('a');
                    deleteLink.textContent = 'Excluir';
                    deleteLink.className = 'text-deco-none cursor-pointer text-danger';
                    deleteLink.addEventListener('click', () => {
                        alert(`Excluir evento ${evento['id_evento']}`);
                    });

                    tdActions.appendChild(editLink);
                    tdActions.appendChild(deleteLink);

                    trEvento.appendChild(tdId);
                    trEvento.appendChild(tdNameEvent);
                    trEvento.appendChild(tdBeginDate);
                    trEvento.appendChild(tdEndDate);
                    trEvento.appendChild(tdActions);

                    containerEventos.appendChild(trEvento);
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
        .catch(error => console.error('Erro ao carregar os eventos:', error));
});