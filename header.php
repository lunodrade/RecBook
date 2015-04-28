<?php 
include 'constantes.php'; 

require_once 'auth/usuario.php';
require_once 'auth/sessao.php';
require_once 'auth/autenticador.php';

$aut = Autenticador::instanciar();

$usuario = null;
if ($aut->esta_logado()) {
    $usuario = $aut->pegar_usuario();
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo URL ?>/favicon.ico">
    <title>RecBooks</title>
    
    <script type="text/javascript" src="<?php echo ASSETS ?>/js/jquery.min.js"></script>
    <link href="<?php echo ASSETS ?>/css/bootstrap.min.css" rel="stylesheet">
    
    <style type="text/css">
        .especialista {
            margin-left: 150px;
        }
        
        .outer-container {
            display: flex;
            justify-content: center;
        }
        
        .outer-container-templ {
            display: flex;
            justify-content: center;
        }
        
        .navbar-options {
            margin: 50px 0 120px 0;
            font-weight: bold;
            font-size: 18px;
        }
        
        body {
            background-color: #E0E0E0;
        }
    </style>
    
  </head>
  <body>
    
    
    <div class="outer-container navbar-options">
    Ol&aacute;, 
    <?php 
        if($usuario != null) {
            echo($usuario->getNome());
        } else {
            echo('Convidado');
        }
        if($usuario != null) {
    ?>
            <span class="goLoginBtn">&nbsp;(<a href="<?php echo URL ?>/auth/logout.php">sair</a>)</span>
    <?php 
            if($usuario->getTipo() == "admin") {
    ?>
    
                <span class="especialista"><a href="<?php echo URL ?>/admin">Especialista</a></span>
    <?php
            }
        } else { 
    ?>
            <span class="goLoginBtn">&nbsp;(<a href="<?php echo URL ?>/auth/login.php">logar</a>)</span>
    <?php 
        } 
        
    ?>
    
    </div>
    
    
    
    
    
    
    
    <div class="outer-container-templ">