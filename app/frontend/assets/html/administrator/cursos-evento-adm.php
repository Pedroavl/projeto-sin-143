<?php
if (isset($_GET['id_evento'])) {
    $id_evento = $_GET['id_evento'];
}
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
        <div id="header" data-img-path="../../images/logo-ufv.png" data-img-alt="Logo UFV" data-first-link="../../php/end-session.php" data-first-text="Sair" data-second-link="#" data-second-text="Administrador"></div>
        <div id="sidebar"></div>
        
        <div class="p-3" style="margin-left: 20rem; margin-right: 5rem;">
            <h1 class="mt-3 p-1 fw-bold">Dashboard</h1>
            <div class="mt-3 p-1">
                <div class="d-flex justify-content-between">
                    <h3>Cursos do Evento</h3>
                    <button class="btn p-2 text-light f2-light back-success" type="button"  data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><p class="m-0 p-1" style="font-size: small;">ADICIONAR CURSO</p></button>
                </div>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">ID Curso</th>
                            <th scope="col">Data</th>
                            <th scope="col">Início</th>
                            <th scope="col">Fim</th>
                            <th scope="col">Vagas</th>
                            <th scope="col">Inscritos</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                </table>
                <nav aria-label="..." id="paginacao" style="margin-right: 7rem;">
                    <ul class="pagination pagination justify-content-end pt-2" id="pagination-links">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- modal para adicionar evento -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Adicionar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../php/create-cursos-evento.php" method="POST" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="id_evento" value="<?php echo $id_evento ?>">
                        <div class="mb-3">
                            <label class="form-label">Curso</label>
                            <select name="id_curso" class="form-control" required id="cursos">
                                <option value="" disabled selected>Selecione um curso</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Data</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Início</label>
                            <input type="time" name="startTime" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="endTime" class="form-label">Fim</label>
                            <input type="time" name="endTime" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="vacancy" class="form-label">Vagas</label>
                            <input type="number" name="vacancy" class="form-control" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" name="cadastrar_curso_evento" class="btn btn-primary">Enviar</button>
            </div>
                </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCursosEventoModal" tabindex="-1" aria-labelledby="editCursosEventoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCursosEventoModalLabel">Editar Curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../php/edit-evento.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_evento" id="editCursosEventoId">
                    <div class="custom-file mb-3 d-flex align-items-start">
                        <input type="file" class="custom-file-input" accept="image/*" name="imagem_evento">
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control back-input rounded mb-2" id="editCursosEventoName" name="title" placeholder="Título" required>
                        <label for="title">Título</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" class="form-control back-input rounded mb-2" id="editCursosEventoBeginDate" name="beginData" placeholder="Data de Início" required>
                        <label for="beginData">Data de Início</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" class="form-control back-input rounded mb-2" id="editCursosEventoEndDate" name="endData" placeholder="Data de Fim" required>
                        <label for="endData">Data de Fim</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control back-input rounded mb-2" id="editCursosEventoLocation" name="location" placeholder="Local do Evento" required>
                        <label for="location">Local do Evento</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control back-input rounded mb-2" id="editCursosEventoDescription" name="description" placeholder="Descrição do Evento" required></textarea>
                        <label for="description">Descrição do Evento</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit"  name="cadastrar_curso"  class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../../js/import-cursos-evento-table.js"></script>
<script src="../../js/cursos-options.js"></script>
<script src="../../js/import-header-adm.js"></script>
<script src="../../js/import-sidebar.js"></script>
<script src="../../js/verify-adm.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>