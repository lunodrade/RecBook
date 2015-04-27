<?php  include 'header.php';  ?>

    <style type="text/css">

    </style>

         
    <h1>pagina inicial para deslogado</h1>
    
    <?php
        if ($aut->esta_logado()) {
            header('Location: '.URL.'/user/index.php');
        }
    ?>
    
    
	<script type="text/javascript">
    </script>
          
          
<?php  include 'footer.php';  ?>