<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Estudante/estudante.class.php";

    $estudante = new Estudante($conn);

    $matricula = $estudante->get_student_by_user($_POST['id_usuario']);

    echo json_encode($matricula);

?>