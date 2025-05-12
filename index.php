<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "pecas_db";

$conn =  new mysqli($server, $user, $password, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " .$conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        button {
            margin: 5px;
            padding: 5px 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Cadastro de Clientes</h2>
    <form id="pecaForm">
        <input type="hidden" name="action" id="action" value="create">

        <input type="hidden" name="id" id="id">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="preco">Preço:</label>
        <input type="text" name="preco" id="preco" required>

        <label for="voltagem">Voltagem:</label>
        <input type="text" name="voltagem" id="voltagem">

        <button type="submit">Salvar</button>
    </form>
</body>
</html>