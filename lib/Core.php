<?php

namespace lib;

use PDO;
use lib\Config;

class Core {
    public $dbh; // handle of the db connexion
    private static $instance;
    private static $core;

    private function __construct() {
        // building data source name from config
        $dsn = 'mysql:host=' . Config::read('db.host') .
               ';dbname='    . Config::read('db.basename') .
               ';port='      . Config::read('db.port') .
               ';connect_timeout=15';
         
        $user = Config::read('db.user'); // getting DB user from config               
        $password = Config::read('db.password');  // getting DB password from config
        $this->dbh = new PDO($dsn, $user, $password);             
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    public static function processConsult($table, $fields, $Paramfilter = array()){
        $instance = Core::getInstance();
        $responseSQL = array();
        $filter = '';
        if(sizeof($Paramfilter) > 0)
            foreach ($Paramfilter as $key => $value) {
                $filter .= "WHERE  $key = :$key";
            }

        $sql = "SELECT $fields FROM $table $filter";
        $stmt = $instance->dbh->prepare($sql);
        if(sizeof($Paramfilter) > 0)
            foreach ($Paramfilter as $key => $value) {
                $stmt->bindParam(":$key", $value);
            }

        if ($stmt->execute())
            $responseSQL = $stmt->fetchAll(PDO::FETCH_ASSOC);   

        return $responseSQL;
    }

    public static function processInsert($table, $fieldsValue){
        $instance = Core::getInstance();
        $response = array();
        $fields = '';
        $values = '';
        foreach ($fieldsValue as $key => $val) {
            if($fields != '')
                $fields .= ", ";
            $fields .= $key;

            if($values != '')
                $values .= ", ";
            $values .= ":$key";
        }

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $stmt = $instance->dbh->prepare($sql);
        if ($stmt->execute($fieldsValue))
            $response = array('RESULT' => $instance->dbh->lastInsertId());
        
        return $response;
    }

    public static function processUpdate($table, $Paramfields, $Paramfilter){
        $instance = Core::getInstance();
        $response = array();
        $fields = '';
        $filter = '';

        //Recorro los campos, para asignarlo con variable bind
        foreach ($Paramfields as $key => $value) {
            if($fields != '')
                $fields .= ", ";
            $fields .= "$key=:$key";
        }

        //Recorro los filtros, para asignarlo a variable bind
        foreach ($Paramfilter as $key => $value) {
            if($filter != '')
                $filter .= ", ";
            $filter .= "$key=:$key";
            $Paramfields[$key] = $value;
        }

        $sql = "UPDATE $table SET $fields WHERE $filter";
        $stmt = $instance->dbh->prepare($sql);
        if ($stmt->execute($Paramfields))
            $response = array('ID' => '00', 'DESCRIPTION' => 'Solicitud procesada con éxito');

        return $response;
    }

    public static function processDelete($table, $Paramfilter){
        $instance = Core::getInstance();
        $response = array();
        $filter = '';
        foreach ($Paramfilter as $key => $value) {
            if($filter != '')
                $filter .= ", ";
            $filter .= "$key=:$key";
        }
        $sql = "DELETE FROM $table WHERE $filter";
        $stmt = $instance->dbh->prepare($sql);
        if ($stmt->execute($Paramfilter))
            $response = array('ID' => '00', 'DESCRIPTION' => 'Solicitud procesada con éxito');
       
        return $response;
    }



    /*ERRORES:
        00 : EXITOSO.
        01 : ERROR VALIDO
        02 : OTRO ERROR - SACA DEL SISTEMA
        03 : EXCEPCION TIPO TOKEN
    */
}