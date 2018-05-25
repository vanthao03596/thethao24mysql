<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$this->load->model('MNews');
		$this->load->model('MNewsTopic');
        $this->load->model('MAdmin');
	}

	public function index()
	{

	}

	public function listNewsTopic() {
		//
        $this->_data['functionName'] = 'Tin tức';
        $this->_data['actionName'] = 'Chủ đề tin tức';
        $this->_data['breadCrumb'] = '/ ' . $this->_data['functionName'] . ' / ' . $this->_data['actionName'];
        $this->_data['titlePage'] = $this->_data['actionName'];
        $this->_data['loadPage'] = 'backend/news/list_news_topic_view';
        $this->load->view('backend/admin_layout_view', $this->_data);
	}

	public function listNewsTopicAjax() {
		$data = array();
        $filterByName = $this->input->post('filterByName');
        $pageId = $this->input->post('pageId');
        //
        $pageId = ($pageId == 0) ? 1 : $pageId;
        $limit = 10;
        $offset = ($pageId - 1) * $limit;
        $data['offset'] = ($pageId - 1) * $limit;
        $totalRecord = $this->MNewsTopic->countAll($filterByName);
        $data['pagination'] = MyHelper::genPaginationLink($totalRecord, $limit, $pageId);
        $data['listNewsTopic'] = $this->MNewsTopic->adminGetPagination($filterByName, $limit, $offset);
        //
       $data['listAdminName'] = $this->MAdmin->getListUsernameAndId();
        //
        $this->load->view('ajax/cms_news/list_news_topic_view', $data);
	}

    public function addNewsTopic()
    {
        if (!$this->session->userdata('admin_id')) {
            redirect(base_url() . 'index.php/backend/account/login');
        }
        // Thiết lập validate
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Tên chủ đề',
                'rules' => 'trim|required|min_length[2]|max_length[255]'
            ),
            array(
                'field' => 'image_path',
                'label' => 'Ảnh đại diện',
                'rules' => 'trim|required|min_length[2]|max_length[255]'
            )
        );

        $this->form_validation->set_message('is_unique', '<li>' . 'Tên đã tồn tại!' . '</li>');
        $this->form_validation->set_message('required', '<li>' . 'Bạn chưa nhập' . ' %s!</li>');
        $this->form_validation->set_message('min_length', '<li>%s ' . 'tối thiểu 6 ký tự' . '!</li>');
        $this->form_validation->set_message('max_length', '<li>%s ' . 'tối đa 255 ký tự' . '!</li>');

        $this->form_validation->set_rules($config);

        // Xu ly form login
        if ($this->form_validation->run() == FALSE) {
            $this->_data['name'] = $this->input->post('name');
            $this->_data['image_path'] = $this->input->post('image_path');
            $this->_data['is_active'] = $this->input->post('is_active');
            $this->_data['type'] = $this->input->post('type');
            //
            $this->_data['listTopicType'] = MyHelper::getNewTopicType();
            //
            $this->_data['functionName'] = 'Tin tức';
            $this->_data['actionName'] = 'Thêm mới tin tức';
            $this->_data['breadCrumb'] = '/ ' . $this->_data['functionName'] . ' / ' . $this->_data['actionName'];
            $this->_data['titlePage'] = $this->_data['actionName'];
            $this->_data['loadPage'] = 'backend/news/add_news_topic_view';
            $this->load->view('backend/admin_layout_view', $this->_data);
        } else {
            $name = trim($this->input->post('name'));
            $image_path = trim($this->input->post('image_path'));
            $is_active = ($this->input->post('is_active') == 'on') ? 1 : 0;
            $type = $this->input->post('type');
            $data_insert = array(
                'name' => $name,
                'image_path' => str_replace(base_url(), '', $image_path),
                'is_active' => $is_active,
                'news' => null,
                'type' => $type,
                'created_by' => $this->session->userdata('admin_id'),
                'location' => null,
                'language' => 'en',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->MNewsTopic->add($data_insert);

            //Ghi log action ADDED
            //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

            // Chuyen trang admin
            $this->session->set_flashdata('success', 'Thêm mới thành công!');
            redirect(base_url() . 'index.php/backend/news/listNewsTopic');
        }
    }

	public function editNewsTopic($news_topic_id)
    {
        if (!$this->session->userdata('admin_id')) {
            redirect(base_url() . 'index.php/backend/account/login');
        }
        $this->_data['news_topic'] = $news_topic = $this->MNewsTopic->getById($news_topic_id);
        // Thiết lập validate
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Tên chủ đề',
                'rules' => 'trim|required|min_length[2]|max_length[255]'
            ),
            array(
                'field' => 'image_path',
                'label' => 'Ảnh đại diện',
                'rules' => 'trim|required|min_length[2]|max_length[255]'
            )
        );

        $this->form_validation->set_message('is_unique', '<li>' . 'Tên đã tồn tại!' . '</li>');
        $this->form_validation->set_message('required', '<li>' . 'Bạn chưa nhập' . ' %s!</li>');
        $this->form_validation->set_message('min_length', '<li>%s ' . 'tối thiểu 6 ký tự' . '!</li>');
        $this->form_validation->set_message('max_length', '<li>%s ' . 'tối đa 255 ký tự'. '!</li>');

        $this->form_validation->set_rules($config);

        // Xu ly form login
        if ($this->form_validation->run() == FALSE) {
            $this->_data['name'] = $this->input->post('name');
            $this->_data['image_path'] = $this->input->post('image_path');
            $this->_data['is_active'] = $this->input->post('is_active');
            $this->_data['type'] = $this->input->post('type');
            //
            $this->_data['listTopicType'] = MyHelper::getNewTopicType();
            //
            $this->_data['functionName'] = 'Tin tức';
            $this->_data['actionName'] = 'Cập nhật Chủ đề tin tức';
            $this->_data['breadCrumb'] = '/ ' . $this->_data['functionName'] . ' / ' . $this->_data['actionName'];
            $this->_data['titlePage'] = $this->_data['actionName'];
            $this->_data['loadPage'] = 'backend/news/edit_news_topic_view';
            $this->load->view('backend/admin_layout_view', $this->_data);
        } else {
            $name = trim($this->input->post('name'));
            $image_path = trim($this->input->post('image_path'));
            $is_active = ($this->input->post('is_active') == 'on') ? 1 : 0;
            $data_update = array(
                'name' => $name,
                'image_path' => str_replace(base_url(), '', $image_path),
                'is_active' => $is_active,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->MNewsTopic->update($news_topic_id, $data_update);

            //Ghi log action ADDED
            //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

            // Chuyen trang admin
            $this->session->set_flashdata('success', 'Cập nhật thành công!');
            redirect(base_url() . 'index.php/backend/news/listNewsTopic');
        }
    }

	public function deleteNewsTopic($news_topic_id)
    {
        $news_topic = $this->MNewsTopic->getById($news_topic_id);
        $this->MNewsTopic->delete($news_topic_id);

        //Ghi log action DELETED
        //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

        $this->session->set_flashdata('success', 'Xóa thành công!');
        // Chuyen trang admin
        redirect(base_url() . 'index.php/backend/news/listNewsTopic');
    }

	public function changeIsActiveNewsTopic($is_active, $news_topic_id)
    {
        if (in_array($is_active, array(0, 1))) {
            $data_update = array(
                'is_active' => (int)$is_active,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->MNewsTopic->update($news_topic_id, $data_update);

            //Ghi log action CHANGED_IS_ACTIVE
            //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

            $this->session->set_flashdata('success', 'Thay đổi trạng thái thành công!');
        } else {
            $this->session->set_flashdata('notice', 'Thay đổi trạng thái không thành công!');
        }
        // Chuyen trang admin
        redirect(base_url() . 'index.php/backend/news/listNewsTopic');
    }

	public function listNews() {
		$this->_data['listNewsTopic'] = $this->MNewsTopic->getListForSelectBox(true);
        $this->_data['listNewsType'] = MyHelper::getNewsEventType();
        //
        $this->_data['functionName'] = 'Tin tức';
        $this->_data['actionName'] = 'Danh sách tin tức';
        $this->_data['breadCrumb'] = '/ ' . $this->_data['functionName'] . ' / ' . $this->_data['actionName'];
        $this->_data['titlePage'] = $this->_data['actionName'];
        $this->_data['loadPage'] = 'backend/news/list_news_view';
        $this->load->view('backend/admin_layout_view', $this->_data);
	}

	public function listNewsAjax()
    {
        //
        $data = array();
        $filterByTopic = $this->input->post('filterByTopic');
        $filterByType = $this->input->post('filterByType');
        $filterByName = $this->input->post('filterByName');
        $pageId = $this->input->post('pageId');
        //
        $pageId = ($pageId == 0) ? 1 : $pageId;
        $limit = 20;
        $offset = ($pageId - 1) * $limit;
        $data['offset'] = ($pageId - 1) * $limit;
        $totalRecord = $this->MNews->adminCountAll($filterByTopic, $filterByName, $filterByType);
        $data['pagination'] = MyHelper::genPaginationLink($totalRecord, $limit, $pageId);
        $data['listGift'] = $this->MNews->adminGetPagination($filterByTopic, $filterByName, $filterByType, $limit, $offset);
        //
        $data['listAdminName'] = $this->MAdmin->getListUsernameAndId(true);
        $data['listNewsTopicName'] = $this->MNewsTopic->getListItemNameAndId(true);
        //
        $this->load->view('ajax/cms_news/list_news_view', $data);
    }

	public function addNews()
    {
        if (!$this->session->userdata('admin_id')) {
            redirect(base_url() . 'index.php/backend/account/login');
        }

        // Thiết lập validate
        $config = array(
            array(
                'field' => 'title',
                'label' => 'Tên thể loại',
                'rules' => 'trim|required|min_length[2]|max_length[255]'
            ),
            array(
                'field' => 'topic_id',
                'label' => 'Chủ đề',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'summary',
                'label' => 'Mô tả',
                'rules' => 'trim|required|min_length[2]'
            ),
            array(
                'field' => 'content',
                'label' => 'Nội dung',
                'rules' => 'trim|required|min_length[2]'
            ),
            array(
                'field' => 'image_path',
                'label' => 'Ảnh đại diện',
                'rules' => 'trim|required'
            ),
        );

        $this->form_validation->set_message('is_unique', '<li>' . 'Tên đã tồn tại!' . '</li>');
        $this->form_validation->set_message('required', '<li>' . 'Bạn chưa nhập' . ' %s!</li>');
        $this->form_validation->set_message('min_length', '<li>%s ' . 'tối thiểu 2 ký tự'. '!</li>');
        $this->form_validation->set_message('max_length', '<li>%s ' . 'tối đa 255 ký tự' . '!</li>');

        $this->form_validation->set_rules($config);

        // Xu ly form login
        if ($this->form_validation->run() == FALSE) {
            $this->_data['title'] = $this->input->post('title');
            $this->_data['summary'] = $this->input->post('summary');
            $this->_data['image_path'] = $this->input->post('image_path');
            $this->_data['link'] = $this->input->post('link');
            $this->_data['is_active'] = $this->input->post('is_active');
            $this->_data['content'] = $this->input->post('content');
            $this->_data['topic_id'] = $this->input->post('topic_id');
            //
            $this->_data['listNewsTopic'] = $this->MNewsTopic->getListForSelectBox(true);
            $this->_data['listNewsType'] = MyHelper::getNewsEventType();
            //
            $this->_data['functionName'] = 'Tin tức';
            $this->_data['actionName'] ='Thêm mới tin tức';
            $this->_data['breadCrumb'] = '/ ' . $this->_data['functionName'] . ' / ' . $this->_data['actionName'];
            $this->_data['titlePage'] = $this->_data['actionName'];
            $this->_data['loadPage'] = 'backend/news/add_news_view';
            $this->load->view('backend/admin_layout_view', $this->_data);
        } else {
            $title = trim($this->input->post('title'));
            $summary = trim($this->input->post('summary'));
            $image_path = trim($this->input->post('image_path'));
            $is_active = ($this->input->post('is_active') == 'on') ? 1 : 0;
            $content = trim($this->input->post('content'));
            $topic_id = trim($this->input->post('topic_id'));
            $type_id = trim($this->input->post('type_id'));
            //
            $data_insert = array(
                'title' => $title,
                'slug' => MyHelper::genSlug($title, 1),
                'summary' => $summary,
                'image_path' => str_replace(base_url(), '', $image_path),
                'content' => $content,
                'is_active' => $is_active,
                'topic_id' => $topic_id,
                'view_counter' => 0,
                'created_by' => $this->session->userdata('admin_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert_id = $this->MNews->add($data_insert);
            $insert_id = $insert_id->{'$id'};
            // Kiểm tra đk và bắn notification cho toàn bộ user
            //Ghi log action ADDED
            //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

            // Chuyen trang admin
            $this->session->set_flashdata('success', 'Thêm mới thành công!');
            redirect(base_url() . 'index.php/backend/news/listNews');
        }
    }

	public function editNews($news_id)
    {
        if (!$this->session->userdata('admin_id')) {
            redirect(base_url() . 'index.php/backend/account/login');
        }
        $this->_data['news'] = $news = $this->MNews->getByIdCMS($news_id);
        // Thiết lập validate
        $config = array(
            array(
                'field' => 'title',
                'label' => 'Tên thể loại',
                'rules' => 'trim|required|min_length[2]|max_length[255]'
            ),
            array(
                'field' => 'summary',
                'label' => 'Mô tả',
                'rules' => 'trim|required|min_length[2]'
            ),
            array(
                'field' => 'content',
                'label' => 'Nội dung',
                'rules' => 'trim|required|min_length[2]'
            ),
            array(
                'field' => 'image_path',
                'label' => 'Ảnh đại diện',
                'rules' => 'trim|required'
            ),
        );

        $this->form_validation->set_message('required', '<li>' .'Bạn chưa nhập' . ' %s!</li>');
        $this->form_validation->set_message('min_length', '<li>%s ' .  'tối thiểu 6 ký tự' . '!</li>');
        $this->form_validation->set_message('max_length', '<li>%s ' .  'tối đa 255 ký tự' . '!</li>');

        $this->form_validation->set_rules($config);

        // Xu ly form login
        if ($this->form_validation->run() == FALSE) {
            $this->_data['title'] = $this->input->post('title');
            $this->_data['summary'] = $this->input->post('summary');
            $this->_data['image_path'] = $this->input->post('image_path');
            $this->_data['is_active'] = $this->input->post('is_active');
            $this->_data['content'] = $this->input->post('content');
            $this->_data['topic_id'] = $this->input->post('topic_id');
            //
            $this->_data['listNewsTopic'] = $this->MNewsTopic->getListForSelectBox(true);
            $this->_data['listNewsType'] = MyHelper::getNewsEventType();
            //
            $this->_data['functionName'] = 'Tin tức';
            $this->_data['actionName'] = 'Cập nhật tin tức';
            $this->_data['breadCrumb'] = '/ ' . $this->_data['functionName'] . ' / ' . $this->_data['actionName'];
            $this->_data['titlePage'] = $this->_data['actionName'];
            $this->_data['loadPage'] = 'backend/news/edit_news_view';
            $this->load->view('backend/admin_layout_view', $this->_data);
        } else {
            $title = trim($this->input->post('title'));
            $summary = trim($this->input->post('summary'));
            $image_path = trim($this->input->post('image_path'));
            $is_active = ($this->input->post('is_active') == 'on') ? 1 : 0;
            $content = trim($this->input->post('content'));
            $topic_id = trim($this->input->post('topic_id'));
            $type_id = trim($this->input->post('type_id'));
            //

            $data_update = array(
                'title' => $title,
                'slug' => MyHelper::genSlug($title, 1),
                'summary' => $summary,
                'image_path' => str_replace(base_url(), '', $image_path),
                'content' => $content,
                'is_active' => $is_active,
                'topic_id' => $topic_id,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->MNews->update($news_id, $data_update);

            //Ghi log action UPDATED
            //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

            // Chuyen trang admin
            $this->session->set_flashdata('success', 'Cập nhật thành công!');
            redirect(base_url() . 'index.php/backend/news/listNews');
        }
    }

	public function deleteNews($news_id)
    {
        $news = $this->MNews->getById($news_id);
        $this->MNews->delete($news_id);

        //Ghi log action DELETED
        //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

        // Chuyen trang admin
        $this->session->set_flashdata('success',  'Xóa thành công!');
        redirect(base_url() . 'index.php/backend/news/listNews');
    }

	 public function changeIsActiveNews($is_active, $news_id)
    {
        if (in_array($is_active, array(0, 1))) {
            $data_update = array(
                'is_active' => (int)$is_active,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->MNews->update($news_id, $data_update);

            //Ghi log action CHANGED_IS_ACTIVE
            //add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)

            $this->session->set_flashdata('success', 'Thay đổi trạng thái thành công!');
        } else {
            $this->session->set_flashdata('notice', 'Thay đổi trạng thái không thành công!');
        }
        // Chuyen trang admin
        redirect(base_url() . 'index.php/backend/news/listNews');
    }

    // Callback kiem tra ten
    public function check_newstopic_name($name, $news_topic_id)
    {
        $name2 = MyHelper::unsigned($name);
        $pattern = '/^[a-zA-Z0-9_\:\-\ \(\),\|\/]+$/';
        if (!preg_match($pattern, $name2)) {
            $this->form_validation->set_message('check_newstopic_name', '<li>' . 'Tên không hợp lệ! Tên chỉ bao gồm: a-z, A-Z, 0-9, _' . '</li>');
            return FALSE;
        } else {
            //Kiem tra ton tai
            $checkNameExisted = $this->MNewsTopic->checkExistedByName(trim($name), $news_topic_id);
            if (count($checkNameExisted) > 0) {
                $this->form_validation->set_message('check_newstopic_name', '<li>%s ' . 'đã tồn tại!' . '</li>');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    // Callback kiem tra ten
    public function check_news_name($name, $news_id)
    {
        //Kiem tra ton tai
        $checkNameExisted = $this->MNews->checkExistedByName(trim($name), $news_id);
        if (count($checkNameExisted) > 0) {
            $this->form_validation->set_message('check_news_name', '<li>%s ' . MyHelper::tVal('118_0317', 'đã tồn tại!') . '</li>');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/* End of file News.php */
/* Location: ./application/controllers/backend/News.php */
