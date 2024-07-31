// Função para fazer as validações
function testRegex(pattern, str) {
    var re = new RegExp(pattern);
    return re.test(str);
}

// Tenta pegar os dois formularios e usa aquele que ele conseguiu
document.addEventListener('DOMContentLoaded', function() {
    var loginForm = document.getElementById('loginForm');
    var registerForm = document.getElementById('registerForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            var emailMat = document.getElementById('emailMat').value;
            var password = document.getElementById('password').value;

            var errorMessage = '';

            // Validação do email/matrícula
            if (emailMat === '') {
                errorMessage += 'O campo de email/matrícula é obrigatório.\n';
                event.preventDefault();
                alert(errorMessage);
                return; // Serve para parar a execução
            } else if (!testRegex('^\\d+$', emailMat) && !testRegex('^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$', emailMat)){
                errorMessage += 'Insira um email ou matrícula válido.\n';
                event.preventDefault();
                alert(errorMessage);
                return;
            }

            // Validação da senha
            if (password === '') {
                errorMessage += 'O campo de senha é obrigatório.\n';
                event.preventDefault();
                alert(errorMessage);
                return;
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            var matricula = document.getElementById('matricula').value;
            var password = document.getElementById('password').value;
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;

            var errorMessage = '';

            // Validação do nome
            if (name === '') {
                errorMessage += 'O campo de nome é obrigatório.\n';
                event.preventDefault();
                alert(errorMessage);
                return;
            }

             // Validação do email
            if (email === '') {
                errorMessage += 'O campo de email é obrigatório.\n';
                event.preventDefault();
                alert(errorMessage);
                return;                   
            } // Não tem mais coisa de email porque o proprio input faz a verificação
            
            // Validação da matrícula
            if (matricula === '') {
                errorMessage += 'O campo de matrícula é obrigatório.\n';
                event.preventDefault();
                alert(errorMessage);
                return;
            } // Mesma coisa do email

            // Validação da senha
            if (password === '') {
                errorMessage += 'O campo de senha é obrigatório.\n';
                event.preventDefault();
                alert(errorMessage);
                return;
            } else if (password.length < 8){
                errorMessage += 'A senha deve possuir ao menos 8 caracteres.\n';
                event.preventDefault();
                alert(errorMessage);
                return;
            }
        });
    }
});