<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	protected $_data;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        //
        $this->load->model('MAdmin');
    }

	public function index()
	{

	}

	    //Admin ------------------------------------------------------------------------------------------------------------
    public function listAdmin()
    {
        // Tai lib
        $this->load->model('MAdmin');

        // Dem so usser
        $this->_data['countAllUser'] = $this->MAdmin->countIsActive();
        $this->_data['listAccountType'] = MyHelper::getAccountType();

        //
        $this->_data['functionName'] = 'Hệ thống';
        $this->_data['actionName'] = 'Quản trị viên';
        $this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
        $this->_data['titlePage'] = $this->_data['actionName'];
        $this->_data['loadPage'] = 'backend/admin/list_admin_view';
        $this->load->view('backend/admin_layout_view', $this->_data);
    }

    public function listAdminAjax()
    {
        $this->load->model('MAdmin');
        //
        $data = array();
        $filterByUserName = $this->input->post('filterByUserName');
        $filterByIsActive = $this->input->post('filterByIsActive');
        $pageId = $this->input->post('pageId');
        //
        $pageId = ($pageId == 0) ? 1 : $pageId;
        $limit = 10;
        $offset = ($pageId - 1)*$limit;
        $data['offset'] = ($pageId - 1)*$limit;
        $totalRecord = $this->MAdmin->adminCountAll($filterByUserName, $filterByIsActive);
        $data['pagination'] = MyHelper::genPaginationLink($totalRecord, $limit, $pageId);
        $data['listUser'] = $this->MAdmin->adminGetPagination($filterByUserName, $filterByIsActive, $limit, $offset);
        //
        $this->load->view('ajax/cms_admin/list_admin_view', $data);
    }

    public function addAdmin(){
        if(! $this->session->userdata('admin_id')){
            redirect(base_url().'backend/account/login');
        }
        $this->load->model('MAdmin');
        // Thiết lập validate



        $config = array(
            array(
                'field'   => 'fullname',
                'label'   => 'Họ và tên',
                'rules'   => 'trim|required|min_length[2]|max_length[255]'
            ),
            array(
                'field'   => 'username',
                'label'   => 'Tài khoản',
                'rules'   => 'trim|required|min_length[2]|max_length[255]|callback_check_admin_username['.null.']'
            ),
            array(
                'field'   => 'password',
                'label'   => 'Mật khẩu',
                'rules'   => 'trim|required'
            ),
            array(
                'field'   => 'repassword',
                'label'   => 'Xác nhận mật khẩu',
                'rules'   => 'trim|required'
            ),
            array(
                'field'   => 'email',
                'label'   => 'Email',
                'rules'   => 'trim|required|callback_check_admin_email['.null.']'
            )
        );

        $this->form_validation->set_message('is_unique', '<li>Tên đã tồn tại!</li>');
        $this->form_validation->set_message('required', '<li>Bạn chưa nhập %s!</li>');
        $this->form_validation->set_message('min_length', '<li>%s tối thiểu 6 ký tự!</li>');
        $this->form_validation->set_message('max_length', '<li>%s tối đa 255 ký tự!</li>');

        $this->form_validation->set_rules($config);

        // Xu ly form login
        if($this->form_validation->run() == FALSE){
            $this->_data['fullname'] = $this->input->post('fullname');
            $this->_data['username'] = $this->input->post('username');
            $this->_data['password'] = $this->input->post('password');
            $this->_data['repassword'] = $this->input->post('repassword');
            $this->_data['email'] = $this->input->post('email');
            $this->_data['is_active'] = $this->input->post('is_active');

            $this->_data['functionName'] = 'Hệ thống';
            $this->_data['actionName'] = 'Thêm mới Admin';
            $this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
            $this->_data['titlePage'] = $this->_data['actionName'];
            $this->_data['loadPage'] = 'backend/admin/add_admin_view';
            $this->load->view('backend/admin_layout_view', $this->_data);
        }else{
            $fullname = trim($this->input->post('fullname'));
            $username = trim($this->input->post('username'));
            $password = trim($this->input->post('password'));
            $password = MyHelper::genKeyCode($password);
            $is_active = ($this->input->post('is_active') == 'on') ? 1 : 0;
            $email = trim($this->input->post('email'));

            $data_insert = array(
                'fullname' => $fullname,
                'username' => $username,
                'salt' => null,
                'password' => $password,
                'email' => $email,
                'is_active' => $is_active,
                'is_super' => 0,
                'is_system' => 0,
                'private_key' => md5($email),
                "type" => "dcv",
                "user_id" => null,
                "sms_code" => 0,
                'group_id' => '',
                'actions' => '',
                'created_by' => $this->session->userdata('admin_id'),
                'updated_by' => $this->session->userdata('admin_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->MAdmin->add($data_insert);
            $this->session->set_flashdata('success', 'Thêm mới thành công!');
            // Chuyen trang admin
            redirect(base_url().'backend/setting/listAdmin');
        }
    }

    public function editAdmin($admin_id){
        if(! $this->session->userdata('admin_id')){
            redirect(base_url().'backend/account/login');
        }
        $this->load->model('MAdmin');
        $this->_data['admin'] = $admin = $this->MAdmin->getById($admin_id);

        // Thiết lập validate
        $config = array(
            array(
                'field'   => 'fullname',
                'label'   => 'Họ và tên',
                'rules'   => 'trim|required|min_length[2]|max_length[255]'
            )
        );

        $this->form_validation->set_message('is_unique', '<li>Tên đã tồn tại!</li>');
        $this->form_validation->set_message('required', '<li>Bạn chưa nhập %s!</li>');
        $this->form_validation->set_message('min_length', '<li>%s tối thiểu 6 ký tự!</li>');
        $this->form_validation->set_message('max_length', '<li>%s tối đa 255 ký tự!</li>');

        $this->form_validation->set_rules($config);

        // Xu ly form login
        if($this->form_validation->run() == FALSE){
            $this->_data['fullname'] = $this->input->post('fullname');
            $this->_data['is_active'] = $this->input->post('is_active');
            //
            $this->_data['functionName'] = 'Hệ thống';
            $this->_data['actionName'] = 'Cập nhật Admin';
            $this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
            $this->_data['titlePage'] = $this->_data['actionName'];
            $this->_data['loadPage'] = 'backend/admin/edit_admin_view';
            $this->load->view('backend/admin_layout_view', $this->_data);
        }else{
            $fullname = trim($this->input->post('fullname'));
            $is_active = ($this->input->post('is_active') == 'on') ? 1 : 0;

            $data_insert = array(
                'fullname' => $fullname,
                'salt' => null,
                'is_active' => $is_active,
                'is_super' => 0,
                'private_key' => '2016',
                'group_id' => '',
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->MAdmin->update($admin_id, $data_insert);
            $this->session->set_flashdata('success', 'Cập nhật thành công!');
            // Chuyen trang admin
            redirect(base_url().'index.php/backend/setting/listAdmin');
        }
    }

    public function deleteAdmin($admin_id)
    {
        $admin = $this->MAdmin->getById($admin_id);
        if(count($admin) > 0){
            $this->MAdmin->update($admin[0]['_id']->{'$id'}, array(
                'is_active' => 0,
                'updated_by' => $this->session->userdata('admin_id'),
                'updated_at' => date('Y-m-d H:i:s')
            ));
            $this->session->set_flashdata('success', 'Khóa tài khoản thành công!');
        }else{
            $this->session->set_flashdata('notice', 'Khóa tài khoản không thành công!');
        }
        redirect(base_url('index.php/backend/setting/listAdmin'));
    }

    public function changeIsActiveAdmin($is_active, $admin_id){
        if(in_array($is_active, array(0, 1))){
            $this->load->model('MAdmin');
            $data_update = array(
                'is_active' => (int)$is_active,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->MAdmin->update($admin_id, $data_update);
            $this->session->set_flashdata('success', 'Thay đổi trạng thái thành công!');
        }else{
            $this->session->set_flashdata('notice', 'Thay đổi trạng thái không thành công!');
        }
        // Chuyen trang admin
        redirect(base_url().'index.php/backend/setting/listAdmin');
    }

    public function changePasswordAdmin($admin_id){
        if(! $this->session->userdata('admin_id')){
            redirect(base_url().'index.php/backend/account/login');
        }
        $this->load->model('MAdmin');
        $this->_data['admin'] = $admin = $this->MAdmin->getById($admin_id);
        // Thiết lập validate
        $config = array(
            array(
                'field'   => 'old_password',
                'label'   => 'Mật khẩu cũ',
                'rules'   => 'trim|xss_clean'
            ),
            array(
                'field'   => 'new_password',
                'label'   => 'Mật khẩu mới',
                'rules'   => 'trim|xss_clean'
            ),
            array(
                'field'   => 'renew_password',
                'label'   => 'Xác nhận mật khẩu mới',
                'rules'   => 'trim|xss_clean'
            )
        );

        $this->form_validation->set_message('is_unique', '<li>Tên đã tồn tại!</li>');
        $this->form_validation->set_message('required', '<li>Bạn chưa nhập %s!</li>');
        $this->form_validation->set_message('min_length', '<li>%s tối thiểu 6 ký tự!</li>');
        $this->form_validation->set_message('max_length', '<li>%s tối đa 255 ký tự!</li>');

        $this->form_validation->set_rules($config);

        // Xu ly form login
        if($this->form_validation->run() == FALSE){
            $this->_data['old_password'] = $this->input->post('old_password');
            $this->_data['new_password'] = $this->input->post('new_password');
            $this->_data['renew_password'] = $this->input->post('password');
            //
            $this->_data['functionName'] = 'Hệ thống';
            $this->_data['actionName'] = 'Cập nhật mật khẩu Admin';
            $this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
            $this->_data['titlePage'] = $this->_data['actionName'];
            $this->_data['loadPage'] = 'backend/admin/change_password_admin_view';
            $this->load->view('backend/admin_layout_view', $this->_data);
        }else{
            $new_password = trim($this->input->post('new_password'));
            $new_password = MyHelper::genKeyCode($new_password);

            $data_update = array(
                'password' => $new_password,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->MAdmin->update($admin_id, $data_update);
            $this->session->set_flashdata('success', 'Cập nhật mật khẩu thành công!');
            // Chuyen trang admin
            redirect(base_url().'index.php/backend/setting/listAdmin');
        }
    }

    public function check_admin_email($email) {
        $this->load->model('Madmin');
        //Kiem tra ton tai
        $checkNameExisted = $this->Madmin->checkExistedByField('email', $email);
        if(!empty($checkNameExisted)){
            $this->form_validation->set_message('check_admin_email', '<li>%s '.'đã tồn tại!'.'</li>');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function check_admin_username($name) {
        $this->load->model('Madmin');
        //Kiem tra ton tai
        $checkNameExisted = $this->Madmin->checkExistedByField('username', $name);
        if(!empty($checkNameExisted)){
            $this->form_validation->set_message('check_admin_username', '<li>%s '.'đã tồn tại!'.'</li>');
            return FALSE;
        }else{
            return TRUE;
        }
    }

}

/* End of file Setting.php */
/* Location: ./application/controllers/backend/Setting.php */