<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends MY_BackendController {
	public function __construct(){
		parent::__construct();
		$this->unit = '權限';
		$this->abrv = 'backend_menu_permission_';
		$this->load->model('Permissions_model', 'models');
		$this->load->model('SidebarMenu_model');

		// haveField 為必填欄位，saveField 為所有要儲存的欄位
		$this->saveField = array(
			$this->abrv.'name' => array('dataType'=>'string', 'name'=>'標題'),
			$this->abrv.'lists'=> array('dataType'=>'array', 'name'=>'權限'),
			$this->abrv.'id'=> array('dataType'=>'integer', 'name'=>'流水號'),
		);
		$this->haveField = array($this->abrv.'name', 'backend_menu_permission');
		$this->sidebarPermissionType = $this->config->item('sidebarPermissionType');
	}


	public function index(){
		$data = [];
		$data['head']['includeCss'] = 'datatables';
		$data['head']['title'] = $this->unit;
		$data['sidebar']['active'] = $this->controllerName;
		$data['abrv'] = $this->abrv;
		$data['unit'] = $this->unit;

		// 搜尋
		$queryData['keyword'] = trim($this->input->get('keyword', true));
		$data['queryData'] = $queryData;

		// 分頁
		$httpGetParams = $this->combineGetParams($queryData);
		$pageConfig = $this->getPageConfig();
		$pageConfig['base_url'] = __FUNCTION__.'?'.$httpGetParams;
		$pageConfig['total_rows'] = $this->models->getList($queryData, []);
		$this->pagination->initialize($pageConfig);

		// 取資料
		$data['result'] = $this->models->getList($queryData, array($pageConfig['per_page'], $this->getCurrentPageOffset($pageConfig['per_page'], $pageConfig['total_rows'])));

		$data['httpGetParams'] = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : '';
		$this->showView($this->controllerName.'/index', $data);
	}

	public function create(){
		$op = $this->input->post('op', true);
		if( $op === 'add' ){

			$HTTP_REFERER = $this->input->post('HTTP_REFERER', true);

			// 儲存資料組成&檢查必填欄位
			$addData = $this->postFieldChekck($this->saveField, $this->haveField);
			$addData[$this->abrv.'lists'] = ','.implode($addData[$this->abrv.'lists'], ',').',';
			$status = $this->models->addData($addData);

			if($status){
				$alerts[$this->config->item('alertSuccess')] = $this->config->item('alertAddSuccess');
				$this->showAlerts($alerts);
				redirect($HTTP_REFERER);
			}else{
				$alerts[$this->config->item('alertWarning')] = $this->config->item('alertDBError');
				$this->showAlerts($alerts);
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$sidebarMenu = [];
		$sidebarList = $this->SidebarMenu_model->getList();
		foreach ($sidebarList as $key => $value) {
			$firstField = 0;
			$secondField = 0;
			if($value['backend_menu_parent_id']==0){
				$firstField = $value['backend_menu_id'];
				$sidebarMenu[$firstField]['mainMenus'] = $value;
			}else{
				$firstField = $value['backend_menu_parent_id'];
				$secondField = $value['backend_menu_id'];
				$sidebarMenu[$firstField]['subMenus'][$secondField] = $value;
			}
		}
		//print_r($sidebarMenu);exit;
		$data = [];
		$data['sidebarList'] = $sidebarMenu;
		$data['sidebarPermissionType'] = $this->sidebarPermissionType;
		$data['head']['title'] = $this->unit;
		$data['sidebar']['active'] = $this->controllerName;
		$data['unit'] = $this->unit;
		$data['abrv'] = $this->abrv;
		$data['unit'] = $this->unit;
		$data['httpGetParams'] = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : '';
		$this->showView($this->controllerName.'/'.__FUNCTION__, $data);
	}

	public function edit($id){

		// 資料檢查
		$data = [];
		$data['result'] = $this->models->getData($id);
		if($id =='' || !isset($data['result'])){
			$alerts[$this->config->item('alertDanger')] = '查無此資料，請重新進入編輯頁面';
			$this->showAlerts($alerts);
			redirect('/'.$this->controllerName.'/');
		}

		$op = $this->input->post('op', true);
		if( $op === 'upd' ){
			$HTTP_REFERER = $this->input->post('HTTP_REFERER', true);
			$dataList = $this->input->post(null, true);

			$saveField = $this->saveField;
			$haveField = $this->haveField;
			$haveField[] = $this->abrv.'id';
			$dataList[$this->abrv.'id'] = $data['result'][$this->abrv.'id'];

			// 儲存資料組成&檢查必填欄位
			$updateData = $this->postFieldChekck($saveField, $haveField, $dataList);
			$updateData[$this->abrv.'lists'] = ','.implode($updateData[$this->abrv.'lists'], ',').',';
			$status = $this->models->updateData($updateData);

			if($status){
				$alerts[$this->config->item('alertSuccess')] = $this->config->item('alertUpdateSuccess');
				$this->showAlerts($alerts);
				redirect($HTTP_REFERER);
			}else{
				$alerts[$this->config->item('alertWarning')] = $this->config->item('alertDBError');
				$this->showAlerts($alerts);
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$sidebarMenu = [];
		$sidebarList = $this->SidebarMenu_model->getList();
		foreach ($sidebarList as $key => $value) {
			$firstField = 0;
			$secondField = 0;
			if($value['backend_menu_parent_id']==0){
				$firstField = $value['backend_menu_id'];
				$sidebarMenu[$firstField]['mainMenus'] = $value;
			}else{
				$firstField = $value['backend_menu_parent_id'];
				$secondField = $value['backend_menu_id'];
				$sidebarMenu[$firstField]['subMenus'][$secondField] = $value;
			}
		}

		$data['sidebarList'] = $sidebarMenu;
		$data['sidebarPermissionType'] = $this->sidebarPermissionType;
		$data['head']['title'] = $this->unit;
		$data['sidebar']['active'] = $this->controllerName;
		$data['unit'] = $this->unit;
		$data['abrv'] = $this->abrv;
		$data['httpGetParams'] = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : '';
		$this->showView($this->controllerName.'/'.__FUNCTION__, $data);
	}

	public function deleteAction(){
		$op = $this->input->post('op', true);
		if( $op === 'del' ){
			$deleteData[$this->abrv.'id'] = trim($this->input->post('id', true));
			$HTTP_REFERER = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : '';
			$this->models->deleteData($deleteData);

			$alerts[$this->config->item('alertSuccess')] = $this->config->item('alertDeleteSuccess');
			$this->showAlerts($alerts);
			redirect($HTTP_REFERER);
		}
	}
}