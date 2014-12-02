<?php

class login {

    private $username;
    private $password;
    public $status;
    public $level;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = sha1($password);

        $tmp = db_function::checkLogin($this->username);
        $this->level = $tmp['zugriff'];
        
        
        if ($this->username == $tmp['user'] && $this->password == $tmp['pass'])
            $this->status = 1;
        else
            $this->status = 0;
    }

    public function checkLogin() {
        return $this->status == 1 ? true : false;
    }
    
    public function zugriff(){
        return $this->level;
    }

}

?>
