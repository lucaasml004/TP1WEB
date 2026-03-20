<?php
require_once 'config.php';
session_start();

if (isset($_SESSION['perfil'])) { header("Location: dashboard.php"); exit; }

$erro = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) { 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['perfil'] = $user['perfil'];
        header("Location: dashboard.php");
        exit;
    } else {
        $erro = "Credenciais inválidas!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login | IPCA Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo"><i class="fa-solid fa-graduation-cap"></i></div>
            <h3 class="auth-title">Bem-vindo ao IPCA</h3>
            <?php if($erro): ?> <div class="alert alert-danger mb-4"><i class="fa-solid fa-circle-exclamation me-2"></i><?= $erro ?></div> <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="form-label">Email Institucional</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="exemplo@ipca.pt" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Palavra-passe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="senha" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-4 py-2 mt-2">Entrar no Portal <i class="fa-solid fa-arrow-right ms-2"></i></button>
                <div class="text-center mt-3">
                    <span class="text-muted">Ainda não tem conta?</span> <a href="registar.php" class="auth-link">Criar Conta de Aluno</a>
                </div>
            </form>
        </div>
    </div>
    <script src="assets/js/theme.js"></script>
</body>
</html>