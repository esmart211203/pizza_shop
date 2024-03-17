<?php
require_once('db.php');
class User{
    public $id;
    public $email;
    public $password;
    public $status;
    public $role;
    public function __construct($id, $email, $password, $status, $role){
        $this->id = $id;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->status = $status;
        $this->role = $role;
    }
}