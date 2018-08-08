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
         public function getProjects($id){
             if ($id == false){
                 return $this->database->query("SELECT * FROM projects");
             } else {          
                $project=[];
                
                $req = $this->database->query("SELECT * FROM projects");
                $favReq = $this->database->query("SELECT project_id FROM `fav` JOIN projects p ON p.id = fav.project_id WHERE fav.user_id = ?", $id);
                
                
                foreach ($req as $row) {
                    foreach ($favReq as $row2) {
                            $isFav = FALSE;
                            if ($row2->project_id == $row->id){
                                $isFav = TRUE;
                            }
                            $project[]=[
                            'id' => $row->id,
                            'name' => $row->name,
                            'date' => $row->date,
                            'type' => $row->type,
                            'is_web' => $row->is_web,
                            'isFavourite' => $isFav
                            ];
                        } 
                    }
               /* foreach ($favReq as $row) {
                    for ($i=0; $i<count($project); $i++)
                        if ($row->project_id == $project[$i]['id']){
                            $project[$row->project_id]["isFavourite"] = TRUE;
                        }
                    }  */
                    return $project;
                }
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
