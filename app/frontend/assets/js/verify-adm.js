document.addEventListener("DOMContentLoaded", function() {
    fetch('../../php/is-adm-logged.php')
        .then(response => response.text())
        .then(data => {   
            if (data.includes("window.location.href")) {
                document.write(data);
            } else {
                console.log("O usuário está logado");
            }
        })
        .catch(error => console.error('Erro:', error));
});