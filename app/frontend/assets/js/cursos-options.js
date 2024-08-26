fetch("../../php/cursos.php")
    .then(res => res.json())
    .then(data => {

        data.forEach(curso => {
            const cursosOptions = document.getElementById('cursos');

            const option = document.createElement('option');
            option.value = curso['idCurso'];
            option.innerHTML = curso['titulo'];

            cursosOptions.append(option);
        });
    })
    .catch(error => console.error('Erro ao carregar os cursos:', error));