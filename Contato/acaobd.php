<?php

    include "conf.inc.php";    

    if(isset($_POST['nome'])&&(isset($_POST['email']))){

        $nome = isset($_POST['nome'])?$_POST['nome']:"";
        $sobrenome = isset($_POST['sobrenome'])?$_POST['sobrenome']:"";
        $email = isset($_POST['email'])?$_POST['email']:"";
        $senha = isset($_POST['senha'])?$_POST['senha']:"";
        $datanasc = isset($_POST['datanasc'])?$_POST['datanasc']:"";

        try{
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados

            // Monta a consulta
            $query = 'INSERT INTO agenda(nome, sobrenome, email, senha, datanasc) VALUES (:nome, :sobrenome, :email, :senha, :datanasc)';

            // Preparar consulta
            $stmt = $conexao->prepare($query);

            //Vincula váriaveis com a consulta
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':sobrenome', $sobrenome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':senha', $senha);
            $stmt->bindValue(':datanasc', $datanasc);

            $stmt->execute();

            

        }catch(PDOException $e){
            print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
            die();
    }
}

?>