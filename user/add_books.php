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

function getBooks() {
    //Conectar no banco
    $pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME."", DBUSER, DBPASS);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    //Prepara o query, usando :values
    $consulta = $pdo->prepare("SELECT DISTINCT l.pk_livro_cod, l.livro_nome, l.livro_desc, g.gen_nome
                               FROM tb_livros l
                               LEFT JOIN tb_generos g ON l.fk_gen_cod = g.pk_gen_cod
                               ORDER BY l.pk_livro_cod ASC;");

    //Executa o sql
    $consulta->execute();

    if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
        //Trabalhar com os resultados
        return $linhas;
    } else {
        return false;
    }
}

function getTags($livro_cod) {
    //Conectar no banco
    $pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME."", DBUSER, DBPASS);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    //Prepara o query, usando :values
    $consulta = $pdo->prepare("SELECT DISTINCT t.tag_nome
                               FROM tb_livros l
                               INNER JOIN tb_tagslivros c ON c.fk_livro_cod = l.pk_livro_cod
                               INNER JOIN tb_tags t ON c.fk_tag_cod = t.pk_tag_cod
                               WHERE l.pk_livro_cod = :livro_cod;
                               ORDER BY t.tag_nome ASC;");

    //Troca os :symbol pelos valores que irão executar
    //Ao mesmo tempo protege esses valores de injection
    $consulta->bindValue(":livro_cod", $livro_cod);

    //Executa o sql
    $consulta->execute();

    if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
        //Trabalhar com os resultados
        return $linhas;
    } else {
        return false;
    }
}

?>



<h1>Pagina para lista e adicionar os livros </h1>
<a href="<?php echo URL ?>/user/index.php">voltar</a><br>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<?php
$books = getBooks();
if($books != false) {
    foreach($books as $book) {
?>
        Nome do livro: <?php echo $book['livro_nome'] ?><br>
        Resumo: <?php echo $book['livro_desc'] ?><br>
        G&ecirc;nero: <?php echo $book['gen_nome'] ?><br>
        Tags: 
        
        <?php
        $tags = getTags($book["pk_livro_cod"]);
        if($tags) { 
            foreach($tags as $tag) {
        ?>
                <?php echo $tag['tag_nome'] ?>;
        <?php  
            }
        }
        ?>  
        <br>
        
        
        
        <form id="ratingForm<?php echo $book["pk_livro_cod"] ?>" class="form-horizontal" role="form" action="save_rating.php" method="post">
        
        
        <div class="form-group">
            <label for="rating" class="col-md-1 control-label">Avalie</label>
            <div class="col-md-2">
                <select name="rating" class="form-control">
                    <option value=""></option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>

                </select> 
            </div>

            <input type="hidden" name="book" value="<?php echo $book["pk_livro_cod"] ?>">
            <button id="btn-signup" type="submit" class="btn btn-info">
            <i class="icon-hand-right"></i> &nbsp; Votar</button>
        </div>
        </form>
        <br>
        
        
        
        
        <br>
        <br>
        <br>

<?php  
    }
}
?>












<?php  include '../footer.php';  ?>