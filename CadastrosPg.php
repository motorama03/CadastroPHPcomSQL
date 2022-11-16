<?php
    include 'acaobd.php';
    include_once 'conf.inc.php';

    $acao = isset($_GET['acao'])?$_GET['acao']:"";
    $id = isset($_GET['id'])?$_GET['id']:"";

    if ($acao == 'editar'){
        //busca dados do usuario

        try{
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados
            $query = 'SELECT * FROM agenda WHERE id = :id';
            
           
            // Monta consulta
            $stmt = $conexao->prepare($query);

            //Vincula váriaveis com a consulta
            $stmt->bindValue(':id',$id);
            $stmt->execute();
            $usuario = $stmt->fetch();

    }catch(PDOException $e){
        print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
        die();
    }
}
    else{
        if ($acao == 'excluir'){
            try{

                $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);
                $query = 'DELETE FROM agenda WHERE id = :id';

                $stmt = $conexao->prepare($query);
                $stmt->bindValue(':id',$id);

                if($stmt->execute())
                    header('location: Cadastro.php');
                else 
                    echo 'Erro ao excluir dados';
            }catch(PDOException $e){
                print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
                die();
            }
        }
    }
?>

<!DOCTYPE html>
<head class="tudo">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Primeiro site</title>

    <Style>

        .Centroform{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .body{
            background-image: linear-gradient(rgb(244, 250, 244), rgb(146, 146, 146));
        }
        .box{
            position: absolute;
            top: 50%;
            left: 50%;
            background-color: rgb(255, 255, 255, 0.6);
            transform: translate(-50%, -50%);
            padding: 15px;
            width: 35%;
        }
        .inputbox{
            position: relative;
            text-align: center;
        }
        .errado{
            text-decoration: red;
        }
    </Style>

    <script>
        function excluir(url){
            if(confirm("Confirma a exclusão?"))
                header(url);
        }
    </script>
    
</head>
<body class="body">

    <script src="js.js"></script>

            <form action="acaobd.php" method="post" > <!--/* onsubmit= (aspas duplas) validafuncao() */ onsubmit="validafuncao()-->
                    <table>

                            <div class="inputbox">
                                <div class="">
                                    <input readonly type="text" name="id" id="id" value=<?php if(isset($usuario))echo $usuario['id']; else echo 0 ?> ><br>
                                    <label for="nome" id="nome" name="nome"></label>Informe o nome do contato<br>
                                    <input type="text" id="in_nome" name="nome" value=<?php if(isset($usuario))echo $usuario['nome'] ?> > <br>
                                    <h8 class="text-danger" id="nomeinvalido"></h8>
                                    <label for="sobrenome" id="sobrenome" name="sobrenome"></label>Informe o sobrenome do contato<br>
                                    <input type="text" id="in_sobrenome" name="sobrenome" value=<?php if(isset($usuario))echo $usuario['sobrenome'] ?>><br><br>
                                    <h8 class="text-danger" id="sobrenomeinvalido"></h8>
                                </div>
                            </div>
                        
                        
                            <div class="inputbox">
                                <div class="">
                                    <label for="email" id="email" name="email" ></label>Digite um e-mail<br>
                                    <input type="email" id="in_email" name="email" value=<?php if(isset($usuario))echo $usuario['email'] ?>><br>
                                    <h8 class="text-danger" id="emailinvalido"></h8>
                                    <label for="senha" id="senha" name="senha"></label>Digite uma senha<br>
                                    <input type="password" id="in_senha" name="senha" value=<?php if(isset($usuario))echo $usuario['senha'] ?>><br><br>
                                    <h8 class="text-danger" id="senhainvalida"></h8>
                                </div>
                            </div>
                        
                        
                            <div class="inputbox">
                                <div class="">
                                    <label for="datanasc" id="datanasc" name="datanasc">Informe sua data de nascimento</label><br>
                                    <input type="date" id="in_datanasc" name="datanasc" class="datanasc" ><br>
                                </div>
                            </div>

                        <div class="inputbox">
                            <div class="">
                                <input type="submit" id="enviar" name="acao" value="salvar" >
                            </div>
                        </div>

                        <div>
                            <div class="inputbox">
                                <h4>Resultado do cadastro (via JSON):</h4>
                                <h7><b id="area"> </b></h7>
                            </div>
                        </div>
                        
                    </table>
                    
            </form>
            <form method="">
                <div>
                    <div>
                        <label for="busca" id="busca">
                        <input type="text" name="busca" id="busca" value="">
                        <input type="submit">
                    </div>
                </div>

            </form>
            <?php

            try{
                $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados
                $busca = isset($_GET['search'])?$_GET['busca']:"";

                // Mostrar consulta; 
                $consulta = 'SELECT * FROM agenda';
                if ($busca != ""){
                    $busca = '%'.$busca.'%';
                    $consulta .= ' where nome like :busca';
                }
                // Preparar consulta
                $stmt = $conexao->prepare($consulta);

                //Vincula váriaveis com a consulta
                if($busca != "")
                    $stmt->bindValue(':busca',$busca);
                $stmt->execute();
                $listacontatos = $stmt->fetchAll();
   
                echo "<table>";
                echo'   <tr>
                            <th></th><th>Id</th><th>nome</th><th>sobrenome</th><th>Email</th><th>senha</th><th>dataNascimento</th><th>Del</th>
                        </tr>';
                foreach($listacontatos as $contato){
                    $editar = '<a href=CadastrosPg.php?acao=editar&id='.$contato['id'].'>Alt</a>';
                    $excluir = "<a href='#' onclick=excluir('acao.php?acao=excluir&id={$contato['id']}')>Excluir</a>";
                    echo "<tr>";
                    echo "<td>".$contato['id']."</td><td>".$contato['nome']."</td><td>".$contato['sobrenome']."</td><td>".$contato['email']."</td><td>".$contato['senha']."</td><td>".$contato['datanasc']."</td><td>".$editar."</td><td>".$excluir."</td>";
                    echo "</tr>";
                }
                echo "</table>";

            }catch(PDOException $e){
                print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
                die();
            }
            ?>
    </body>
