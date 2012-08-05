<?php

class BugController extends Zend_Controller_Action
{
	public function init()
	{
		
	}
	public function indexAction()
	{
		
	}
	public function listAction()
	{
		// set the default values to null
		$sort = null;
		$filter = null;
		$filterField = null;
		$filterValue = null;
		// get the filter form
		$listToolsForm = new Application_Form_BugReportListToolsForm();

		// if the request is postback and is valid then sort and filter
		$request = $this->getRequest();		
		if($request->isPost())
		{
			$formData = $request->getPost();
			if($listToolsForm->isValid($formData))
			{
				$values = $listToolsForm->getValues();
				$filterValue = $values ['filter'];
				$filterField = $values ['filter_field'] ? $values ['filter_field'] : null;
				$sortValue = $values ['sort'];
				if($sortValue != '0'){
					$sort = $sortValue;
				}
				if($filterField != '0'){
					$filter[$filterField] = $filterValue;
				} else {
					$filter = null;
				}
			}
		}
		// fetch the current bugs
		$bugModel = new Application_Model_Bugs();		
		$bugs_res = $bugModel->fetchBugs($filter, $sort);

		$listToolsForm->setAction('');
		$listToolsForm->filter->setValue($filterValue);
		$listToolsForm->filter_field->setValue($filterField);
		$listToolsForm->setMethod('post');
		$this->view->listToolsForm = $listToolsForm;
		
		// set the paginator object
		
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($bugs_res));
		$paginator->setItemCountPerPage(10)
				->setCurrentPageNumber($request->getParam('page', 1));
		$this->view->bugs = $paginator;
	}
	public function confirmAction()
	{
		
	}
	public function submitAction()
	{
		$bugReportForm = new Application_Form_BugReportForm();
		if($this->getRequest()->isPost())
		{
			if($bugReportForm->isValid($_POST))
			{
				$bugModel = new Application_Model_Bugs();
				// if the form is valid
				$result = $bugModel->createBug($bugReportForm->getValue('author'), 
						$bugReportForm->getValue('email'),
						$bugReportForm->getValue('date'),
						$bugReportForm->getValue('url'),
						$bugReportForm->getValue('description'),
						$bugReportForm->getValue('priority'),
						$bugReportForm->getValue('status') );
				// if the createBug method returns a result
				// then the bug was successfully created
				if($result){
					$this->_forward('confirm');
				}
			}
		}
		
		$this->view->form = $bugReportForm;
	}
}