<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	protected $_data;
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		//
	}

	public function index(){
		//$this->output->cache(1*24*60);
		//
		$this->_data['functionName'] = 'CMS';
		$this->_data['actionName'] = 'Trang chủ';
		$this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
		$this->_data['titlePage'] = $this->_data['actionName'];
		$this->_data['loadPage'] = 'backend/home/cms_home_view';
		$this->load->view('backend/admin_layout_view', $this->_data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */