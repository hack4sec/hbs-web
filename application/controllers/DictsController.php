<?php

class DictsController extends Zend_Controller_Action
{
    public function init() {
        parent::init();
        $this->_model = new Dicts();
    }

    public function addAction() {
        $this->view->settings = Utils::getSettings();
        $form = new Forms_Dicts_Add();
        $form->setGroupId($this->_getParam('group_id'));
        $this->view->group = (new Dicts_Groups())->get($this->_getParam('group_id'));
        $form->name->getValidator('Forms_Validate_Dicts_Name')->setGroupId($this->_getParam('group_id'));
        if ($this->_request->isPost() and $form->isValid($_POST) and $form->file->receive()) {
            $_POST['filename'] = $form->file->getFileName(NULL, false);
            $this->_model->add($_POST);
            $this->redirect('/dicts/');
        } else {
            $this->view->form = $form;
        }
    }

    public function editAction() {
        $form = new Forms_Dicts_Edit();
        $this->view->dict = $dict = $this->_model->get($this->_getParam('id'));
        $this->view->settings = Utils::getSettings();
        $form->setGroupId($dict->group_id);
        $form->name->getValidator('Forms_Validate_Dicts_Name')->setGroupId($dict->group_id);
        $form->name->getValidator('Forms_Validate_Dicts_Name')->setExcludeId($dict->id);
        if ($this->_request->isPost() and $form->isValid($_POST)) {
            $this->_model->edit($_POST);
            $this->redirect('/dicts/');
        } else {
            $form->populate($dict->toArray());
            $this->view->form = $form;
        }
    }

    public function addGroupAction() {
        $Groups = new Dicts_Groups();
        $form = new Forms_Dicts_Group_Add();
        if ($this->_request->isPost() and $form->isValid($_POST)) {
            $Groups->add($_POST);
            $this->redirect('/dicts/');
        } else {
            $this->view->form = $form;
        }
    }

    public function editGroupAction() {
        $form = new Forms_Dicts_Group_Edit();
        $Groups = new Dicts_Groups();
        if ($this->_request->isPost()) {
            $form->name->getValidator('Forms_Validate_Dicts_Group_Name')->setExcludeId($this->_getParam('id'));
            if ($form->isValid($_POST)) {
                $Groups->edit($_POST);
                $this->redirect('/dicts/');
            }
        } else {
            $group = $Groups->get($this->_getParam('id'));
            $form->populate($group->toArray());
        }
        $this->view->form = $form;
        $this->view->group = $group;
    }

    public function deleteGroupAction() {
        (new Dicts_Groups())->get($this->_getParam('id'))->delete();
        $this->redirect('/dicts/');
    }

    public function deleteAction() {
        $this->_model->get($this->_getParam('id'))->delete();
        $this->redirect('/dicts/');
    }

    public function indexAction() {
        $this->view->groups = (new Dicts_Groups())->fetchAll(null, "name ASC");
    }
}