<?php

namespace App\Presenters;

use Nette;

class HomepagePresenter extends Nette\Application\UI\Presenter
{
                private $baseModel;
                
                public function __construct(\App\Model\BaseModel $basemodel) {
                    $this->baseModel = $basemodel;
                }
    
                public function renderDefault()
                {
                    $this->template->projects = $this->baseModel->getProjects();
                }
                
                public function actionDelete($id){
                    $this->baseModel->deleteProject($id);
                    $this->redirect('Homepage:default');
                }
                
                public function renderEdit($id){
                    if ($this->baseModel->checkIfValid($id)) {
                     $this->error('Stránka nebyla nalezena');  
                    }
                }
                
                public function renderCreate($id){
                }
                
                public function createComponentEditProject(){
                    $form = new Nette\Application\UI\Form;
                    $id = $this->getParameter('id');
                    
                    $projects = $this->baseModel->getProject($id); 
                    foreach ($projects as $project) {
                        $form->addText("name","Název projektu")
                             ->setRequired()
                             ->setDefaultValue($project->name);
                        $form->addText("date","Datum odevzdání projektu")
                                 ->setHtmlType("date")
                                 ->setRequired()
                                 ->setDefaultValue($project->date);
                        $form->addSelect('type', 'Typ',[
                                'Časově omezený projekt' => 'Časově omezený projekt',
                                'Continuous Integration' => 'Continuous Integration', 
                        ])->setDefaultValue($project->type);
                        if ($project->is_web== "1"){
                            $form->addCheckbox('is_web', 'Webový projekt')->setDefaultValue("1");
                        } else {
                            $form->addCheckbox('is_web', 'Webový projekt');
                        }                    
                        $form->addSubmit('send', 'Upravit plán');
                        $form->onSuccess[] = [$this, 'EditProjectSuccess'];
                    }
                    return $form;
                }
                public function EditProjectSuccess(Nette\Application\UI\Form $form, $values) {
                    $id = $this->getParameter('id');
                    $this->baseModel->updateProject($values->name, $values->date, $values->type, $values->is_web, $id);
                    $this->redirect('Homepage:');
                }
                public function createComponentCreateProject(){
                        $form = new Nette\Application\UI\Form;
                    
                        $form->addText("name","Název projektu")
                             ->setRequired();
                        $form->addText("date","Datum odevzdání projektu")
                                 ->setHtmlType("date")
                                 ->setRequired();
                        $form->addSelect('type', 'Typ',[
                                'Časově omezený projekt' => 'Časově omezený projekt',
                                'Continuous Integration' => 'Continuous Integration', 
                        ]);
                        $form->addCheckbox('is_web', 'Webový projekt');         
                        $form->addSubmit('send', 'Vytvořit plán');
                        $form->onSuccess[] = [$this, 'CreateProjectSuccess'];
                        return $form;
                }
                public function CreateProjectSuccess(Nette\Application\UI\Form $form, $values) {
                    $this->baseModel->createProject($values->name, $values->date, $values->type, $values->is_web);
                    $this->redirect('Homepage:');
                }
                
}
