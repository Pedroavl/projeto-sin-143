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
            
            totalPages = Math.ceil(cursos.length / itemsPerPage);

            function renderPage(page) {
                containerCursos.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageItems = cursos.slice(start, end);

                pageItems.forEach(curso => {
                    const trCourse = document.createElement('tr');

                    const tdId = document.createElement('td');
                    const tdNameCourse = document.createElement('td');
                    const tdCreationDate = document.createElement('td');
                    const tdDescription = document.createElement('td');
                    const tdActions = document.createElement('td');

                    tdId.textContent = curso['idCurso'];
                    tdNameCourse.textContent = curso['titulo'];
                    tdCreationDate.textContent = curso['data_criacao'];
                    tdDescription.textContent = curso['descricao'];

                    const editLink = document.createElement('a');
                    editLink.textContent = 'Editar';
                    editLink.className = 'text-deco-none cursor-pointer';
                    editLink.style.marginRight = '20px';
                    editLink.addEventListener('click', () => {
                        document.getElementById('editCursoId').value = curso['idCurso'];
                        document.getElementById('editCursoName').value = curso['titulo'];
                        document.getElementById('editCursoDescription').value = curso['descricao'];

                        const editCourseModal = new bootstrap.Modal(document.getElementById('editCursoModal'));
                        editCourseModal.show();
                    });

                    const deleteLink = document.createElement('a');
                    deleteLink.textContent = 'Excluir';
                    deleteLink.className = 'text-deco-none cursor-pointer text-danger';
                    deleteLink.addEventListener('click', () => {
                        fetch('../../php/delete-curso.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `deletar_curso=true&id_curso=${curso['idCurso']}`
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert('curso excluído com sucesso!');
                            console.log(data);

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
                    trCourse.appendChild(tdNameCourse);
                    trCourse.appendChild(tdDescription);
                    trCourse.appendChild(tdCreationDate);
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