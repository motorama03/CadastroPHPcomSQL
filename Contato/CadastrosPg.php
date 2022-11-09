<?php
    include 'acaobd.php';
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

    
</head>
<body class="body">

    <script src="js.js"></script>

            <form  method="post" > <!--/* onsubmit= (aspas duplas) validafuncao() */ onsubmit="validafuncao()-->
                    <table>

                            <div class="inputbox">
                                <div class="">
                                    <label for="nome" id="nome" name="nome"></label>Informe o nome do contato<br>
                                    <input type="text" id="in_nome" name="nome" value="" > <br>
                                    <h8 class="text-danger" id="nomeinvalido"></h8>
                                    <label for="sobrenome" id="sobrenome" name="sobrenome"></label>Informe o sobrenome do contato<br>
                                    <input type="text" id="in_sobrenome" name="sobrenome" value=""><br><br>
                                    <h8 class="text-danger" id="sobrenomeinvalido"></h8>
                                </div>
                            </div>
                        
                        
                            <div class="inputbox">
                                <div class="">
                                    <label for="email" id="email" name="email" ></label>Digite um e-mail<br>
                                    <input type="email" id="in_email" name="email" value="" ><br>
                                    <h8 class="text-danger" id="emailinvalido"></h8>
                                    <label for="senha" id="senha" name="senha"></label>Digite uma senha<br>
                                    <input type="password" id="in_senha" name="senha" value="" ><br><br>
                                    <h8 class="text-danger" id="senhainvalida"></h8>
                                </div>
                            </div>
                        
                        
                            <div class="inputbox">
                                <div class="">
                                    <label for="datanasc" id="datanasc" name="datanasc">Informe sua data de nascimento</label><br>
                                    <input type="date" id="in_datanasc" name="datanasc" value="" class="datanasc" ><br>
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

            <?php

            try{
                $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados

                // Mostrar consulta; 
            $consulta = 'SELECT * FROM agenda';

            // Prepara a consulta para executar
            $comando = $conexao->prepare($consulta);// prepare valida dados se condizem com as limitações do banco

            // Executa a consulta
            $comando->execute();

            // Pega retorna da consulta
            $listacontatos = $comando->fetchAll();

            //
            echo "<table>";
            echo"   <tr>
                        <th>Id</th><th>nome</th><th>sobrenome</th><th>Email</th><th>senha</th><th>dataNascimento</th>
                    </tr>";
            foreach($listacontatos as $contato){
                echo "<tr>";
                echo "<td>".$contato['id']."</td><td>".$contato['nome']."</td><td>".$contato['sobrenome']."</td><td>".$contato['email']."</td><td>".$contato['senha']."</td><td>".$contato['datanasc']."</td>";
                echo "</tr>";
            }
            echo "</table>";

            }catch(PDOException $e){
                print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
                die();
            }
            ?>
    </body>
<!-- Roda pé -->
<footer class="tudo">

</footer> 