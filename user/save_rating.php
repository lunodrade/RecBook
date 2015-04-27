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

<?php

if(isset($_POST) && !empty($_POST)) {

   //Conectar no banco
    $pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME."", DBUSER, DBPASS);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    //Prepara o query, usando :values
    $consulta = $pdo->prepare("SELECT pk_likes_cod 
                               FROM tb_likes
                               WHERE fk_livro_cod = :livro_cod AND
                                     fk_usu_cod = :usu_cod;");

    //Troca os :symbol pelos valores que irão executar
    //Ao mesmo tempo protege esses valores de injection
    //$consulta->bindValue(":cli_cod", $_GET['cod']);       //Pode ser assim também
    $consulta->bindValue(":usu_cod", $usuario->getId());
    $consulta->bindValue(":livro_cod", $_POST["book"]);

    //Executa o sql
    $consulta->execute();

    if ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        //Prepara o query, usando :values
        $query = $pdo->prepare("UPDATE tb_likes
                                SET like_pontos = :pontos
                                WHERE pk_likes_cod = :cod;");

        //Troca os :symbol pelos valores que irão executar
        //Ao mesmo tempo protege esses valores de injection
        $query->bindValue(":pontos",    $_POST['rating']);
        $query->bindValue(":cod",       $linha["pk_likes_cod"]);

        //Executar o sql
        if($query->execute()) {
            //A query foi executada com sucesso
        } else {
            echo "erro";
            die();
        }
    } else {
        //Prepara o query, usando :values
        $query = $pdo->prepare("INSERT INTO tb_likes
                                (like_pontos, fk_usu_cod, fk_livro_cod)
                                VALUES
                                (:pontos, :usu, :livro);");

        //Troca os :symbol pelos valores que irão executar
        //Ao mesmo tempo protege esses valores de injection
        $query->bindValue(":pontos",    $_POST['rating']);
        $query->bindValue(":usu",       $usuario->getId());
        $query->bindValue(":livro",     $_POST['book']);

        //Executar o sql
        if($query->execute()) {
            //A query foi executada com sucesso
        } else {
            echo "erro";
            die();
        }
    }
    
}

?>
          
<h2>Ok, livro avaliado com sucesso, só clicar em voltar.</h2>
<a href="<?php echo URL ?>/user/add_books.php">voltar</a><br>

          
<?php  include '../footer.php';  ?>