<?php
require_once "Database.php";

class Medico {
    private ?PDO $conn;
    
    // Atributos do Médico
    private string $crm;
    private string $nome;
    private string $especialidade;

    public function __construct(string $crm = "", string $nome = "", string $especialidade = "") {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        $this->crm = trim($crm);
        $this->nome = trim($nome);
        $this->especialidade = trim($especialidade);
    }

    // Getters e Setters
    public function getCrm(): string {
        return $this->crm;
    }

    public function setCrm(string $crm): void {
        $this->crm = trim($crm);
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = trim($nome);
    }

    public function getEspecialidade(): string {
        return $this->especialidade;
    }

    public function setEspecialidade(string $especialidade): void {
        $this->especialidade = trim($especialidade);
    }

    // Validação dos dados
    public function isValid(): bool {
        return !empty($this->crm) && !empty($this->nome) && !empty($this->especialidade);
    }

    // Método para cadastrar o médico no banco de dados
    public function cadastrar(): array {
        if (!$this->isValid()) {
            return [
                'sucesso' => false,
                'mensagem' => "Por favor, preencha todos os campos do formulário."
            ];
        }

        try {
            $query = "INSERT INTO Medicos (crm, nome, especialidade) VALUES (:crm, :nome, :especialidade)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":crm", $this->crm);
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":especialidade", $this->especialidade);

            if ($stmt->execute()) {
                return [
                    'sucesso' => true,
                    'mensagem' => "Médico cadastrado com sucesso!"
                ];
            }
        } catch (PDOException $e) {
            // Código 23000 em PDO costuma indicar erro de chave duplicada (CRM duplicado)
            if ($e->getCode() == '23000') {
                return [
                    'sucesso' => false,
                    'mensagem' => "Erro: O CRM '{$this->crm}' já está cadastrado no sistema."
                ];
            }
            return [
                'sucesso' => false,
                'mensagem' => "Erro ao cadastrar médico: " . $e->getMessage()
            ];
        }

        return [
            'sucesso' => false,
            'mensagem' => "Não foi possível concluir o cadastro."
        ];
    }
}
?>