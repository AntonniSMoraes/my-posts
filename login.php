<?php
    include("conect.php");

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
</head>
<body style="width: 100vw; height: 100vh; padding: 0; margin: 0;">
    <section style="
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100vh;
            margin: 0;
            align-items: center;
            justify-content: center;
            background-color: lightcyan;
        "
    >
        <article style="
            display: flex;
            flex-direction: column;
            width: calc(20% - 40px);
            align-items: center;
            justify-content: center;
            background-color: darkcyan;
            border-radius: 1rem;
            padding: 20px;
            box-shadow: 5px 5px 10px rgba(0,0,0,0.1);
            "
        >
            <h1>Log In</h1>
            <form action="login.php" method="post" style="
                display: flex;
                flex-direction: column;
                width: 100%;
                ">
                <input type="text" name="nome" placeholder="nome" style="
                    margin-bottom: 10px;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    ">
                <input type="password" name="senha" placeholder="senha" style="
                    margin-bottom: 10px;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    ">
                <input type="submit" name="LogIn" value="LogIn" style="
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    background-color: darkslategray;
                    color: white;
                    cursor: pointer;
                    ">
                <a href="signup.php" style="
                    margin-top: 10px;
                    text-align: center;
                    color: white;
                    text-decoration: none;
                    ">Não tem conta? Cadastre-se</a>
            </form>
        </article>
    </section>
</body>
</html>