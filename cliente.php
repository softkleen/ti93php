<?php 
include 'conecta.php';
// criando consulta SQL 
$consultaSql = "SELECT * FROM cliente order by nome asc, cod_cliente asc"; // negócio???
// buscando e listando os dados da tabela (completa)
$lista = $conn->query($consultaSql);
// separar em linhas
$row = $lista->fetch();
// retornando o númaru de linhas
$num_rows = $lista->rowCount();






if(isset($_POST['bt-enviar']))
{
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $insertSql = "insert cliente (nome, cpf) values('$nome','$cpf');";
    $resultado = $conn->query($insertSql);
    header('location: cliente.php');
}
$senac = $senancsd=="dahora"?"monstro":"fraco";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes (<?php echo $num_rows?>)</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form action="cliente.php" method="post">
        <div hidden>
            <label for="cod">Código
                <input type="text" name="cod" id=""></label>
        </div>
        <div class="campo">
            <label for="nome">Nome
                <input type="text" name="nome" id=""></label>
        </div>
        <div class="campo">
            <label for="cpf">CPF
                <input type="number" name="cpf" id=""></label>
        </div>
        <div class="campo">
            <label for="cpf">classificacao
                <select name="classificacao" id="">
                    <?php
                        $lst_class = $conn->query('SELECT * FROM db_locadora_93.classificacao;');
                        $row_class = $lst_class->fetch(); 
                        do{ 
                    ?>
                        <option value="<?php echo $row_class['cod_classificacao'] ?>"><?php echo $row_class['classificacoes']?></option>
                    <?php } while($row_class = $lst_class->fetch()); ?>
                </select>
                </label>
        </div>
        <div class="campo">
             <button type="submit" name="bt-enviar">Enviar</button>
        </div>
       
    </form>
    <table class="tabelinha">
        <thead>
            <th>Cod</th>
            <th>Nome</th>
            <th>CPF</th>
        </thead>
        <tbody>
            <?php do {?>
                <tr>
                    <td><?php echo $row['cod_cliente'];?></td>
                    <td><?php echo $row['nome'];?></td>
                    <td><?php echo $row['cpf'];?></td>
                </tr>
            <?php } while ($row = $lista->fetch())?>
        </tbody>
    </table>
</body>
</html>

