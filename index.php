<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "pecas_db";

$conn =  new mysqli($server, $user, $password, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " .$conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS peca(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        preco FLOAT(10) NOT NULL,
        voltagem float(10) NOT NULL)";
$conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "create") {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $voltagem = $_POST['voltagem'];
        $sql = "INSERT INTO peca (nome, preco, voltagem) VALUES ('$nome', '$preco', '$voltagem')";
        $conn->query($sql);
    }
    if ($action == "update") {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $voltagem = $_POST['voltagem'];
        $sql = "UPDATE peca SET nome='$nome', preco='$preco', voltagem='$voltagem' WHERE id = $id";
        $conn->query($sql);
    }
    if ($action == "delete") {
        $id = $_POST["id"];
        $sql = "DELETE FROM peca WHERE id = $id";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM peca");
$pecas = [];

while ($row = $result->fetch_assoc()) {
    $pecas[] = $row;
}

$conn->close();

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

    <h2>Lista de Peças</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Voltagem</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($pecas as $peca) :?>
            <tr>
                <td><?= $peca['id']?></td>
                <td><?= $peca['nome']?></td>
                <td><?= $peca['preco']?></td>
                <td><?= $peca['voltagem']?></td>
                <td>
                    <button onClick="editar(<?= $peca['id']?>, '<?= $peca['nome']?>', '<?= $peca['preco']?>', '<?= $peca['voltagem']?>')">Editar</button>
                    <button onClick="excluir(<?= $peca['id']?>)">Excluir</button>
                </td>
            </tr>
        <?php endforeach;?>
    </table>

    <script>
        document.getElementById("pecaForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch("", {method: "POST", body: formData}).then(response => location.reload());
        });

        function editar(id, nome, preco, voltagem) {
            document.getElementById("id").value = id;
            document.getElementById("nome").value = nome;
            document.getElementById("preco").value = preco;
            document.getElementById("voltagem").value = voltagem;
            document.getElementById("action").value = "update";
        }

        function excluir(id) {
            if (confirm("Deseja realmente excluir esta peça?")) {
                const formData = new FormData();
                formData.append("action", "delete");
                formData.append("id", id);
                fetch("", {method: "POST", body: formData}).then(response => location.reload());
            }
        }
    </script>
</body>
</html>