<?php

namespace Models;

use \Core\Model;

class Company extends Model
{
    private $company_info;

    public function __construct(int $company_id)
    {
        parent::__construct();

        $sql = 'SELECT id, name FROM companies WHERE id = :id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->company_info = $sql->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function getName(): string
    {
        return isset($this->company_info['name']) ? $this->company_info['name']: '';
    }
}
