<?php
// adicionar arquivos da foto!!!
    include "conf.inc.php";    

    if(isset($_POST['nome'])&&(isset($_POST['email']))){
        $id = isset($_POST['id'])?$_POST['id']:0;
        $nome = isset($_POST['nome'])?$_POST['nome']:"";
        $sobrenome = isset($_POST['sobrenome'])?$_POST['sobrenome']:"";
        $email = isset($_POST['email'])?$_POST['email']:"";
        $senha = isset($_POST['senha'])?$_POST['senha']:"";

        try{
            $conexao = new PDO(MYSQL_DSN,DB_USER,DB_PASSWORD);//cria conexão com banco de dados

            // Monta a consulta
            if($id > 0)
                $query = "UPDATE agenda SET nome = :nome, sobrenome = :sobrenome, email = :email, senha = :senha 
                WHERE id = :id";
            
            else
            $query = 'INSERT INTO agenda(nome, sobrenome, email, senha) VALUES (:nome, :sobrenome, :email, :senha)';

            $stmt = $conexao->prepare($query);
            if($id != 0)
            $stmt->bindValue(':id', $id);

            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':sobrenome', $sobrenome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':senha', $senha);

            $stmt->execute();
            if($stmt->execute())
                    header('location: CadastrosPg.php');

            

        }catch(PDOException $e){
            print("Erro ao conectar com o banco de dados...<br>".$e->getMessage());
            die();
    }
}

?>