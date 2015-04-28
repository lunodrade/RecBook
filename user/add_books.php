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

    <style type="text/css">
        .outer-container-templ {
            display: block;
        }
        .flex-container {
          padding: 0;
          margin: 10px;
          list-style: none;
          display: -webkit-box;
          display: -moz-box;
          display: -ms-flexbox;
          display: -webkit-flex;
          display: flex;
          -webkit-flex-flow: row wrap;
          justify-content: center;
        }

        .flex-item {
          background: rgba(255, 101, 73, .5);
          padding: 25px 5px;
          width: 400px;
          height: 250px;
          margin: 10px;
          color: white;
          font-weight: bold;
          text-align: center;
        }

        .flex-item:hover {
          background: rgb(255, 124, 100);
        }
        
        .teste {
            margin-left: -10px;
            margin-top: -20px;
              width: inherit;
              text-align: right;
            padding-bottom: 20px;
        }
        
        .teste > button {
            
        }
        
        .teste-select {  
              background-color: rgba(250,250,250,.5);
            padding-left: 15px;
  height: 33px;
  color: black;
  width: 70px;
  display: inline-block !important;
  border-radius: 5px;
  display: inline-block !important;
        }
        
        .title-item {
            font-size: 18px;
            color: rgb(65, 65, 65);
        }
        
        .label-item {
            color: rgb(216, 210, 210);
        }
        
        .btn-info {
            background-color: rgba(91, 192, 222, 0.63);
            border-color: rgba(70, 184, 218, 0.71);
        }

    </style>

<div class="outer-container">
    <div class="inner-container">
        <a href="<?php echo URL ?>/user/index.php">voltar</a><br>
        <h1>Avalie os livros que j&aacute; leu</h1>
        <p>Importante: avalie apenas os que leu, indiferente de se gostou ou n&atilde;o.</p>
    </div>
</div>
<br>
<br>
<br>

<ul class="flex-container">
<?php
$books = getBooks();
if($books != false) {
    foreach($books as $book) {
?>
<li class="flex-item" id="<?php echo $book["pk_livro_cod"] ?>">
                    <div class="teste">
                    <form id="ratingForm<?php echo $book["pk_livro_cod"] ?>" class="form-horizontal" role="form" action="save_rating.php" method="post">
                       <select required class="teste-select" name="rating" class="form-control">
                        <option value=""></option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>

                        </select> 
                        <input type="hidden" name="book" value="<?php echo $book["pk_livro_cod"] ?>">
                        <button id="btn-signup" type="submit" class="btn btn-info">
                        <i class="icon-hand-right"></i> &nbsp; Votar</button>

                    </form>
                    </div>
                    <span class="title-item"><?php echo $book['livro_nome'] ?></span><br><br>
                    <span class="label-item">Resumo:</span> <?php echo $book['livro_desc'] ?><br><br>
                    <span class="label-item">G&ecirc;nero:</span> <?php echo $book['gen_nome'] ?>.<br>
                    <span class="label-item">Tags:</span> 

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
                    
                    
                    
                    
                    
                    
</li>
<?php  
    }
}
?>
</ul>











<?php  include '../footer.php';  ?>