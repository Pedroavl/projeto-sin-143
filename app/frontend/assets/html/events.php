<?php
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Evento/evento.class.php";

    if (isset($_GET['id_evento'])) {
        $id_evento = $_GET['id_evento'];

        $eventos = new Evento($conn);
    
        $data = $eventos->read_evento($id_evento);

        $nomeEvento = $data['nome'];
        $caminhoImagem = $data['imagem'];
    }


    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body class="bg-light">

<div class="justify-content-center align-items-center">
    <div id="header" data-img-path="../images/logo-ufv.png" data-img-alt="Logo UFV" data-first-link="../php/end-session.php" data-first-text="Sair" data-second-link="profile.php"></div>
        <div class="row m-0 justify-content-center">
            <div id="divEvento" class="d-flex justify-content-center align-content-around text-center row p-5 img-fluid max-width" style="height: 90vh; background-image: url('<?php echo $caminhoImagem ?>'); background-size: cover;">
                <h2 class="fw-bold m-0 text-primary">Você escolheu o Evento:</h2>
                <h4 class="m-0 text-primary"><?php echo $nomeEvento ?></h4>
                <p class="m-0 text-primary">Clique no botão abaixo e veja os cursos<br> disponíveis para este evento</p>
                <div id="verCursos" class="btn back-primary text-primary" style="width: 10%; min-width: 130px">Ver Cursos</div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <div class="col-md-10 mt-5 mb-4 pb-4">
                <div class="d-flex flex-wrap justify-content-around" id="cursos" data-id-evento="<?php echo $id_evento ?>" >
                    <!--
                    <div class="back-input text-center p-5 rounded position-relative d-flex row justify-content-around" style="width: 300px; height: 350px;">
                        <h5 class="fw-bold">Minicurso Daora</h5>
                        <p class="text-break">descrição</p>
                        <p class="fw-bold">Data: 12/12/1212</p>
                        <p class="fw-bold">Horário: 10:00</p>
                        <button class="btn back-primary text-primary position-absolute" style="bottom: -5%; left: 50%; transform: translateX(-50%); width: 60%;">Inscrever-se</button>
                    </div>
                    <div class="back-input text-center p-5 rounded position-relative d-flex row justify-content-around" style="width: 300px; height: 350px;">
                        <h5 class="fw-bold">Minicurso Daora</h5>
                        <p class="text-break">descrição</p>
                        <p class="fw-bold">Data: 12/12/1212</p>
                        <p class="fw-bold">Horário: 10:00</p>
                        <button class="btn back-primary text-primary position-absolute" style="bottom: -5%; left: 50%; transform: translateX(-50%); width: 60%;">Inscrever-se</button>
                    </div>
                    <div class="back-input text-center p-5 rounded position-relative d-flex row justify-content-around" style="width: 300px; height: 350px;">
                        <h5 class="fw-bold">Minicurso Daora</h5>
                        <p class="text-break">descrição</p>
                        <p class="fw-bold">Data: 12/12/1212</p>
                        <p class="fw-bold">Horário: 10:00</p>
                        <button class="btn back-primary text-primary position-absolute" style="bottom: -5%; left: 50%; transform: translateX(-50%); width: 60%;">Inscrever-se</button>
                    </div>
-->
                </div>
                <nav aria-label="..." id="paginacao">
                    <ul class="pagination pagination-lg justify-content-center pt-5" id="pagination-links">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('verCursos').addEventListener('click', function() {
    document.getElementById('cursos').scrollIntoView({ behavior: 'smooth' });
});
</script>
<script src="../js/import-header.js"></script>
<script src="../js/events-page.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../js/verify-student.js"></script>
</body>
</html>