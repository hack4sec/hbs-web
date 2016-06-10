<?php

class SettingsController extends Zend_Controller_Action
{
    public function indexAction() {
        $this->view->settings = Utils::getSettings();
    }
    public function phpinfoAction() {
        phpinfo();
        exit;
    }
}