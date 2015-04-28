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




<h1>Pagina para ver as sugestões </h1>
<a href="<?php echo URL ?>/user/index.php">voltar</a><br>
<br>
<br>
<br>
<br>
<br>


<?php
    
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
$consulta = $pdo->prepare("SELECT DISTINCT l.pk_livro_cod, j.pk_tagslivros_cod, t.tag_nome, c.like_pontos
                           FROM tb_likes c
                           INNER JOIN tb_livros l ON c.fk_livro_cod = l.pk_livro_cod
                           INNER JOIN tb_tagslivros j ON l.pk_livro_cod = j.fk_livro_cod
                           INNER JOIN tb_tags t ON j.fk_tag_cod = t.pk_tag_cod
                           WHERE c.fk_usu_cod = :usu_cod;");
$consulta->bindValue(":usu_cod", $usuario->getId());
$consulta->execute();
if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
    $books_tags = $linhas;
}
if($books_tags != false) {
    foreach($books_tags as $book_tag) {
        $temp_name = $book_tag["tag_nome"];
        $temp_pts = ($tags[$temp_name] + $book_tag["like_pontos"]) / 2;
        
        $tags[$temp_name] = $temp_pts;
    }
}





//GENERO
$consulta = $pdo->prepare("SELECT DISTINCT 1 AS recpoints, l.pk_livro_cod, l.livro_nome, c.like_pontos, g.gen_nome
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


<?php
    

    
//$generos =   
    
    
?>






<?php
if($books != false) {
    foreach($books as $book) {
?>
        Nome do livro: <?php echo $book['livro_nome'] ?> - 
        <?php echo $book['like_pontos'] ?> - 
        <?php echo $book['recpoints'] ?> - 
        <?php echo $book['gen_nome'] ?><br>
<?php  
    }
}
?>  



<h1>Recomendações </h1>
<?php

/////////////////////////////////////////////////////////////////////////////
///////////// GERAR A RECOMENDAÇÃO //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
function similaridade($atributoNovo, $atributoBanco, $peso){
    $valor = $peso*(($atributoNovo - $atributoBanco)*($atributoNovo - $atributoBanco));
    $valor =  sqrt($valor);
    return $valor;
}
function make_comparer() {
    // Normalize criteria up front so that the comparer finds everything tidy
    $criteria = func_get_args();
    foreach ($criteria as $index => $criterion) {
        $criteria[$index] = is_array($criterion)
            ? array_pad($criterion, 3, null)
            : array($criterion, SORT_ASC, null);
    }

    return function($first, $second) use (&$criteria) {
        foreach ($criteria as $criterion) {
            // How will we compare this round?
            list($column, $sortOrder, $projection) = $criterion;
            $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

            // If a projection was defined project the values now
            if ($projection) {
                $lhs = call_user_func($projection, $first[$column]);
                $rhs = call_user_func($projection, $second[$column]);
            }
            else {
                $lhs = $first[$column];
                $rhs = $second[$column];
            }

            // Do the actual comparison; do not return if equal
            if ($lhs < $rhs) {
                return -1 * $sortOrder;
            }
            else if ($lhs > $rhs) {
                return 1 * $sortOrder;
            }
        }

        return 0; // tiebreakers exhausted, so $first == $second
    };
}
//////////////////////////////////////////////////////////////////////////////////////


//TODOS LIVROS NA BASE DE DADOS
$consulta = $pdo->prepare("SELECT DISTINCT 1 AS recpoints, l.pk_livro_cod, l.livro_nome, g.gen_nome
                           FROM tb_livros l
                           INNER JOIN tb_generos g ON l.fk_gen_cod = g.pk_gen_cod
                           ORDER BY l.livro_nome ASC;");
//Executa o sql
$consulta->execute();

if ($linhas = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
    //Trabalhar com os resultados
    $recbooks = $linhas;
} else {
    $recbooks = false;
}

$booksPtsArray = array();

if($recbooks != false) {
    foreach($recbooks as $recbook) {
        $gen_pts = similaridade(5, $generos[$recbook["gen_nome"]], 2);
        $tag_pts = 0;
        $div_count = 0;
            
        foreach($books_tags as $book_tag) {
            if($book_tag["pk_livro_cod"] == $recbook["pk_livro_cod"]) {                
                $temp = similaridade(5, $tags[$book_tag["tag_nome"]], 3);
                $tag_pts += $temp;
            }
            $div_count += 1;
        }
        
        if($div_count > 0) {
            $tag_pts = $tag_pts / $div_count;
        }
            
        $total_pts = ($gen_pts + $tag_pts) / 2;
        //$recbook["recpoints"] = $total_pts;
        
        $tempArray = array("recpoints" => $total_pts, "livro_nome" => $recbook["livro_nome"], "pk_livro_cod" => $recbook["pk_livro_cod"]);
        $booksPtsArray[count($booksPtsArray)] = $tempArray;
        //echo $recbook["livro_nome"] . " - Possui similaridade com voce de: " . "<br>" . $recbook["recpoints"] . "<br><br>";
        
    }
}

usort($booksPtsArray, make_comparer('recpoints'));

//foreach($booksPtsArray as $bookPts) {
if(count($booksPtsArray) > 10) {
    $size = 10;
} else {
    $size = count($booksPtsArray);
}
for($i = 0; $i < $size; $i++) {
    $bookPts = $booksPtsArray[$i];
    echo $bookPts["livro_nome"] . " - Possui similaridade com voce de: " . "<br>" . $bookPts["recpoints"] . "<br><br>";
}












/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////


?>








<?php  include '../footer.php';  ?>