<?php
// use Medoo\Medoo;

class IndexController extends Yaf_Controller_Abstract {
	
	public function tryDisableView($forced=false) {
		if( $forced || $this->getRequest()->isXmlHttpRequest() ){
			Yaf_Dispatcher::getInstance()->disableView();
			Yaf_Dispatcher::getInstance()->autoRender(false);
		}
	}

	public function dbinitAction (){
		$this->tryDisableView(true);
		$conf = (new Yaf_Config_Ini('application'))->toArray();
		$database = $conf['develop']['mysql'];
		$db = new Medoo\Medoo($database);

	}

	public function indexAction() {
	    echo (1);
		// $db = new Medoo\Medoo(DBCONFIG::CONF);
		$config = Yaf_Application::app()->getConfig()->toArray();
		$db = new Medoo\Medoo($config['database']);
		$rows = $db->select("users", ["name", "role", "timestamp"]);
		// print_r( ['log'=>$db->log(), 'error'=>$db->error()] );

	    // print_r($config);
		$this->getView()->assign("content", "Hello World");
		$this->getView()->assign("rows", $rows);
	}

}
