<?php
namespace Teach\Entities;

class Factory
{
    
    /**
     * 
     * @var \PDO
     */
    private $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function query($sql)
    {
        return $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}