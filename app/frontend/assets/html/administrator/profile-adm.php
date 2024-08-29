<?php  
    session_start();

    $id_usuario = $_SESSION['id_usuario'];
    $nome = $_SESSION['nome'];
    $email = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/custom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body class="bg-light">

<div class="ml-5 pl-5">
    <div id="header" data-link-logo="main-page-adm.html" data-img-path="../../images/logo-ufv.png" data-img-alt="Logo UFV" data-first-link="../../php/end-session.php" data-first-text="Sair" data-second-link="profile-adm.php" data-second-text="Administrador"></div>
    <div id="sidebar"></div>
        <div class="mt-5 justify-content-center">
            <div class="text-start">                
                <div style="margin-left: 18rem; margin-right: 5rem;">
                    <p class="fw-semibold" style="margin-left: 5%; font-size: 3rem;">Edite Suas <br>Informações</p>
                    <form class="text-center" style="width: 560px; padding-top: 0px !important" action="../../php/update-user.php" method="POST">        
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
<script src="../../js/import-header-adm.js"></script>
<script src="../../js/import-sidebar.js"></script>
<script src="../../js/verify-adm.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>