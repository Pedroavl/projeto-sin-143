<?php
    include "../../../backend/class/helpers/helper.class.php";

    session_start();

    $id_usuario = $_SESSION['id_usuario'];
    $nome = $_SESSION['nome'];
    $email = $_SESSION['email'];

    // modo de depuração
    $helper = new Helper(false);

    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Estudante/estudante.class.php";
    include "../../../backend/class/EstudanteCursosEvento/estudantecursoseventos.class.php";
    include "../../../backend/class/CursosEvento/cursoseventos.class.php";

    $estudante = new Estudante($conn);

    $estudanteCursosEvento = new EstudanteCursosEvento($conn);

    $dataEstudante = $estudante->get_student_by_user($id_usuario);
    $ranking = $estudante->ranking_estudantes($dataEstudante['matricula'])['classificacao'];

    $pontuacao = $estudante->ranking_estudantes($dataEstudante['matricula'])['pontuacao'];

    $numCursos = $estudanteCursosEvento->count_cursos_inscritos($dataEstudante['matricula']);

    $data = [
        'pontuacao' => $pontuacao,
        'ranking' => $ranking,
        'numCursos' => $numCursos
    ];


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
        <div class="row m-5 justify-content-center" style="max-height: 75vh; overflow: hidden;">
            <div class="row text-start px-5 mx-5">
                <div class="col">
                    <p class="fw-semibold" style="font-size: 3rem;">Outras <br>Informações</p>
                    <div class="row">
                        <div class="col-12 mb-3 pt-5"><p class="fw-bold">Cursos Inscritos:</p> 
                            <p id="numCursos"><?php echo $data['numCursos'] ?></p>
                        </div>
                        <div class="col-12 mb-3 pt-1"><p class="fw-bold">Pontuação Total:</p> 
                            <p id="pontuacao"><?php echo $data['pontuacao'] ?></p>
                        </div>
                        <div class="col-12 mb-3 pt-1"><p class="fw-bold">Posição no Ranking:</p> 
                            <p id="ranking"><?php echo $data['ranking'] ?></p>
                        </div>
                    </div>
                </div>
        
                <div class="col-auto d-flex align-items-center">
                    <div class="h-100" style="width: 3px; background-color: #c3a63b;"></div>
                </div>
                
                <div class="col">
                    <p class="fw-semibold" style="margin-left: 10%; font-size: 3rem;">Edite Suas <br>Informações</p>
                    <form class="text-center w-75 m-auto p-5 m-0" style="min-width: 520px; padding-top: 0px !important" action="../php/update-user.php" method="POST">        
                        <div class="back-gray p-4 m-5 border rounded">
                            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>">
                            <div class="form-floating">
                                <input type="text" name="nome" class="form-control back-input rounded mb-2" placeholder="Seu nome" value="<?php echo $nome ?>" required>
                                <label class="text-input">Nome</label>
                            </div>
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control back-input rounded mb-2" placeholder="name@example.com" value="<?php echo $email ?>" required>
                                <label class="text-input">E-mail</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="senha" class="form-control back-input rounded" placeholder="Senha" required minlength="8">
                                <label class="text-input">Senha</label>
                            </div>
                            <button class="btn back-primary w-100 py-2 mt-5 text-light" type="submit" name="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/import-header.js"></script>
<script scr="../js/update-profile.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../js/verify-student.js"></script>
</body>
</html>
