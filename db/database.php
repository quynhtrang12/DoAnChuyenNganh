<?php
// define('__ROOT__',dirname(dirname(__FIRE__)));
// include(__ROOT__.'/conn.php');
require_once('config.php');
?>
<?php
Class Database{
    public $host = DB_HOST;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $dbname = DB_NAME;
    public $link;
    public $error;

public function __construct(){
    $this->connectDB();
}

private function connectDB(){
    $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
    if(!$this->link){
        $this->error="Connection fail".$this->link->connect_error;
        return false;
    }
}
// select
public function select($query){
    $result = $this->link->query($query) or
    die($this->link->error.__LINE__);
    if($result->num_rows >0){
        return $result;

    }else{
        return false;
    }
}

// Insert 

public function insert($query){
    $insert_row = $this->link->query($query) or
    die($this->link->error.__LINE__);
    if($insert_row){
        return $insert_row;
    }else{
        return false;
    }
}
// Update
public function update($query){
    mysqli_set_charset($this->link,'UTF8');
    $update_row = $this->link->query($query) or
    die($this->link->error.__LINE__);
    if($update_row){
        return $update_row;
    }else{
        return false;
    }
}
//delete 
public function delete($query){
    $delete_row = $this->link->query($query) or
    die($this->link->error.__LINE__);
    if($delete_row){
        return $delete_row;
    }else{
        return false;
    }
}
}
?>
