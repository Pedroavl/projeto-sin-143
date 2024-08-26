document.addEventListener('DOMContentLoaded', () => {
    const containerEventos = document.getElementById('eventos');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 12;
    let currentPage = 1;
    let totalPages;

    fetch('../php/eventos.php')
        .then(res => res.json())
        .then(data => {
            const eventos = data;
            
            totalPages = Math.ceil(eventos.length / itemsPerPage);

            function renderPage(page) {
                containerEventos.innerHTML = ''; // Limpa o contêiner
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = eventos.slice(start, end);

                pageItems.forEach(evento => {
                    // Criar a div
                    const divEvento = document.createElement('div');
                    divEvento.className = 'col-md-2 border rounded back-input m-4 fw-bold cursor-pointer';
                    divEvento.style.width = '250px';
                    divEvento.style.height = '250px';
                    divEvento.style.cursor = 'pointer';

                    // Criar a imagem
                    const imgEvento = document.createElement('img');
                    imgEvento.src = evento['imagem'];
                    imgEvento.alt = evento['descricao'];
                    imgEvento.style.width = '100%';
                    imgEvento.style.height = '165px';
                    imgEvento.style.objectFit = 'cover';
                    imgEvento.className = 'img-fluid max-width';

                    // Criar o p
                    const pEvento = document.createElement('p');
                    pEvento.textContent = evento['descricao'];
                    pEvento.style.margin = '10px';

                    // Adiciona a imagem e a descrição
                    divEvento.appendChild(imgEvento);
                    divEvento.appendChild(pEvento);

                    // Adiciona a div
                    containerEventos.appendChild(divEvento);
                });
            }

            function setupPagination() {
                const totalPages = Math.ceil(eventos.length / itemsPerPage);
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
