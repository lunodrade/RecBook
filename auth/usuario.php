<?php

class Usuario {
    private $id = null;
    private $email = null;
    private $senha = null;
    private $tipo = null;
    private $nome = null;
    private $sexo = null;
    private $idade = null;
    
    public function getId() {
        return $this->id;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getSenha() {
        return $this->senha;
    }
    
    public function getTipo() {
        return $this->tipo;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function getSexo() {
        return $this->sexo;
    }
    
    public function getIdade() {
        return $this->idade;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setSenha($senha) {
        $this->senha = $senha;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }
    
    public function setIdade($idade) {
        $this->idade = $idade;
    }
}

