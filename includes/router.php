<?php
// -----------------------------------------------------------------------
// INICIALIZAÇÃO
// -----------------------------------------------------------------------
require_once 'load.php'; // Inclui configurações e funções essenciais

// Captura a URL da query string
$url = isset($_GET['url']) ? $_GET['url'] : 'dashboard';
$url = trim($url, '/'); // Remove barras extras
$url = filter_var($url, FILTER_SANITIZE_URL); // Sanitiza a URL
$urlParts = explode('/', $url); // Quebra a URL em partes

// Define o primeiro parâmetro como o controlador
$page = isset($urlParts[0]) ? $urlParts[0] : 'dashboard';
$action = isset($urlParts[1]) ? $urlParts[1] : null;
$id = isset($urlParts[2]) ? (int)$urlParts[2] : null;

// Protege contra acesso a arquivos restritos
$arquivos_restritos = ['config', 'database', 'load', 'session', 'sql', 'router'];
if (in_array($page, $arquivos_restritos)) {
    http_response_code(403);
    die("Acesso negado.");
}

// Definição de rotas
$routes = [
    'dashboard/' => 'dashboard.php',
    'usuarios/adicionar' => 'modules/adicionar_usuario.php',
    'equipamento/adicionar' => 'modules/adicionar_equipamento.php',
    'equipamento/editar' => $id ? 'modules/editar_equipamento.php' : null,
    'equipamento/deletar' => $id ? 'modules/deletar_equipamento.php' : null,
    'equipamento' => 'modules/equipamento.php',
    'login' => 'modules/auth.php', // Nova rota para login
    'logout' => 'modules/auth.php'  // Nova rota para logout, caso precise
];

// Verifica se a rota existe
$routeKey = $page . ($action ? "/$action" : '');
if (isset($routes[$routeKey])) {
    require_once $routes[$routeKey];
} else {
    // Caminho do arquivo correspondente
    $file = "modules/{$page}.php";

    // Verifica se o arquivo existe e inclui
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Página de erro personalizada
        http_response_code(404);
        require_once "../modules/404.php";
    }
}
