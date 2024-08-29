<?php
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Evento/evento.class.php";

    if (isset($_GET['id_evento']) && isset($_GET['id_curso'])) {
        $id_evento = $_GET['id_evento'];
        $id_curso = $_GET['id_curso'];

        $eventos = new Evento($conn);
    
        $data = $eventos->read_evento($id_evento);

        $nomeEvento = $data['nome'];
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
    <div id="header" data-link-logo="main-page.html" data-img-path="../images/logo-ufv.png" data-img-alt="Logo UFV" data-first-link="../php/end-session.php" data-first-text="Sair" data-second-link="profile.php"></div>
        <div class="row m-0 justify-content-center">
            <div id="divCurso" data-id-evento="<?php echo $id_evento ?>" data-id-curso="<?php echo $id_curso ?>" class="d-flex justify-content-center align-content-around text-center row p-5">
                <h1 id="nomeCurso" class="m-5">aaaaaa</h2>
                <h5 id="descricao" class="m-3" style="max-width: 50%">aaaaaaaaaaaaaaaaaa</h5>
                <div class="d-flex justify-content-center m-5">
                    <p id="data" class="m-4 fw-bold">aaaaaaaa</p>
                    <p id="horario" class="m-4 fw-bold">aaaaaaaa</p>
                </div>
                <div class="d-flex justify-content-center">
                    <div id="inscrever" class="btn back-primary text-primary m-3" style="width: 10%; min-width: 130px">Inscrever-se</div>
                    <div id="verCursos" class="btn back-light text-red m-3 border-red" style="width: 10%; min-width: 130px">Mais Cursos</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/import-header.js"></script>
<script src="../js/inscribe.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../js/verify-student.js"></script>
</body>
</html>