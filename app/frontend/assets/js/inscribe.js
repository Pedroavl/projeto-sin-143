//Modelo de import
//<div id="header" data-img-path="../images/logo-ufv.png" data-img-alt="Logo UFV" data-first-link="https://www.youtube.com/" data-first-text="Sair" data-second-link="#" data-second-text="Phelipe Romano"></div>

const divCurso = document.getElementById('divCurso');

const idEvento = divCurso.getAttribute('data-id-evento');
const idCurso = divCurso.getAttribute('data-id-curso');

fetch('../php/curso-evento.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `id_curso=${idCurso}&id_evento=${idEvento}`
})
    .then(res => res.json())
    .then(data => {

        fetch('../php/curso.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_curso=${idCurso}`
        }).
        then(res => res.json())
        .then(curso => {

            const nome = document.getElementById('nomeCurso');
            const descricao = document.getElementById('descricao');
            const data_inicio = document.getElementById('data');
            const hora = document.getElementById('horario');

            nome.textContent = curso['titulo'];
            descricao.textContent = curso['descricao'];

            data_inicio.textContent = `Data: ${data['data']}`;
            hora.textContent = `Horário: ${data['horario_inicio']}`;


            const inscrever = document.getElementById('inscrever');
            const voltar = document.getElementById('verCursos');

            inscrever.addEventListener('click', () => {
                fetch('../php/estudante-cursos-evento.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_evento=${idEvento}&id_curso=${idCurso}&horario_inicio=${data['horario_inicio']}&horario_fim=${data['horario_fim']}&data=${data['data']}`
                })
                .then(res => res.text())
                .then(resposta => {
                    console.log(resposta);
                    if(resposta == 'true'){
                        alert("Inscrição realizada com sucesso!");
                        setTimeout(() => {
                            window.location.href = `events.php?id_evento=${data['id_evento']}`;
                        }, 3000);
                    } else {
                        alert("A inscrição não pode ser realizada!");
                    }
                });
            });

            voltar.addEventListener('click', () => {
                window.location.href = `events.php?id_evento=${idEvento}`;
            });
    
        });
});

