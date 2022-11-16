<?php
// adicionar arquivos da foto!!!
    include "conf.inc.php";    

    if(isset($_POST['nome'])&&(isset($_POST['email']))){

        $nome = isset($_POST['nome'])?$_POST['nome']:"";
        $sobrenome = isset($_POST['sobrenome'])?$_POST['sobrenome']:"";
        $email = isset($_POST['email'])?$_POST['email']:"";
        $senha = isset($_POST['senha'])?$_POST['senha']:"";

        try{
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados

            // Monta a consulta
            $query = 'INSERT INTO agenda(nome, sobrenome, email, senha) VALUES (:nome, :sobrenome, :email, :senha)';

            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':sobrenome', $sobrenome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':senha', $senha);

            $stmt->execute();

            

        }catch(PDOException $e){
            print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
            die();
    }
}

?>