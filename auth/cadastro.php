<?php 

require_once '../database.php';
			
class Cadastro extends ConfigController {	
	function __construct() {	
        parent::__construct();
	}
	
	public function salvar() {	
		try {
			if(isset($_POST) && !empty($_POST)) {
                
                //Conectar no banco
                $pdo = $this->conn;

                //Prepara o query, usando :values
                $query = $pdo->prepare("INSERT INTO tb_usuarios
                                        (usu_email, usu_senha, usu_tipo, usu_conf, usu_hash, usu_nome, usu_sexo, usu_idade) 
                                        VALUES
                                        (:email, :senha, :tipo, :conf, :hash, :nome, :sexo, :idade);");

                //Troca os :symbol pelos valores que irão executar
                //Ao mesmo tempo protege esses valores de injection
                $query->bindValue(":email",     $_POST["email"]);
                $query->bindValue(":senha",     $_POST["senha"]);
                $query->bindValue(":tipo",      "user");
                $query->bindValue(":conf",      false);
                $query->bindValue(":hash",      "");
                $query->bindValue(":nome",      $_POST["nome"]);
                $query->bindValue(":sexo",      $_POST["sexo"]);
                $query->bindValue(":idade",     $_POST["idade"]);

                //Executar o sql
                if($query->execute()) {

                    //A query foi executada com sucesso
                    $usuarioID = $pdo->lastInsertId();

                    // Enviar pra página que manda o email de confirmação do cadastro
                    header("Location: " . URL . '/auth/sendmail_confirmation.php?user=' . $usuarioID);
                } else {

                    //Erro ao inserir usuário
                    echo "erro - usuario \n";
                    die();
                }
			}
		} catch (Exception $e) {
			if(DEBUG){
				echo 'Erro ao cadastrar registro!!!! \n<br>';
				echo $e->getMessage();
			} else {
				echo 'Erro ao cadastrar registro! \n';
			}
		}  
	}
}

if(class_exists('Cadastro') && !isset($class))
{	
	$class 	= new Cadastro();
}

?>