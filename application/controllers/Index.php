<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$this->load->model('MNews');
		//
	}

	public function index()
	{
		$data['nhandinh'] = $this->MNews->getByTopicIdLimit('1', true, 5);
		$data['tip'] = $this->MNews->getByTopicIdLimit('2', true, 5);
		$data['tintuc'] = $this->MNews->getByTopicIdLimit('3', true, 5);
		$data['titlePage'] = 'Thể thao 24 - Tin bóng đá - Nhận định bóng đá';
		$data['loadPage'] = 'frontend/home/home_view';
        $this->load->view('frontend/frontend_layout_view', $data);
	}

}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */
 ?>