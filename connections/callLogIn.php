<?php
    if(isset($_POST['LogIn'])){
        $username = mysqli_real_escape_string($conn, $_POST['nome']);
        $password = $_POST['senha'];

        $sql = "SELECT * FROM cadastro WHERE nome='$username'";

        $result = mysqli_query($conn, $sql);
        $usuario = mysqli_fetch_assoc($result);


        if(!$usuario){
            echo "<h1>Nome ou senha incorretos.</h1>";
            exit();
        }

        if(password_verify($password, $usuario['senha'])){
            session_start();
            $_SESSION['user_id'] = $usuario['ID'];
            $_SESSION['nome'] = $usuario['nome'];
            header("Location: main.php");
            exit();
        } else {
            echo "<h1>Nome ou senha incorretos.</h1>";
        }
    }
?>