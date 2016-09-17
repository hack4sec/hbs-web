<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
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

    public function hideAction() {
        $this->_model->get($this->_getParam('id'))->hide();
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

        $status = $t->translate('L_WT_STATUS_' . strtoupper($workTask->status));
        $procStatus = $t->translate('L_WT_PROCESS_STATUS_' . strtoupper($workTask->process_status));

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
