<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{
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
		$data['titlePage'] = 'Tin tức bóng đá 24h';
		$data['loadPage'] = 'frontend/news/news_view';
		$this->load->view('frontend/frontend_layout_view', $data);
	}

	public function getNewTopic()
	{
		$url =  $this->uri->segment(1);
		switch ($url) {
			case 'nhan-dinh-bong-da.html':
				$data['list_news'] = $this->MNews->getByTopicIdLimit('1', true, 10);
				$data['titlePage'] = 'Nhận định bóng đá 24h';
				$data['topic_id'] = 1;
				break;
			case 'tin-tuc-bong-da.html':
				$data['list_news'] = $this->MNews->getByTopicIdLimit('3', true, 10);
				$data['titlePage'] = 'Tin tức bóng đá';
				$data['topic_id'] = 3;
				break;
			case 'tip.html':
				$data['list_news'] = $this->MNews->getByTopicIdLimit('2', true, 10);
				$data['titlePage'] = 'Tip';
				$data['topic_id'] = 2;
				break;
			default:
				break;
		}

		$data['loadPage'] = 'frontend/news/news_view';
		$this->load->view('frontend/frontend_layout_view', $data);
	}
	public function getNewsAjax()
	{
		$limit = 10;
		$topic = $this->input->get('topic');
		$skip = $this->input->get('skip') * $limit;
		$data['list_news'] = $this->MNews->getNewsBySkip($topic, $skip, true, $limit);
		$this->load->view('ajax/front_news/news_ajax_view', $data);
	}

	public function searchAjax()
	{
		$limit = 10;
		$skip = $this->input->get('skip') * $limit;
		$keyword = $this->input->get('keyword');
		$data['list_news']  = $this->MNews->getByTitle($keyword, $skip, true, $limit);
		$this->load->view('ajax/front_news/news_ajax_view', $data);
	}
	public function search()
	{
		$keyword = $this->input->post('keyword');
		$data['list_news'] = $this->MNews->getByTitle($keyword, 0, true, 10);
		$data['titlePage'] = 'Kết quả tìm kiếm cho: ' . $keyword ;
		$data['loadPage'] = 'frontend/news/search_news_view';
		$data['keyword'] = $keyword;
		$this->load->view('frontend/frontend_layout_view', $data);
	}

	public function content() {
		$segment = $this->uri->segment(1);
		$explode = explode( '.', $segment);
		$slug =  $explode[0];
		$new = $this->MNews->getBySlug($slug);
		$id = '';
		$news_related = array();
		$titlePage = 'Không tìm thấy';
		if(!empty($new))
		{
			$id = $new[0]['_id'];
			$news_related = $this->MNews->getByTopicId($new[0]['topic_id'], $id);
			$titlePage = $new[0]['title'];
		}
		$data['new'] = $new;
		$data['news_related'] = $news_related;
		$data['titlePage'] = $titlePage;
		$data['loadPage'] = 'frontend/news/content_news_view';
		$this->load->view('frontend/frontend_layout_view', $data);
	}
}

/* End of file News.php */
/* Location: ./application/controllers/News.php */
