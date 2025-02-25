<?php
require_once(__DIR__ . '/../includes/load.php');

$req_fields = array('username', 'password');
validate_fields($req_fields);

$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

var_dump($username, $password);
if (empty($errors)) {
    $user_id = authenticate($username, $password);
    if ($user_id) {
        // Criar sessão com ID do usuário
        $session->login($user_id);

        // Atualizar o último login
        updateLastLogIn($user_id);

        // Redirecionar para o dashboard
        redirect('dashboard/', false);   
    } else {
        $session->msg("d", "Desculpe, Usuário/Senha incorretos.");
        redirect('/login');
    }
} else {
    $session->msg("d", implode("<br>", $errors));
    redirect('/login');
}
?>

