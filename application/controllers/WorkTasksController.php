<?php

class WorkTasksController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->_model = new WorkTasks();
    }

    public function indexAction() {
        $this->view->workTasks = $this->_model->getStatusList();
        $this->view->hashlistsModel = new Hashlists();
        $this->view->filter_status = (isset($_COOKIE['filter_status']) and $_COOKIE['filter_status']) ?
            Zend_Json::decode($_COOKIE['filter_status']) :
            [];
        $this->view->filter_hashlist = (isset($_COOKIE['filter_hashlist']) and $_COOKIE['filter_hashlist']) ?
            $_COOKIE['filter_hashlist'] :
            "0";
    }
//TODO валидатор чтоб пустые листы задач не сабмитили
    public function addAction() {
        $form = new Forms_WorkTasks_Add();
        if ($this->_request->isPost() and $form->isValid($_POST)) {
            $this->_model->add($_POST);
            $this->redirect('/work-tasks/');
        } else {
            $this->view->form = $form;
        }
    }

    public function deleteAction() {
        $this->_model->get($this->_getParam('id'))->delete();
        $this->redirect('/work-tasks/');
    }

    public function stopAction() {
        $this->_model->get($this->_getParam('id'))->stop();
        $this->redirect('/work-tasks/');
    }

    public function resumeAction() {
        $this->_model->get($this->_getParam('id'))->resume();
        $this->redirect('/work-tasks/');
    }

    public function changeTaskPriorityAction() {
        $task = $this->_model->get($this->_getParam('id'));
        $task->priority = (int)$this->_getParam('priority');
        $task->save();
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function stdoutAction() {
        $workTask = $this->_model->get($this->_getParam('id'));

        /*$this->getResponse()
            ->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
            ->setHeader('Content-type', 'application/unknown;charset=utf-8', true)
            ->setHeader('Content-Disposition', "attachment; filename=stdout.txt")
            ->clearBody();
        $this->getResponse()->sendHeaders();

        readfile($workTask['path_stdout']);*/
        $this->view->stdout = file_get_contents($workTask['path_stdout']);
        $this->_helper->layout()->disableLayout();
    }

    public function errorsAction() {
        die(nl2br($this->_model->get($this->_getParam('id'))->err_output));
    }

    public function startAllAction() {
        $this->_model->startAll();
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function stopAllAction() {
        $this->_model->stopAll();
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function getCurrentWorkTaskIdAction() {
        print $this->_model->getCurrentWorkTaskId();
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function getJsonTaskDataAction() {
        print Zend_Json::encode($this->_model->get($this->_getParam('id')));
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function getJsonWorkTaskDataForListAction() {
        $t = Zend_Registry::get('Zend_Translate');
        $workTask = $this->_model->get($this->_getParam('id'));

        if ($workTask->getTime() != 'n/a') {
            $timeAll =  $workTask->getTime()['all'] . "/" . $workTask->getTime()['now']  . "/" . $workTask->getTime()['need'];
            $timeNeed = $workTask->getTime()['need'];
        } else {
            $timeAll = $timeNeed = 'n/a';
        }

        switch ($workTask->status) {
            case 'wait':
                $status = $t->translate("L_WAIT");
                break;
            case 'work':
                $status = $t->translate("L_IN_WORK");
                break;
            case 'go_stop':
                $status = $t->translate("L_STOPPING");
                break;
            case 'stop':
                $status = $t->translate("L_STOPED");
                break;
            case 'done':
                $status = $t->translate("L_DONE");
                break;
        }

        switch ($workTask->process_status) {
            case 'starting':
                $procStatus = $t->translate("L_START_HC");
                break;
            case 'work':
                $procStatus = $t->translate("L_IN_WORK");
                break;
            case 'compilehybride':
                $procStatus = $t->translate("L_DICT_COMPILE");
                break;
            case 'compilecommand':
                $procStatus = $t->translate("L_COMMAND_BUILD");
                break;
            case 'loadhashes':
                $procStatus = $t->translate("L_FOUND_HASHES_LOAD");
                break;
            case 'buildhashlist':
                $procStatus =  $t->translate("L_HASHLIST_COMPILE");
                break;
            case 'preparedicts':
                $procStatus = $t->translate("L_DICTS_PREPARE");
                break;
            default:
                $procStatus = '';
                break;
        }

        $data = [
            'status' => $status,
            'process' => $procStatus,
            'timeAll' => $timeAll,
            'timeNeed' => $timeNeed,
            'progress' => $workTask->getProgress(),
            'temp' => $workTask->hc_temp,
            'hc_rechash' => $workTask->getHcRechash()
        ];

        print Zend_Json::encode($data);

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
}
