<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class LogsController extends Zend_Controller_Action
{
    /**
     * @var Logs
     */
    protected $_model;
    public function init()
    {
        parent::init();
        $this->_model = new Logs();
    }

    public function indexAction() {
        $select = $this->_model->select()->order('id DESC');
        if ($this->_getParam('moduleFilter')) {
            $select->where("module = ?", $this->_getParam('moduleFilter'));
        }
        $paginator = Zend_Paginator::factory($select);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(Zend_Registry::get('config')->logs->rows_per_page);
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        $view = Zend_View_Helper_PaginationControl::setDefaultViewPartial(
            'paginator.phtml'
        );
        $paginator->setView($view);
        $this->view->paginator = $paginator;

        $this->view->module = $this->_getParam('moduleFilter', '');
    }
}