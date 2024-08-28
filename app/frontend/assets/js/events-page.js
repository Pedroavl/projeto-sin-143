document.addEventListener('DOMContentLoaded', () => {
    const containerCursos = document.getElementById('cursos');
    const paginationContainer = document.getElementById('pagination-links');
    const idEvento = containerCursos.getAttribute('data-id-evento');
    const itemsPerPage = 3;
    let currentPage = 1;
    let totalPages;

    fetch('../php/cursos-evento.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_evento=${idEvento}`
        })
        .then(res => res.json())
        .then(cursos => {            
            totalPages = Math.ceil(cursos.length / itemsPerPage);

            function renderPage(page) {
                containerCursos.innerHTML = ''; // Limpa o contêiner
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = cursos.slice(start, end);

                pageItems.forEach(curso => {

                    fetch('../php/curso.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id_curso=${curso['id_curso']}`
                    })
                    .then(res => res.json())
                    .then(data => {

                    const divCurso = document.createElement('div');
                    divCurso.className = 'back-input text-center p-5 rounded position-relative d-flex row justify-content-around';
                    divCurso.style.width = '300px';
                    divCurso.style.height = '350px';


                        const hNomeCurso = document.createElement('h5');
                        hNomeCurso.textContent = data['titulo'];
                        hNomeCurso.className = 'fw-bold';

                        const pDescricao = document.createElement('p');
                        pDescricao.textContent = data['descricao'];
                        pDescricao.className = 'text-break';


                    const pData = document.createElement('p');
                    pData.textContent = curso['data'];
                    pData.className = 'fw-bold';

                    const pHora = document.createElement('p');
                    pHora.textContent = curso['horario_inicio'];
                    pHora.className = 'fw-bold';

                    const button = document.createElement('button');
                    button.textContent = 'Inscrever-se';
                    button.className = 'btn back-primary text-primary position-absolute';                    
                    button.style.bottom = '-5%';
                    button.style.left = '50%';
                    button.style.width = '60%';
                    button.style.transform = 'translateX(-50%)';

                    divCurso.appendChild(hNomeCurso);
                    divCurso.appendChild(pDescricao);
                    divCurso.appendChild(pData);
                    divCurso.appendChild(pHora);
                    divCurso.appendChild(button);

                    // Adiciona a div
                    containerCursos.appendChild(divCurso);
                    
                    })
                    .catch(error => console.error('Erro ao carregar os dados do curso:', error));
                });
            }

            function setupPagination() {
                const totalPages = Math.ceil(cursos.length / itemsPerPage);
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
