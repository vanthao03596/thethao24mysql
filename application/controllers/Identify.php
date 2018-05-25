<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Identify extends CI_Controller {

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

		$data['list_news'] = $this->MNews->getByTopicIdLimit('5b04d6426f9404e00400002a', true, 2);
		$data['titlePage'] = 'Nhận định bóng đá 24h';
		$data['loadPage'] = 'frontend/identify/identify_view';
        $this->load->view('frontend/frontend_layout_view', $data);
	}

	public function getNewsAjax()
	{
		$limit = 2;
		$skip = $this->input->get('skip') * $limit;
		$data['list_news'] = $this->MNews->getNewsBySkip($skip, true, $limit);
		$this->load->view('ajax/front_news/indentify_ajax_view', $data);
	}

}

/* End of file Identify.php */
/* Location: ./application/controllers/Identify.php */
 ?>