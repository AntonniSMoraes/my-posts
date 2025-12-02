<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exerc 1</title>
</head>
<body>

<form method="GET" action="">
    <label>Nome:</label><br>
    <input type="text" name="nome"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>Idade:</label><br>
    <input type="number" name="idade"><br><br>

    <button type="submit">Enviar</button>
</form>

<?php
    if (!empty($_GET)) {
        echo "<h2>Dados Recebidos</h2>";
        echo "Nome: " . $_GET["nome"] . "<br>";
        echo "Email: " . $_GET["email"] . "<br>";
        echo "Idade: " . $_GET["idade"] . "<br>";
    }
?>

</body>
</html>
