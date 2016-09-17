<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class TasksController extends Zend_Controller_Action
{
    public function init() {
        parent::init();
        $this->_model = new Tasks;
    }

    public function addAction() {
        if (!$this->_getParam('type')) {
            $this->view->group_id = $this->_getParam('group_id');
        } else {
            switch ($this->_getParam('type')) {
                case 'dict':
                    $form = new Forms_Tasks_Add_Dict();
                    break;
                case 'mask':
                    $form = new Forms_Tasks_Add_Mask();
                    break;
                case 'maskdict':
                case 'dictmask':
                    $form = new Forms_Tasks_Add_Hybride();
                    break;
                default:
                    throw new Exception("Unknown form type '{$this->_getParam('type')}'");
            }
            $form->setType($this->_getParam('type'));
            $form->setGroupId($this->_getParam('group_id'));
            $form->name->getValidator('Forms_Validate_Tasks_Name')->setGroupId($this->_getParam('group_id'));
            if ($this->_request->isPost() and $form->isValid($_POST)) {
                $this->_model->add($_POST);
                $this->redirect('/tasks/');
            } else {
                $this->view->form = $form;
            }
            $this->view->group = (new Tasks_Groups())->get($this->_getParam('group_id'));
        }
    }

    public function editAction() {
        $task = $this->_model->get($this->_getParam('id'));
        switch ($task->type) {
            case 'dict':
                $form = new Forms_Tasks_Edit_Dict();
                break;
            case 'mask':
                $form = new Forms_Tasks_Edit_Mask();
                break;
            case 'maskdict':
            case 'dictmask':
                $form = new Forms_Tasks_Edit_Hybride();
                break;
            default:
                throw new Exception("Unknown form type '{$this->_getParam('type')}'");
        }

        $form->name->getValidator('Forms_Validate_Tasks_Name')->setGroupId($task->group_id);
        $form->name->getValidator('Forms_Validate_Tasks_Name')->setExcludeId($task->id);
        if ($this->_request->isPost() and $form->isValid($_POST)) {
            $this->_model->edit($_POST);
            $this->redirect('/tasks/');
        } else {
            $form->populate($task->toArray());
            $this->view->form = $form;
            $this->view->task = $task;
        }
    }

    public function addGroupAction() {
        $Groups = new Tasks_Groups();
        $form = new Forms_Tasks_Group_Add();
        if ($this->_request->isPost() and $form->isValid($_POST)) {
            $Groups->add($_POST);
            $this->redirect('/tasks/');
        } else {
            $this->view->form = $form;
        }
    }

    public function editGroupAction() {
        $form = new Forms_Tasks_Group_Edit();
        $Groups = new Tasks_Groups();
        if ($this->_request->isPost()) {
            $form->name->getValidator('Forms_Validate_Tasks_Group_Name')->setExcludeId($this->_getParam('id'));
            if ($form->isValid($_POST)) {
                $Groups->edit($_POST);
                $this->redirect('/tasks/');
            }
        } else {
            $group = $Groups->get($this->_getParam('id'));
            $form->populate($group->toArray());
        }
        $this->view->form = $form;
        $this->view->group = $group;
    }

    public function deleteGroupAction() {
        (new Tasks_Groups())->get($this->_getParam('id'))->delete();
        $this->redirect('/tasks/');
    }

    public function indexAction() {
        $this->view->groups = (new Tasks_Groups())->fetchAll(null, "name ASC");
        $this->view->rules = (new Rules())->getList();
    }

    public function deleteAction() {
        $this->_model->get($this->_getParam('id'))->delete();
        $this->redirect('/tasks/');
    }
}