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

<style>
    a:hover {
      color: #005580;
      text-decoration: none !important;
    }
</style>

<h2 style="
    color: white;
    position: absolute;
    z-index: 50;
    padding: 2px 0 0 65px;
">
    <a href="<?php echo URL ?>/">&lt;&lt; Página inicial</a>
    
</h2>