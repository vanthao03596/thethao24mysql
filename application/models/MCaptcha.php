<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MCaptcha extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // Hàm tạo captcha ảnh
    public function setCaptcha()
    {
        $this->load->helper('string');
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => './upload/captcha/',
            'img_url' => base_url() . 'upload/captcha/',
            'expiration' => 60, // one hour
            'font_path' => './system/fonts/texb.ttf',
            'img_width' => '140',
            'img_height' => '34',
            'word' => random_string('numeric', 3),
        );
        return create_captcha($vals);
    }
}

?>