<?php 
if (!defined('__ROOT__'))  define('__ROOT__', dirname(dirname(__FILE__)));

if($_SERVER['HTTP_HOST'] == '127.0.0.1') {
	require_once __ROOT__ . '\constantes.php';
	require_once __ROOT__ . '\auth\usuario.php';
	require_once __ROOT__ . '\auth\sessao.php';
	require_once __ROOT__ . '\auth\autenticador.php';
} else {
	require_once __ROOT__ . '/constantes.php';
	require_once __ROOT__ . '/auth/usuario.php';
	require_once __ROOT__ . '/auth/sessao.php';
	require_once __ROOT__ . '/auth/autenticador.php';
}

$aut = Autenticador::instanciar();

$usuario = null;
if ($aut->esta_logado()) {
    $usuario = $aut->pegar_usuario();
}

if($_SERVER['HTTP_HOST'] == '127.0.0.1') {
	require_once __ROOT__ . '\auth\perm_admin.php';
} else {
	require_once __ROOT__ . '/auth/perm_admin.php';
}
?>