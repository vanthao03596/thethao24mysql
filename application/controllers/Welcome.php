<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		set_time_limit(0);
		$this->load->model('MNews');
	}

	public function index()
	{
		set_time_limit(0);
		include_once('simple_html_dom.php');
		$j = 0;
		// for ($i = 0; $i<10; $i ++) {
			$html =  file_get_html('http://ale.vn/ajax/getDiemtinList.jsp?skip=' . 1);
			foreach ($html->find('li') as $li) {
				$a = $li->find('div.ND_news_img a', 0);
				$img = $li->find('div.ND_news_img a img', 0);
				$title = $li->find('div.ND_news_text a', 0);

				$content = file_get_html(trim('http://ale.vn' . $a->href));
				$div = $content->find('div.Page_Diemtin_Tin_Content', 0);
				$img = $div->find('img', 0);
				$explode = explode('cache/', $img->src);
				$img_name = $explode[1];
				$this->curl_download($img->src, 'upload/ckfinder/images/'.$img_name);
				$img->src = base_url() . 'upload/ckfinder/images/' . $img_name;
				$text = $div->innertext;
				$data[] = [
					'title' => trim($title->plaintext),
					'slug' => MyHelper::genSlug(trim($title->plaintext)),
					'summary' => '',
					'is_active' => 1,
					'topic_id' => '3',
					'view_counter' => 0,
					'created_by' => '5b03c4856f94048c29000030',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'content' => trim($text),
					'image_path' => 'upload/ckfinder/images/' . $img_name,
				];
				$j++;
			}

		// }
		$this->MNews->insertMany($data);


	}
	public function curl_download($Url, $saveTo)
	{
		set_time_limit(0);
		// Mở một file mới với đường dẫn và tên file là tham số $saveTo
		$fp = fopen($saveTo, 'w+');

		// Bắt đầu CURl
		$ch = curl_init($Url);

		// Thiết lập giả lập trình duyệt
		// nghĩa là giả mạo đang gửi từ trình duyệt nào đó, ở đây tôi dùng Firefox
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

		// Thiết lập trả kết quả về chứ không print ra
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Thời gian timeout
		curl_setopt($ch, CURLOPT_TIMEOUT, 1000);

		// Lưu kết quả vào file vừa mở
		curl_setopt($ch, CURLOPT_FILE, $fp);

		// Thực hiện download file
		$result = curl_exec($ch);

		// Đóng CURL
		curl_close($ch);

		return $result;
	}

	public function createId( $timestamp, $inc ){
		set_time_limit(0);
		$ts = pack( 'N', $timestamp );
		$m = substr( md5( gethostname()), 0, 3 );
		$pid = pack( 'n', getmypid() );
		$trail = substr( pack( 'N', $inc++ ), 1, 3);
		$bin = sprintf("%s%s%s%s", $ts, $m, $pid, $trail);
		$id = '';
		for ($i = 0; $i < 12; $i++ ){
			$id .= sprintf("%02X", ord($bin[$i]));
		}
		$mongoId = new MongoID($id);
		return $mongoId;
	}
}
