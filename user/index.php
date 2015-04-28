<?php  
include '../header.php';  
     
if (!defined('__ROOT__'))
    define('__ROOT__', dirname(dirname(__FILE__)));

if($_SERVER['HTTP_HOST'] == '127.0.0.1') {
    include_once __ROOT__ . '\constantes.php';
    include_once __ROOT__ . '\auth\perm_user.php';
} else {
    include_once __ROOT__ . '/constantes.php';
    require_once __ROOT__ . '/auth/perm_user.php';
}
?>



<h1>Pagina do usuario, com os livros </h1>

<a href="<?php echo URL ?>/user/add_books.php">Adicionar livros</a><br>
<a href="<?php echo URL ?>/user/suggestions.php">Ver sugest&otilde;es</a><br>


<?php  include '../footer.php';  ?>