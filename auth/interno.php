<?php 
require_once 'usuario.php';
require_once 'sessao.php';
require_once 'autenticador.php';

$aut = Autenticador::instanciar();

$usuario = null;
if ($aut->esta_logado()) {
    $usuario = $aut->pegar_usuario();
}
else {
    $aut->expulsar();
}
?>

<!--
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pagina interna</title>
    </head>
    <body>
        <h1>Página interna do sistema</h1>
        <p>Você está logado como 
            <strong><?php print $usuario->getNome(); ?></strong>.
        </p>
        <p><a href="controle.php?acao=sair">Sair</a></p>
    </body>
</html>
-->