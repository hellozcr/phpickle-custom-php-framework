<?php
namespace App\Models;

use Core\Model;

class User extends Model {
    protected $table = 'users';

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->fetchAll($sql);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->fetch($sql, [$id]);
    }
} 