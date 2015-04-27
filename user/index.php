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

 
<div class="inner cover">
    <h1>Reservas</h1><br>
   
    <table class="table">
        <tr>
            <td>Data de entrada</td>
            <td>Data de saida</td>
            <td>Valor da reserva</td>
            <td>numero do quarto</td>
        </tr>

    </table>    
   
</div>

<?php  include '../footer.php';  ?>