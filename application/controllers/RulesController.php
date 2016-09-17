<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class RulesController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->_model = new Rules();
    }

    public function indexAction() {
        $this->view->list = $this->_model->fetchAll(null, "name ASC");
    }

    public function addAction() {
        $this->view->settings = Utils::getSettings();
        $form = new Forms_Rules_Add();
        if ($this->_request->isPost() and $form->isValid($_POST) and $form->file->receive()) {
            $_POST['filename'] = $form->file->getFileName(NULL, false);
            $this->_model->add($_POST);
            $this->redirect('/rules/');
            exit;
        } else {
            $this->view->form = $form;
        }
    }
    public function editAction() {
        $form = new Forms_Rules_Edit();
        $form->name->getValidator('Forms_Validate_Rules_Name')->setExcludeId($this->_getParam('id'));
        if ($this->_request->isPost() and $form->isValid($_POST)) {
            $this->_model->edit($_POST);
            $this->redirect('/rules/');
        } else {
            $form->populate($this->_model->get($this->_getParam('id'))->toArray());
            $this->view->form = $form;
            $this->view->rules = $this->_model->get($this->_getParam('id'));
        }
    }

    public function deleteAction() {
        $this->_model->get($this->_getParam('id'))->delete();
        $this->redirect('/rules/');
    }

    public function inAction() {
        $this->view->hashlist = $this->_model->get($this->_getParam('id'));
        $form = new Forms_Hashlists_In();
        $form->setId($this->_getParam('id'));
        $this->view->settings = Utils::getSettings();
        if ($this->_request->isPost() and $form->isValid($_POST) and $form->file->receive()) {
            $_POST['filename'] = $form->file->getFileName(NULL, false);
            $this->_model->in($_POST);
            $this->redirect('/hashlists/');
        } else {
            $this->view->form = $form;
        }
    }

    public function importAction() {
        $this->view->hashlist = $this->_model->get($this->_getParam('id'));
        $form = new Forms_Hashlists_Import();
        $form->setId($this->_getParam('id'));

        if ($this->_request->isPost() and $form->isValid($_POST)) {
            $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-type', 'application/unknown;charset=utf-8', true)
                ->setHeader('Content-Disposition', "attachment; filename=hashes-import.txt")
                ->clearBody();
            $this->getResponse()->sendHeaders();

            $stmt = $this->_model->import($this->_getParam('id'), $this->_getParam('founded'));
            while ($row = $stmt->fetch()) {
                $str = $row['hash'];
                if ($this->_getParam('salts')) {
                    $str .= $this->_getParam('delimiter') . $row['salt'];
                }
                if ($this->_getParam('founded')) {
                    $str .= $this->_getParam('delimiter') . $row['password'];
                }
                $str .= "\n";
                print $str;
            }
            exit;
        } else {
            $this->view->form = $form;
        }
    }

    public function errorsAction() {
        die(nl2br($this->_model->get($this->_getParam('id'))->errors));
    }
}