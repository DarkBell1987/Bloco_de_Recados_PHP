<?php
//Inclui o arquivo de conexão
require 'conexao.php';

//Verifica se o método de requisição é POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Obtém os valores enviados pelo Formulário
    //HTMLSPECIALCHARS -> Limpa o que a pessoa escrever
    $nome = htmlspecialchars($_POST['nome']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $mensagem = htmlspecialchars($_POST['mensagem']);

    // Cria a instrução SQL para inserir um novo recado
    $sql = "INSERT INTO recados (nome,Telefone,mensagem) VALUES (:nome, :telefone, :mensagem)";

    $stmt = $pdo->prepare($sql);
    $stmt -> execute([':nome' => $nome, ':telefone' =>$telefone, ':mensagem' => $mensagem]);
}
//Realizar uma consulta no banco de dados para trazer os recados
//FetchAll() retorna todos os resultados em um array
$recados = $pdo->query("Select * from recados order by data_envio DESC") ->fetchAll();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloco de Recados</title>
</head>
<body>
    <h1>Deixe seu Recado!</h1>
    <!-- Formulário HTML para Enviar novos Recados-->
     <form method="post" action="">
        <!-- Campo de texto para o nome do usuário -->
         <input tpe="text" name="nome" placeholder="Seu Nome" require>
         <input tpe="text" name="telefone" placeholder="Seu Tel " require>
         <textarea name="mensagem" placeholder="Sua Mensagem" require>
         </textarea>
         <button type="submit">Enviar</button>
     </form>
     <br>
     <h2>Recados Anteriores</h2>
     <?php if(count($recados) > 0): ?>
        <?php foreach($recados as $r): ?>
            <p><strong><?= $r['nome'] ?></strong><?= $r['mensagem'] ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum Recado ainda ...</p>
        <?php endif; ?>
</body>
</html>