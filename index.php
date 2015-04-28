<?php  include 'header.php';  ?>

    <style type="text/css">

    </style>
         
    <div class="inner-container">
        <h1>Bem-vindo ao RecBooks,</h1>
        <h1>suas melhores recomenda&ccedil;&otilde;es em livros &#59;&nbsp;&#41;</h1>
    </div>
    <?php
        if ($aut->esta_logado()) {
            header('Location: '.URL.'/user/index.php');
        }
    ?>
    
    
	<script type="text/javascript">
    </script>
          
          
<?php  include 'footer.php';  ?>