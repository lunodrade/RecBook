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

//Conectar no banco
$pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME."", DBUSER, DBPASS);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );





$generos = array();
$consulta = $pdo->prepare("SELECT DISTINCT g.gen_nome
                           FROM tb_generos g;");
$consulta->execute();
if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
    foreach($linhas as $linha) {
        $generos[$linha["gen_nome"]] = 3;
    }
}

$tags = array();
$consulta = $pdo->prepare("SELECT DISTINCT t.tag_nome
                           FROM tb_tags t;");
$consulta->execute();
if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
    foreach($linhas as $linha) {
        $tags[$linha["tag_nome"]] = 3;
    }
}






//TAGS
$consulta = $pdo->prepare("SELECT DISTINCT j.pk_tagslivros_cod, t.tag_nome, c.like_pontos
                           FROM tb_likes c
                           INNER JOIN tb_livros l ON c.fk_livro_cod = l.pk_livro_cod
                           INNER JOIN tb_tagslivros j ON l.pk_livro_cod = j.fk_livro_cod
                           INNER JOIN tb_tags t ON j.fk_tag_cod = t.pk_tag_cod
                           WHERE c.fk_usu_cod = :usu_cod;");
$consulta->bindValue(":usu_cod", $usuario->getId());
$consulta->execute();
if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
    
    foreach($linhas as $linha) {
        $temp_name = $linha["tag_nome"];
        $temp_pts = ($tags[$temp_name] + $linha["like_pontos"]) / 2;
        
        $tags[$temp_name] = $temp_pts;
    }
}





//GENERO
$consulta = $pdo->prepare("SELECT DISTINCT l.livro_nome, c.like_pontos, g.gen_nome
                           FROM tb_likes c
                           INNER JOIN tb_livros l ON c.fk_livro_cod = l.pk_livro_cod
                           INNER JOIN tb_generos g ON l.fk_gen_cod = g.pk_gen_cod
                           WHERE c.fk_usu_cod = :usu_cod
                           ORDER BY l.livro_nome ASC;");

//Troca os :symbol pelos valores que irão executar
//Ao mesmo tempo protege esses valores de injection
$consulta->bindValue(":usu_cod", $usuario->getId());

//Executa o sql
$consulta->execute();

if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
    //Trabalhar com os resultados
    $books = $linhas;
} else {
    $books = false;
}
if($books != false) {
    foreach($books as $book) {
        $temp_name = $book["gen_nome"];
        $temp_pts = ($generos[$temp_name] + $book["like_pontos"]) / 2;
        
        $generos[$temp_name] = $temp_pts;
    }
}








foreach($generos as $gen_key => $gen_value) {
    echo $gen_key;
    echo " => ";
    echo $gen_value;
    echo "<br>";
}
echo "<br><br><br>";

foreach($tags as $tag_key => $tag_value) {
    echo $tag_key;
    echo " => ";
    echo $tag_value;
    echo "<br>";
}
echo "<br><br><br>";





?>



<h1>Pagina para ver as sugestões </h1>
<a href="<?php echo URL ?>/user/index.php">voltar</a><br>


<?php
    

    
//$generos =   
    
    
?>






<?php
if($books != false) {
    foreach($books as $book) {
?>
        Nome do livro: <?php echo $book['livro_nome'] ?> - 
        <?php echo $book['like_pontos'] ?> - 
        <?php echo $book['gen_nome'] ?> - 
        <?php
        foreach($generos as $tag) {
            echo $gen_key;
            echo " => ";
            echo $gen_value;
            echo "<br>";
        }
        ?><br>
<?php  
    }
}
?>  












<?php  include '../footer.php';  ?>