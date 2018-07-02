<?php

namespace App\Model;

use Nette;

class BaseModel {
         use Nette\SmartObject;
    
         private $database;    
    
         public function __construct(Nette\Database\Context $database)
             {
               $this->database = $database;
             }
         public function getProjects(){
             return $this->database->query("SELECT * FROM projects");
         }
         public function getProject($id){             
             return $this->database->query("SELECT * FROM projects WHERE id = ?",$id);
         }
         public function deleteProject($id){
             $this->database->query("DELETE FROM projects WHERE id = ?",$id);
         }
         public function checkIfValid($id){
             //note: nejspíš uděláno moc složitě, ale funguje to...
             $ans = $this->database->query("SELECT COUNT(id) FROM projects WHERE id = ?",$id);
             foreach ($ans as $value) {
                 if ($value['0'] == 0){
                 return true;
                 }
                 return false;
             }
             
         }
         public function updateProject($name, $date, $type, $is_web, $id){
             $this->database->query("UPDATE `projects` SET `name` = ?, `date` = ?, `type` = ?, `is_Web` = ? WHERE id = ?;", $name, $date, $type, $is_web, $id);
         }
         public function createProject($name, $date, $type, $is_web){             
             return $this->database->query("INSERT INTO projects VALUES (NULL, ?, ?, ?, ?);",$name, $date, $type, $is_web);
         }
         
}
