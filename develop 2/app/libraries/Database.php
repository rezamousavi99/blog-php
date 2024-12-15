<?php
class Database extends PDO
{
    private $DB_TYPE = "mysql";
    private $DB_HOST = DB_HOST;
    private $DB_NAME = DB_NAME;
    private $DB_USER = DB_USER;
    private $DB_PASS = DB_PASS;

    public function __construct()
    {
        parent::__construct($this->DB_TYPE.':host='.$this->DB_HOST.';dbname='.$this->DB_NAME, $this->DB_USER, $this->DB_PASS);
    }

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        if(!$sth->execute()){
            $this->handleError();
        }
        else{
            return $sth->fetchAll($fetchMode);
        }
    }

    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        if(!$sth->execute()){
            $this->handleError();
            //print_r($sth->errorInfo());
        }
    }

    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = NULL;
        foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }

    public function delete($table, $where, $limit = 1)
    {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

    public function delete_allrows($table, $where)
    {
        return $this->exec("DELETE FROM $table WHERE $where");
    }

    /* count rows*/
    public function rowsCount($table){
        $sth = $this->prepare("SELECT * FROM ".$table);
        $sth->execute();
        return $sth -> rowCount();
    }

    //error check
    private function handleError()
    {
        if ($this->errorCode() != '00000')
        {
            if ($this->_errorLog == true)
                //Log::write($this->_errorLog, "Error: " . implode(',', $this->errorInfo()));
                echo json_encode($this->errorInfo());
            throw new Exception("Error: " . implode(',', $this->errorInfo()));
        }
    }

}



  /*
   * PDO Database Class
   * Connect to database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */
//  class Database {
//    private $host = DB_HOST;
//    private $user = DB_USER;
//    private $pass = DB_PASS;
//    private $dbname = DB_NAME;
//
//    private $dbh;
//    private $stmt;
//    private $error;
//
//    public function __construct(){
//      // Set DSN
//      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
//      $options = array(
//        PDO::ATTR_PERSISTENT => true,
//        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
//      );
//
//      // Create PDO instance
//      try{
//        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
//      } catch(PDOException $e){
//        $this->error = $e->getMessage();
//        echo $this->error;
//      }
//    }
//
//    // Prepare statement with query
//    public function query($sql){
//      $this->stmt = $this->dbh->prepare($sql);
//    }
//
//    // Bind values
//    public function bind($param, $value, $type = null){
//      if(is_null($type)){
//        switch(true){
//          case is_int($value):
//            $type = PDO::PARAM_INT;
//            break;
//          case is_bool($value):
//            $type = PDO::PARAM_BOOL;
//            break;
//          case is_null($value):
//            $type = PDO::PARAM_NULL;
//            break;
//          default:
//            $type = PDO::PARAM_STR;
//        }
//      }
//
//      $this->stmt->bindValue($param, $value, $type);
//    }
//
//    // Execute the prepared statement
//    public function execute(){
//      return $this->stmt->execute();
//    }
//
//    // Get result set as array of objects
//    public function resultSet(){
//      $this->execute();
//      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
//    }
//
//    // Get single record as object
//    public function single(){
//      $this->execute();
//      return $this->stmt->fetch(PDO::FETCH_OBJ);
//    }
//
//    // Get row count
//    public function rowCount(){
//      return $this->stmt->rowCount();
//    }
//  }