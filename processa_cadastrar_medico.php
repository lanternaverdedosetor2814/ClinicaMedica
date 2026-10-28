<?php
require_once "Medico.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Instancia o objeto Médico com os dados do formulário
    $crm = $_POST['crm'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $especialidade = $_POST['especialidade'] ?? '';

    $medico = new Medico($crm, $nome, $especialidade);

    // Executa a operação de cadastro
    $resultado = $medico->cadastrar();

    // Exibe o resultado da operação
    if ($resultado['sucesso']) {
        echo "<h3 style='color: green;'>{$resultado['mensagem']}</h3>";
        echo "<p><strong>CRM:</strong> " . htmlspecialchars($medico->getCrm()) . 
             " | <strong>Nome:</strong> " . htmlspecialchars($medico->getNome()) . 
             " | <strong>Especialidade:</strong> " . htmlspecialchars($medico->getEspecialidade()) . "</p>";
    } else {
        echo "<h3 style='color: red;'>{$resultado['mensagem']}</h3>";
    }

} else {
    echo "<h3 style='color: red;'>Acesso inválido ao script.</h3>";
}
?>

<br><br>
<a href="cadastrar_medico.html">&larr; Cadastrar Outro Médico</a> | 
<a href="index.html">Voltar ao Menu Principal</a>