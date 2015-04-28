<?php  
    include '../header.php';   
    require_once 'cadastro.php';
?> 

<style type="text/css">
    .inner.cover {
          border: 2px solid rgba(125, 125, 125, .2);
          box-shadow: 0px 5px 20px 0px rgba(25, 25, 25, 0.60);
          padding: 5% 10% 5% 10%;
          background-color: rgba(125, 125, 125, 0.20);
    }
    input {
        height: 3em;
    }
    h1 {
        margin-bottom: 8%;
    }
    #btn-signup {
        margin-left: 120px;
        margin-top: 5%;
    }
    .form-control:focus {
        -webkit-box-shadow: rgba(0, 0, 19, 0.0745098) 0px 17px 25px 0px inset, rgba(102, 175, 233, 0.6) 0px 0px 5px 3px;
    }
    
    .btnCheck {
        height: 34px;
        width: 69px;
        border-radius: 4px;
        color: black;
    }
    
    .title-post {
          margin-left: 60px;
          margin-bottom: 50px;
    }
    
    /* CSS de campos válidos e inválidos pelo pattern */
    input:invalid   { background-color: white; color: red; }
    
</style>


<div class="inner cover">
   
    <h1 class="title-post">Crie uma conta</h1>
    
    
    
    <form id="signupform" class="form-horizontal" role="form" action="functions.php?acao=salvar" method="post">
    

    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Nome</label>
        <div class="col-md-9">
            <input pattern="[A-Z]{1}[a-z]*" title="Somente um nome, primeira letra maiuscula"
            type="text"  class="form-control" required name="nome" placeholder="Primeiro nome">
        </div>
    </div>    
    
    
      <div class="form-group">
         <label for="email" class="col-md-3 control-label">Email</label>
         <div class="col-md-7">
            <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
            title="seuemail@dominio.com"
            class="form-control" required id="email" name="email" type="email"  placeholder="Digite o email" />
          </div>
               <div class="col-md-2">
                <button tabindex="-1" class="btnCheck btn btn-default">check</button>
            </div>
     </div>
    
    
    <div class="form-group">
        <label for="password" class="col-md-3 control-label">Senha</label>
        <div class="col-md-9">
            <input pattern="[a-z0-9]{5}[a-z0-9]*" type="password" required class="form-control" name="senha" placeholder="Senha"
            title="A senha deve conter no minimo 5 digitos sendo letras ou números">
            
        </div>
    </div>
    
    <div class="form-group">
    <label for="sexo" class="col-md-3 control-label">Sexo</label>
    <div class="col-md-9">
        <select  name="sexo" required class="form-control">
            <option value=""></option>
            <option value="m">Masculino</option>
            <option value="f">Feminino</option>
                            
        </select> 
    </div>
    </div>
    
    <div class="form-group">
        <label for="lastname" class="col-md-3 control-label">Idade</label>
        <div class="col-md-9">
        <input  pattern="[0-9]{2}" 
            title="Informe somente números, deve ter dois números"    
            type="text" required class="form-control" name="idade" placeholder="Idade">
        </div>
    </div>
    
    

    <div class="form-group">                               
        <div class="col-md-12">
            <button data-ok="false" id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp; Sign Up</button>

        </div>
    </div>

    </form>
    
    
</div>

<!-- ********************************************* -->

    <script type="text/javascript">
    	jQuery(document).ready(function($) {
                        
    		$('.btnCheck').click(function(){
    		// e.preventDefault();
                makeAjaxRequest();
                return false;
    		});

                        
            $('form').submit(function(e){
                var ret = $("button[type=submit]").attr("data-ok");
                            
                if(ret === "true")
                    return true;
                else {
                    showModal();
                    return false;
                }
            });
                        
            $('#email').change(function() {
                makeAjaxRequest();
            })

            function makeAjaxRequest() {
                $.ajax({
                    url: '../ajax/checkAvailability.php',
                    type: 'get',
                    data: {email: $('input#email').val()},
                    async: false,
                    success: function(response) {
                        if(response == "<p>Disponivel</p>") {
                            $('.btnCheck').removeClass('btn-default btn-danger').addClass('btn-success');
                            $("button[type=submit]").attr("data-ok", "true");
                        } else {
                            $('.btnCheck').removeClass('btn-default btn-success').addClass('btn-danger');
                            $("button[type=submit]").attr("data-ok", "false");
                        }
                    }
                });
                
            }
    	});
    </script>



<?php  include '../footer.php';  ?>