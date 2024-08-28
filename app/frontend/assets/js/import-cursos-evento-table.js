document.addEventListener('DOMContentLoaded', () => {
    const containerCursos = document.getElementById('tbody');
    const paginationContainer = document.getElementById('pagination-links');
    const itemsPerPage = 8;
    let currentPage = 1;
    let totalPages;

    const urlParams = new URLSearchParams(window.location.search);
    const idEvento = urlParams.get('id_evento');

    fetch('../../php/cursos-evento.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id_evento=${idEvento}`
    })
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
                    const trCourse = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdDate = document.createElement('td');
                    const tdBegin = document.createElement('td');
                    const tdEnd = document.createElement('td');
                    const tdVacancy = document.createElement('td');
                    const tdInscribed = document.createElement('td');
                    const tdActions = document.createElement('td');

                    tdId.textContent = curso['id_curso'];
                    tdDate.textContent = curso['data'];
                    tdBegin.textContent = curso['horario_inicio'];
                    tdEnd.textContent = curso['horario_fim'];
                    tdVacancy.textContent = curso['quantidade_vagas'];
                    tdInscribed.textContent = curso['quantidade_inscritos'];

                    const editLink = document.createElement('a');
                    editLink.textContent = 'Editar';
                    editLink.className = 'text-deco-none cursor-pointer';
                    editLink.style.marginRight = '20px';
                    editLink.addEventListener('click', () => {
                        document.getElementById('cursoId').value = curso['id_curso'];
                        document.getElementById('eventoId').value = idEvento;
                        document.getElementById('editData').value = curso['data'];
                        document.getElementById('editHoraInicio').value = curso['horario_inicio'];
                        document.getElementById('editHoraFim').value = curso['horario_fim'];
                        document.getElementById('editVagas').value = curso['quantidade_vagas'];

                        const editCourseModal = new bootstrap.Modal(document.getElementById('editCursosEventoModal'));
                        editCourseModal.show();
                    });

                    const deleteLink = document.createElement('a');
                    deleteLink.textContent = 'Excluir';
                    deleteLink.className = 'text-deco-none cursor-pointer text-danger';
                    deleteLink.addEventListener('click', () => {
                        fetch('../../php/delete-cursos-evento.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `deletar_curso_evento=true&id_curso=${curso['id_curso']}&id_evento=${idEvento}`
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert('curso excluído com sucesso!');

                            trCourse.remove();
                            updatePagination();
                        })
                        .catch(error => {
                            alert('Erro ao excluir o curso.');
                        });
                    });

                    tdActions.appendChild(editLink);
                    tdActions.appendChild(deleteLink);

                    trCourse.appendChild(tdId);
                    trCourse.appendChild(tdDate);
                    trCourse.appendChild(tdBegin);
                    trCourse.appendChild(tdEnd);
                    trCourse.appendChild(tdVacancy);
                    trCourse.appendChild(tdInscribed);
                    trCourse.appendChild(tdActions);

                    containerCursos.appendChild(trCourse);
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