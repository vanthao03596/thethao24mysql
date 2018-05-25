<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MyHelper
{
    protected $CI;
    const URL_FRONTEND = "http://facelive.la/";
    const REGISTER_PATERN_USERNAME = "/^[a-zA-Z0-9]{6,32}$/";
    const REGISTER_PATERN_PASSWORD = "/^[a-zA-Z0-9_\.\@]{8,32}$/";
    const REGISTER_PATERN_MOBILE = "/^841\d{9}$|^84[2-9]{1}\d{8}$|^01\d{9}$|^0[2-9]{1}\d{8}$/";
    const REGISTER_PATERN_PASSPORT = "/^[0-9]{9}$|^[0-9]{12}$/";
    const FIREBASE_KEY = "AIzaSyCl_Q-Qvh-bHpM80fVEou6j7IoWzlmtpzc";
    const CMS_REPORT_NOTI = 'Một bài đăng của bạn đã bị xóa do vi phạm chính sách nội dung của chúng tôi, nếu tiếp tục vi phạm lần 2, chúng tôi sẽ tiến hành khóa tài khoản của bạn.';

    //
    public function __construct()
    {
        $this->CI = & get_instance();
    }

    /**
     * 28/12/2015 by doanpv
     * Hàm định dạng hiển thị lại số điện thoại
     * @param $phone
     * @param string $separate
     * @param int $readType
     * @return string
     */
    public static function format_phone($phone, $separate = '.', $readType = 433)
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);
        if (strlen($phone) == 7) {
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
        } elseif (strlen($phone) == 9) {
            if ($readType == 334) {
                return '0' . preg_replace("/([0-9]{2})([0-9]{3})([0-9]{4})/", "$1$separate$2$separate$3", $phone);
            } elseif ($readType == 343) {
                return '0' . preg_replace("/([0-9]{2})([0-9]{4})([0-9]{3})/", "$1$separate$2$separate$3", $phone);
            } elseif ($readType == 424) {
                return '0' . preg_replace("/([0-9]{3})([0-9]{2})([0-9]{4})/", "$1$separate$2$separate$3", $phone);
            } elseif ($readType == 433) {
                return '0' . preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})/", "$1$separate$2$separate$3", $phone);
            }
        } elseif (strlen($phone) == 10) {
            return '0' . preg_replace("/([0-9]{4})([0-9]{3})([0-9]{3})/", "$1$separate$2$separate$3", $phone);
        } else {
            return '0' . $phone;
        }
    }

    public static function format_chargetime($chargetime, $separate = '/')
    {
        $chargetime = preg_replace("/[^0-9]/", "", $chargetime);
        if (strlen($chargetime) == 14) {
            return preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "$3$separate$2$separate$1 $4:$5:$6", $chargetime);
        } else {
            return $chargetime;
        }
    }

    public static function reFormatDate($datetime, $format = 'd/m/Y H:i:s')
    {
        return (isset($datetime) && ($datetime != '0000-00-00 00:00:00')) ? date($format, strtotime($datetime)) : '';
    }

    /**
     * 30/12/2015 by doanpv
     * Hàm xem cấu trúc dữ liệu, ko die
     * @param $data
     */
    public static function echoPre($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    /**
     * 30/12/2015 by doanpv
     * Hàm xem cấu trúc dữ liệu, có die()
     * @param $data
     */
    public static function echoPreDie($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }

    public static function truncate($text, $length = 30, $truncateString = '...', $truncateLastspace = false, $escapeHtml = false)
    {
        /**
         * Ham tra cat ky tu tieng viet
         * @param $text
         * @param int $length
         * @param string $truncateString
         * @param bool $truncateLastspace
         * @return string
         * @throws dmException
         */
        /*if (sfConfig::get('sf_escaping_method') == 'ESC_SPECIALCHARS') {
            $text = htmlspecialchars_decode($text, ENT_QUOTES);
        }*/

        if (is_array($text)) {
            throw new dmException('Can not truncate an array: ' . implode(', ', $text));
        }

        $text = (string)$text;

        if (extension_loaded('mbstring')) {
            $strlen = 'mb_strlen';
            $substr = 'mb_substr';
            //hatt12 them dong nay de dem ky tu tieng viet
            $countStr = $strlen($text, 'utf-8');
            if ($countStr > $length) {
                $text = $substr($text, 0, $length, 'utf-8');

                if ($truncateLastspace) {
                    $text = preg_replace('/\s+?(\S+)?$/', '', $text);
                }

                $text = $text . $truncateString;
            }
        } else {
            $strlen = 'strlen';
            $substr = 'substr';
            $countStr = $strlen($text);
            if ($countStr > $length) {
                $text = $substr($text, 0, $length);

                if ($truncateLastspace) {
                    $text = preg_replace('/\s+?(\S+)?$/', '', $text);
                }

                $text = $text . $truncateString;
            }
        }

        if ($escapeHtml) {
            return $text;
        }
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
    public static function nameSlug($str, $strtolower = 0)
    {
       // $marTViet= array('ố','ơ','ư','ặ','ơ','ị','ắ','ă','ạ','ệ','ứ','Đ','ũ','ễ','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        //$marKoDau = array('o','o','u','a','o','i','a','a','a','e','u','D','u','e','A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        $marTViet = array(
            "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
            "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ");
        $marKoDau = array(
            "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");
        if ($strtolower != 0) {
            $str= strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','.',''),str_replace($marTViet,$marKoDau,$str)));
        } else {
            $str= preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','.',''),str_replace($marTViet,$marKoDau,$str));
        }
        return $str;
    }

    public static function genSlug($str, $strtolower = 0)
    {
        //$marTViet= array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        //$marKoDau = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        $marTViet = array(
            "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
            "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ");
        $marKoDau = array(
            "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");
        if ($strtolower != 0) {
            $str= strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($marTViet,$marKoDau,$str)));
        } else {
            $str= preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($marTViet,$marKoDau,$str));
        }
        return $str;
    }

    public static function unsigned($str, $strtolower = 0)
    {
        $marTViet = array(
            "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
            "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ");
        $marKoDau = array(
            "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");
        if ($strtolower != 0) {
            $str = strtolower(str_replace($marTViet, $marKoDau, $str));
        } else {
            $str = str_replace($marTViet, $marKoDau, $str);
        }
        return $str;
    }

    public static function genKeyCode($str, $alog = 'sha256')
    {
        if ($str != '') {
            return hash($alog, $str);
        } else {
            return hash($alog, date('dmY'));
        }
    }

    public static function genExportPassword($length = 10)
    {
        if ($length > 0 && $length <= 32) {
            return substr(md5(rand(1, 9999)), 0, $length);
        } else {
            return substr(md5(rand(1, 9999)), 0, 10);
        }
    }

    /**
     * doanpv - 28/01/2016
     * Hàm đọc số thành chữ, dùng để đọc hóa đơn cước
     * @param $number
     * @return bool|null|string
     */
    public static function number2words($number)
    {
        $hyphen = ' ';
        $conjunction = '  ';
        $separator = ' ';
        $negative = 'âm ';
        $decimal = ' phẩy ';
        $dictionary = array(
            0 => 'Không',
            1 => 'Một',
            2 => 'Hai',
            3 => 'Ba',
            4 => 'Bốn',
            5 => 'Năm',
            6 => 'Sáu',
            7 => 'Bảy',
            8 => 'Tám',
            9 => 'Chín',
            10 => 'Mười',
            11 => 'Mười một',
            12 => 'Mười hai',
            13 => 'Mười ba',
            14 => 'Mười bốn',
            15 => 'Mười năm',
            16 => 'Mười sáu',
            17 => 'Mười bảy',
            18 => 'Mười tám',
            19 => 'Mười chín',
            20 => 'Hai mươi',
            30 => 'Ba mươi',
            40 => 'Bốn mươi',
            50 => 'Năm mươi',
            60 => 'Sáu mươi',
            70 => 'Bảy mươi',
            80 => 'Tám mươi',
            90 => 'Chín mươi',
            100 => 'trăm',
            1000 => 'ngàn',
            1000000 => 'triệu',
            1000000000 => 'tỷ',
            1000000000000 => 'nghìn tỷ',
            1000000000000000 => 'ngàn triệu triệu',
            1000000000000000000 => 'tỷ tỷ'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'self::number2words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . self::number2words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . self::number2words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = self::number2words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= self::number2words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public static function genSrcImageByBase64($path)
    {
        if ($path == '') {
            $path = '/uploads/grid.png';
        }
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        return $base64;
    }

    public static function genPaginationLink($totalRecord, $pageSize = 10, $pageIndex = 1, $paginationName = 'changePagination')
    {
        $pagination = "";
        if ($pageSize >= 1 && $pageIndex >= 1) {
            $adjacents = "2";
            $prev = $pageIndex - 1;
            $next = $pageIndex + 1;
            $lastpage = ceil($totalRecord / $pageSize);
            $lpm1 = $lastpage - 1;
        } else {
            return $pagination;
        }

        if ($lastpage > 1) {
            $pagination .= "<div class='pagination'>";
            if ($pageIndex > 1) {
                $pagination .= "<a href=\"#page=" . ($prev) . "\" onClick='" . $paginationName . "(" . ($prev) . ");'>&laquo;&nbsp;</a>";
            } else {
                $pagination .= "<span class='disabled'>&laquo;&nbsp;</span>";
            }
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $pageIndex) {
                        $pagination .= "<span class='current'>$counter</span>";
                    } else {
                        $pagination .= "<a href=\"#page=" . ($counter) . "\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($pageIndex < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a href=\"#page=" . ($counter) . "\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                        }
                    }
                    $pagination .= "...";
                    $pagination .= "<a href=\"#page=" . ($lpm1) . "\" onClick='" . $paginationName . "(" . ($lpm1) . ");'>$lpm1</a>";
                    $pagination .= "<a href=\"#page=" . ($lastpage) . "\" onClick='" . $paginationName . "(" . ($lastpage) . ");'>$lastpage</a>";

                } elseif ($lastpage - ($adjacents * 2) > $pageIndex && $pageIndex > ($adjacents * 2)) {
                    $pagination .= "<a href=\"#page=\"1\"\" onClick='" . $paginationName . "(1);'>1</a>";
                    $pagination .= "<a href=\"#page=\"2\"\" onClick='" . $paginationName . "(2);'>2</a>";
                    $pagination .= "...";
                    for ($counter = $pageIndex - $adjacents; $counter <= $pageIndex + $adjacents; $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a href=\"#page=" . ($counter) . "\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                        }
                    }
                    $pagination .= "..";
                    $pagination .= "<a href=\"#page=" . ($lpm1) . "\" onClick='" . $paginationName . "(" . ($lpm1) . ");'>$lpm1</a>";
                    $pagination .= "<a href=\"#page=" . ($lastpage) . "\" onClick='" . $paginationName . "(" . ($lastpage) . ");'>$lastpage</a>";
                } else {
                    $pagination .= "<a href=\"#page=\"1\"\" onClick='" . $paginationName . "(1);'>1</a>";
                    $pagination .= "<a href=\"#page=\"2\"\" onClick='" . $paginationName . "(2);'>2</a>";
                    $pagination .= "..";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a href=\"#page=" . ($counter) . "\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                        }
                    }
                }
            }
            if ($pageIndex < $counter - 1) {
                $pagination .= "<a href=\"#page=" . ($next) . "\" onClick='" . $paginationName . "(" . ($next) . ");'> &raquo;</a>";
            } else {
                $pagination .= "<span class='disabled'> &raquo;</span>";
            }
            $pagination .= "</div> (Tổng số kết quả: " . number_format($totalRecord) . ")";
        }
        return $pagination;
    }
    /**
    Hieudd custom genPaginationLink
    **/
    public static function genPagination($totalRecord, $pageSize = 10, $pageIndex = 1, $paginationName = 'changePagination')
    {
        $pagination = "";
        if ($pageSize >= 1 && $pageIndex >= 1) {
            $adjacents = "2";
            $prev = $pageIndex - 1;
            $next = $pageIndex + 1;
            $lastpage = ceil($totalRecord / $pageSize);
            $lpm1 = $lastpage - 1;
        } else {
            return $pagination;
        }

        if ($lastpage > 1) {
            $pagination .= "<div class='pagination'>";
            if ($pageIndex > 1) {
                $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($prev) . ");'>&laquo;&nbsp;</a>";
            } else {
                $pagination .= "<span class='disabled'>&laquo;&nbsp;</span>";
            }
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $pageIndex) {
                        $pagination .= "<span class='current'>$counter</span>";
                    } else {
                        $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($pageIndex < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                        }
                    }
                    $pagination .= "...";
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($lpm1) . ");'>$lpm1</a>";
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($lastpage) . ");'>$lastpage</a>";

                } elseif ($lastpage - ($adjacents * 2) > $pageIndex && $pageIndex > ($adjacents * 2)) {
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(1);'>1</a>";
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(2);'>2</a>";
                    $pagination .= "...";
                    for ($counter = $pageIndex - $adjacents; $counter <= $pageIndex + $adjacents; $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                        }
                    }
                    $pagination .= "..";
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($lpm1) . ");'>$lpm1</a>";
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($lastpage) . ");'>$lastpage</a>";
                } else {
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(1);'>1</a>";
                    $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(2);'>2</a>";
                    $pagination .= "..";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($counter) . ");'>$counter</a>";
                        }
                    }
                }
            }
            if ($pageIndex < $counter - 1) {
                $pagination .= "<a href=\"javascript:;\" onClick='" . $paginationName . "(" . ($next) . ");'> &raquo;</a>";
            } else {
                $pagination .= "<span class='disabled'> &raquo;</span>";
            }
            $pagination .= "</div>";
        }
        return $pagination;
    }

    /**
     * 02/08/2016 by doanpv
     * Ham tra ve mang cac bieu tuong cam xuc
     * @return mixed
     */
    public static function getArrayEmotionIcon()
    {
        $emo[':_/'] = 'thinking.png';
        $emo[':-/'] = 'thinking.png';

        $emo['0:)'] = 'angel.png';
        $emo['0:-)'] = 'angel.png';
        $emo['O:)'] = 'angel.png';
        $emo['O:-)'] = 'angel.png';

        $emo[':)'] = 'smile.png';

        $emo[':D'] = 'smile-big.png';
        $emo[':-D'] = 'smile-big.png';

        $emo[':('] = 'sad.png';
        $emo[':-('] = 'sad.png';
        $emo['=('] = 'sad.png';

        $emo[':\'('] = 'crying.png';

        $emo[':p'] = 'tongue.png';
        $emo[':P'] = 'tongue.png';
        $emo[':-p'] = 'tongue.png';
        $emo[':-P'] = 'tongue.png';

        $emo['<:o)'] = 'party.png';

        $emo[':o'] = 'shocked.png';
        $emo[':O'] = 'shocked.png';
        $emo[':0'] = 'shocked.png';

        $emo[':@'] = 'angry.png';

        $emo[':s'] = 'confused.png';
        $emo[':S'] = 'confused.png';

        $emo[';)'] = 'wink.png';
        $emo[';-)'] = 'wink.png';

        $emo[':$'] = 'embarrassed.png';

        $emo[':|'] = 'disappointed.png';

        $emo['+o('] = 'sick.png';

        $emo[':#'] = 'shut-mouth.png';
        $emo[':-#'] = 'shut-mouth.png';

        $emo['|)'] = 'sleepy.png';
        $emo['|-)'] = 'sleepy.png';

        $emo['8)'] = 'eyeroll.png';
        $emo['8-)'] = 'eyeroll.png';

        $emo['8|'] = 'glasses-nerdy.png';
        $emo['8-|'] = 'glasses-nerdy.png';

        $emo['8o|'] = 'teeth.png';

        $emo['<3'] = 'love.png';
        $emo['&lt;3'] = 'love.png';

        //
        return $emo;
    }

    /**
     * 26/07/2016 @ hieudd
     * Hàm trả về emotion icon
     * @param $status = array()
     * @return string
     */
    public static function getEmotionIcon($status)
    {
        if (!is_array($status)) {
            return "";
        } else {
            $emo = MyHelper::getArrayEmotionIcon();
            $data = "";
            foreach ($status as $value) {
                if (isset($emo[$value])) {
                    $value = "<img src = " . base_url() . "public/frontend/emoticons/" . $emo[$value] . " class='emotion' >" . " ";
                }
                $data .= $value . " ";
            }
            return $data;
        }
    }

    /**
     * 02/08/2016 by doanpv
     * Ham lay bieu tuong cam xuc trong CMS
     * @param null $content
     * @return mixed|null|string
     */
    public static function getEmotionIconCMS($content = null)
    {
        if ($content == null) {
            return "";
        } else {
            $emo = MyHelper::getArrayEmotionIcon();
            $arrKey = array_keys($emo);
            foreach ($arrKey as $value) {
                $path = "<img src = " . base_url() . "public/frontend/emoticons/" . $emo[$value] . " class='emotion' >" . " ";
                $content = str_replace($value, $path, $content);
            }
            return $content;
        }
    }

    /**
     * 18/08/2016 by hieudd
     * Ham tra ve mang cac bieu tuong cam xuc chat
     * @return mixed
     */
    protected static function getArrayEmotionChat()
    {
        $CI = & get_instance();
        $CI->load->model('Memoticon');
        $data = $CI->Memoticon->getAll(true);
        foreach ($data as $value) {
            $emoChat[$value["name"]] = $value["image_path"];
        }
        return $emoChat;
    }

    /**
     * 18/08/2016 by hieudd
     * Ham lay bieu tuong cam xuc trong chat
     * @param null $content
     * @return mixed|null|string
     */
    public static function getEmotionIconChat($content = null)
    {
        if ($content == null) {
            return "";
        } else {
            $status = explode(" ", $content);
            if (!is_array($status)) {
                return "";
            } else {
                $emo = MyHelper::getArrayEmotionChat();
                $data = "";
                foreach ($status as $value) {
                    if (isset($emo[$value])) {
                        if (preg_match("/http/", $emo[$value])) {
                            $value = "<img src = ". str_replace('http://', 'https://', $emo[$value]) . " class='icon-chat' >" . " ";
                        }else{
                            $value = "<img src = ".base_url() . $emo[$value] . " class='icon-chat' >" . " ";
                        }
                    }
                    $data .= $value . " ";
                }
                return $data;
            }
        }
    }

    /**
     * 28/07/2016 @ hieudd
     * Hàm crop ảnh
     * @param $source
     * @return bool
     */
    public static function cropImg($source, $w, $h, $suffix = '_thumb')
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = $suffix;
        $config['maintain_ratio'] = FALSE;
        $imageSize = getimagesize($config['source_image']);
        $width = $imageSize[0];
        $height = $imageSize[1];
        if ($width * $h > $height * $w) {
            $config['width'] = ($height * $w) / $h;
            $config['height'] = $height;
            $config['x_axis'] = (($width / 2) - ($config['width'] / 2));
        } else {
            $config['height'] = ($width * $h) / $w;
            $config['width'] = $width;
            $config['y_axis'] = (($height / 2) - ($config['height'] / 2));
        }
        $CI = &get_instance();
        $CI->load->library('image_lib', $config);
        $CI->image_lib->initialize($config);
        if ($CI->image_lib->crop()) {
            $return = true;
        } else {
            $return = false;
        }
        $CI->image_lib->clear();
        unset($config);
        return $return;
    }

    /**
     * 8/09/2016 @ hieudd
     * Hàm resize ảnh
     * @param $source
     * @return bool
     */
    public static function resizeImgBK($source)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '_cmsthumb';
        $config['maintain_ratio'] = FALSE;
        $imageSize = getimagesize($config['source_image']);
        $width = $imageSize[0];
        $height = $imageSize[1];
        if ($width > $height) {
            $config['width'] = 100;
            $config['height'] = (100 * $height)/$width;
        } else {
            $config['height'] = 100;
            $config['width'] = (100 * $width)/$height;
        }
        $CI = & get_instance();
        $CI->load->library('image_lib', $config);
        $CI->image_lib->initialize($config);
        if ($CI->image_lib->resize()) {
            $return = true;
        } else {
            $return = false;
        }
        $CI->image_lib->clear();
        unset($config);
        return $return;
    }

    /**
     * Hàm resize ảnh -------------------------------------------------------------------------------------------------
     * 8/09/2016 @ hieudd
     * Updated by: doanpv - 22/09/2017
     * - Customize thêm resize theo % dung lượng
     * - Thêm 2 tham số: suffix và is_quality
     * - is_quality=false: resize theo kích thước
     * - is_quality=true: resize theo % chất lượng ảnh
     * @param $source
     * @param $suffix
     * @return bool
     */
    public static function resizeImg($source, $to_width=100, $to_height=100, $suffix = '_cms')
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = $suffix;
        $config['maintain_ratio'] = FALSE;
        $imageSize = getimagesize($config['source_image']);
        $width = $imageSize[0];
        $height = $imageSize[1];
        //
        if($width > 400 && $suffix != '_cms' && $suffix != '_tablet_thumb'){$to_width = 400;}
        if($height > 400 && $suffix != '_cms' && $suffix != '_tablet_thumb'){$to_height = 400;}
        if ($width > $height) {
            $config['width'] = $to_width;
            $config['height'] = ($to_width * $height) / $width;
        } else {
            $config['height'] = $to_height;
            $config['width'] = ($to_height * $width) / $height;
        }
        $CI = &get_instance();
        $CI->load->library('image_lib', $config);
        $CI->image_lib->initialize($config);
        if ($CI->image_lib->resize()) {
            $return = true;
        } else {
            $return = false;
        }
        $CI->image_lib->clear();
        unset($config);
        return $return;
    }

    /**
     * 01/08/2016 by doanpv
     * @param null $id
     * @return array|string
     */
    public static function getErrorCode($id = null)
    {
        $arr = array(
            '0' => '0 - Thành công',
            '1' => '1 - Sai phương thức',
            '2' => '2 - Lỗi DB',
            '3' => '3 - Thiếu tham số'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Hàm trả về ds các nền tảng phần mềm hệ điều hành
     * @param null $id
     * @return array|string
     */
    public static function getListPlatform($id=null)
    {
        $arr = array(
            'iOS' => 'iOS',
            'android' => 'Android',
            'window' => 'Window'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * 01/08/2016 by doanpv
     * @param null $id
     * @return array|string
     */
    public static function getSlideAdsType($id = null)
    {
        $arr = array(
            '1' => 'LiveStream',
            '2' => 'Quảng cáo',
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * 02/08/2016 by doanpv
     * @param null $id
     * @return array|string
     */
    public static function getAccountType($id = null)
    {
        $arr = array(
            'fb' => 'FaceBook',
            'gp' => 'Google+',
            'mb' => 'Mobile',
            'tw' => 'Twister',
            'hf' => 'HelloFriend',
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }
    public static function checkAvatar($avatar = "/")
    {
        $avatar2=substr($avatar,0,5);
        if($avatar2=="https"){
            return $avatar;
        }
        else{
            $avatar=base_url().$avatar;
            return $avatar;
        }
    }

    /**
     * 02/08/2016 by doanpv
     * @param null $id
     * @return array|string
     */
    public static function getAccountTypeIcon($id = null)
    {
        $arr = array(
            'fb' => '<i class="fa fa-facebook-square" aria-hidden="true" style="font-size: 20px; color: #3b5998"></i>',
            'gp' => '<i class="fa fa-google-plus-square" aria-hidden="true" style="font-size: 20px; color: #db4437"></i>',
            'mb' => '<i class="fa fa-mobile" aria-hidden="true" style="font-size: 20px; color: #00a1de"></i>',
            'tw' => '<i class="fa fa-twitter-square" aria-hidden="true" style="font-size: 20px; color: #1b95e0"></i>',
            'hf' => '<img src="' . base_url() . 'images/favicon.png" style="width: 20px">'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * 02/08/2016 @ hieudd
     * Hàm create link preview
     */
    public static function generate_link_preview($url)
    {
        $graph = OpenGraph::fetch($url);
        $array[] = array();
        if (!empty($graph)) {
            if (preg_match("/youtube|bigidol|nhatkyradio/", $url)) {
                foreach ($graph as $key => $value) {
                    $array[$key] = utf8_decode($value);
                }
            }else{
                foreach ($graph as $key => $value) {
                    $array[$key] = $value;
                }
            }
        }
        return $array;
    }

    // hàm get url từ chuỗi
    public static function get_url($string)
    {
        $urlRegex = "/((https?|ftp)\:\/\/)?([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?([a-z0-9-.]*)\.([a-z]{2,3})(\:[0-9]{2,5})?(\/([a-z0-9+\$_\-~@\(\)\%]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?/i";
        $array = explode(" ", $string);
        foreach ($array as $value) {
            if (preg_match($urlRegex, $value)) {
                $url = $value;
            }
        }
        if (isset($url)) {
            $return = $url;
        } else {
            $return = "";
        }
        return $return;
    }

    /**
     * hàm đổi status nếu có link
     * nếu không có ảnh thêm thẻ <a>
     * nếu có ảnh chuyển url thành ""
     **/
    public static function change_status_preview($status, $haveImg)
    {
        $urlRegex = "/((https?|ftp)\:\/\/)?([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?([a-z0-9-.]*)\.([a-z]{2,3})(\:[0-9]{2,5})?(\/([a-z0-9+\$_\-~@\(\)\%]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?/i";
        $array = explode(" ", $status);
        foreach ($array as $value) {
            if (preg_match($urlRegex, $value)) {
                $url = $value;
            }
        }
        if (isset($url)) {
            $status = str_replace($url, "<a href=$url target='_blank'>" . $url . "</a>", $status);
        }
        return $status;
    }

    /**
     * 02/08/2016 by doanpv
     * @param null $id
     * @return array|string
     */
    public static function getIsActiveStatus($id = null)
    {
        $arr = array(
            '1' => 'Hoạt động',
            '0' => 'Tạm dừng'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * 02/08/2016 by doanpv
     * @param null $id
     * @return array|string
     */
    public static function getIsActiveStatusLabel($id = null)
    {
        $arr = array(
            '1' => '<span class="label label-success">Hoạt động</span>',
            '0' => '<span class="label label-danger">Tạm dừng</span>',
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    public static function getChatRommMessageType()
    {
        $arr = array(
            'gif' => 'gift',
            'text' => 'text'
        );
        return $arr;
    }

    /**
     * Hàm lấy danh sách phương thức thanh toán: bằng vàng (gold) hay bằng kim cương (diamond)
     * Created by: doanpv - 02/08/2017
     * @return array
     */
    public static function getPaymentMethod()
    {
        $arr = array(
            'diamond' => 'Diamond',
            'gold' => 'Gold'
        );
        return $arr;
    }

    public static function getItemsTypeType($id = null)
    {
        $arr = array(
            'asset' => 'Tài sản',
            'item' => 'Vật phẩm',
            'event' => 'Sự kiện'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    public static function getSildeAdsType($id = null)
    {
        $arr = array(
            '1' => 'Link Live Strem',
            '2' => 'Link Quảng cáo'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham kiem tra duong dan anh trong DB
     * Neu co http:// hoac https:// thi lay nguyen duong dan
     * Neu ko co thi ghep them base_url vao
     * 08/08/2016 - doanpv
     * @param $base_url
     * @param $image_path
     * @return string
     */
    public static function getImageSrcFromDB($base_url, $image_path)
    {
        if ($base_url != '' && $image_path != '') {
            if (preg_match("/^(.*)(http:\/\/|https:\/\/)(.*)$/", $image_path)) {
                return $image_path;
            } else {
                return $base_url . $image_path;
            }
        } else {
            return '';
        }
    }

    public static function getThumbImageSrcFromDB($base_url, $image_path)
    {
        if ($base_url != '' && $image_path != '') {
            if (preg_match("/^(.*)(http:\/\/|https:\/\/)(.*)$/", $image_path)) {
                return str_replace('/images/', '/_thumbs/Images/', $image_path);
            } else {
                return $base_url . str_replace('/images/', '/_thumbs/Images/', $image_path);
            }
        } else {
            return '';
        }
    }

    /**
     * 05/08/2016 by hieudd
     * @param
     * @return string
     */
    public static function genPaginationItemLink($itemTypeId, $totalRecord, $pageSize = 10, $pageIndex = 1, $paginationName = 'changePagination')
    {
        $pagination = "";
        if ($pageSize >= 1 && $pageIndex >= 1) {
            $adjacents = "2";
            $prev = $pageIndex - 1;
            $next = $pageIndex + 1;
            $lastpage = ceil($totalRecord / $pageSize);
            $lpm1 = $lastpage - 1;
        } else {
            return $pagination;
        }

        if ($lastpage > 1) {
            $pagination .= "<div class='pagination'>";
            if ($pageIndex > 1) {
                $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($prev) . ");\">&laquo;&nbsp;</a>";
            } else {
                $pagination .= "<span class='disabled'>&laquo;&nbsp;</span>";
            }
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $pageIndex) {
                        $pagination .= "<span class='current'>$counter</span>";
                    } else {
                        $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($counter) . ");\">$counter</a>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($pageIndex < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($counter) . ");\">$counter</a>";
                        }
                    }
                    $pagination .= "...";
                    $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($lpm1) . ");\">$lpm1</a>";
                    $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($lastpage) . ");\">$lastpage</a>";

                } elseif ($lastpage - ($adjacents * 2) > $pageIndex && $pageIndex > ($adjacents * 2)) {
                    $pagination .= "<a onClick=\"" . $paginationName . "'(" . $itemTypeId . ",' 1);\">1</a>";
                    $pagination .= "<a onClick=\"" . $paginationName . "'(" . $itemTypeId . ",' 2);\">2</a>";
                    $pagination .= "...";
                    for ($counter = $pageIndex - $adjacents; $counter <= $pageIndex + $adjacents; $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($counter) . ");\">$counter</a>";
                        }
                    }
                    $pagination .= "..";
                    $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($lpm1) . ");\">$lpm1</a>";
                    $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($lastpage) . ");\">$lastpage</a>";
                } else {
                    $pagination .= "<a onClick=\"" . $paginationName . "'(" . $itemTypeId . ",' 1);\">1</a>";
                    $pagination .= "<a onClick=\"" . $paginationName . "'(" . $itemTypeId . ",' 2);\">2</a>";
                    $pagination .= "..";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $pageIndex) {
                            $pagination .= "<span class='current'>$counter</span>";
                        } else {
                            $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($counter) . ");\">$counter</a>";
                        }
                    }
                }
            }
            if ($pageIndex < $counter - 1) {
                $pagination .= "<a onClick=\"" . $paginationName . "('" . ($itemTypeId) . "', " . ($next) . ");\"> &raquo;</a>";
            } else {
                $pagination .= "<span class='disabled'> &raquo;</span>";
            }
            $pagination .= "</div>";
        }
        return $pagination;
    }

    /**
     * Ham lay ds loai dac quyen
     * 10/08/2016 - doanpv
     * @param null $id
     * @return array|string
     */
    public static function getGuardValuesType($id = null)
    {
        $arr = array(
            'asset' => 'Tài sản',
            'normal' => 'Thông thường'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham lay ds loai log action
     * 10/08/2016 - doanpv
     * @param null $id
     * @return array|string
     */
    public static function getAdminLogActionType($id = null)
    {
        $arr = array(
            'READ' => 'READ',
            'ADDED' => 'ADDED',
            'UPDATED' => 'UPDATED',
            'DELETED' => 'DELETED',
            'CHANGED_IS_ACTIVE' => 'CHANGED_IS_ACTIVE',
            'CHANGED_DELETE' => 'CHANGED_DELETE',
            'CHANGED_PASSWORD' => 'CHANGED_PASSWORD',
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham lay ds ten module
     * 10/08/2016 - doanpv
     * @param null $id
     * @return array|string
     */
    public static function getModuleName($id = null)
    {
        $arr = array(
            'account' => 'Tài khoản',
            'chatSocketIO' => 'Chat',
            'gift' => 'Vật phẩm',
            'home' => 'Trang chủ',
            'resource' => 'Tài nguyên',
            'setting' => 'Hệ thống',
            'slideAds' => 'Slide-Ads',
            'streaming' => 'Streaming',
            'user' => 'Thành viên',
            'news' => 'Tin tức',
            'statistic' => 'Thống kê',
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham lay ten danh muc cha khi truyen id cua cha vao
     * 11/08/2016 - doanpv
     * @param array $listParentsName
     * @param $keyValue
     */
    public static function getParentsName($listParentsName, $keyValue, $resultNull = '')
    {
        if (is_array($listParentsName) && count($listParentsName) > 0 && isset($keyValue) && $keyValue != null && array_key_exists($keyValue, $listParentsName)) {
            /*if ($listParentsName[$keyValue] == '' || $listParentsName[$keyValue] == null) {
                return $resultNull;
            } else {
                return $listParentsName[$keyValue];
            }*/
            return $listParentsName[$keyValue];
        } else {
            if ($resultNull != '') {
                return $resultNull;
            } else {
                return '';
            }
        }
    }

    /**
     * Ham lay ds ten module
     * 10/08/2016 - doanpv
     * @param null $id
     * @return array|string
     */
    public static function getCategoryType($id = null)
    {
        $CI = & get_instance();
        $CI->load->model('Mconfig');
        $parentCategory = $CI->Mconfig->getLookLikeByCode('LS_TOPIC');
        // $arr = array(
        //     'funny' => 'Danh hài',
        //     'love' => 'Đang được yêu thích',
        //     'event' => 'Giọng ca trời phú',
        //     'feature' => 'Nổi bật',
        //     'livestream' => 'Ngàn sao hội tụ',
        //     'hotidol' => 'Trai xinh gái đẹp',
        //     'music' => 'Âm nhạc',
        //     'knowledge' => 'Kiến thức',
        //     'proactive' => 'Năng động',
        //     'suggest' => 'Các show được đề xuất'
        // );
        $arr = array();
        if (!empty($parentCategory)) {
            foreach ($parentCategory as $value) {
                $arr[$value['value']] =  $value['name'];
            }
        }
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham lay ds key va security dang nhap bang facebook gogle
     */
    public static function getKeySecurity($id = null)
    {
        $arr = array(
            /*'key_facebook' => '1620679298198900',
            'security_facebook' => 'f8a8671e6799c87de1af8ebe7165b840',
            'key_google' => '186553560767-1g3re0jjjv66t7l98o0p8dgsll91koq2.apps.googleusercontent.com',
            'security_google' => 'KlkTwvWd6EnN5TfJK2DtUJDS', */
            'key_facebook' => '652757544893599',
            'security_facebook' => 'a3133f896a8c0a5191b6c32875109520',
            'key_google' => '186553560767-cbeb5la28g8k0gq566chn4ohulusi9c4.apps.googleusercontent.com',
            'security_google' => '2pbTo-bmL7MW3E5K3MeQkQWA',
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham dinh dang lai so
     * 15/02/2016 - doanpv
     * @param $num
     * @return string
     */
    public static function getNumberFormat($num)
    {
        $num = intval($num);
        return number_format($num);
    }

    /**
     * Ham lay loai tai lieu cua DV
     * 15/08/2016 - doanpv
     * @param null $id
     * @return array|string
     */
    public static function getDocServiceType($id = null)
    {
        $arr = array(
            '1' => 'Kịch bản DV',
            '2' => 'Hồ sơ đề xuất',
            '3' => 'Tài liệu nghiệm thu',
            '4' => 'Tài liệu pháp lý',
            '5' => 'Loại khác',
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham lay icon cua file dinh kem
     * 15/08/2016 - doanpv
     * @param null $id
     * @return array|string
     */
    public static function getDocServiceTypeIcon($file_path = null)
    {
        $arr = array(
            'rar' => '<i class="fa fa-file-archive-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'zip' => '<i class="fa fa-file-archive-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'xls' => '<i class="fa fa-file-excel-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'lsx' => '<i class="fa fa-file-excel-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'doc' => '<i class="fa fa-file-word-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'ocx' => '<i class="fa fa-file-word-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'ppt' => '<i class="fa fa-file-powerpoint-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'ptx' => '<i class="fa fa-file-powerpoint-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'pdf' => '<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 20px; color: red"></i>',
            'txt' => '<i class="fa fa-file-text" aria-hidden="true" style="font-size: 20px;"></i>',
            'img' => '<i class="fa fa-file-image-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'audio' => '<i class="fa fa-file-audio-o" aria-hidden="true" style="font-size: 20px;"></i>',
            'video' => '<i class="fa fa-file-video-o" aria-hidden="true" style="font-size: 20px;"></i>',
        );
        $ext = 'txt';
        if ($file_path != '') {
            $ext = substr($file_path, strlen($file_path) - 3, strlen($file_path));
            if (in_array($ext, array('png', 'jpg', 'gif'))) {
                $ext = 'img';
            }
            if (in_array($ext, array('mp3', 'wma', 'wav'))) {
                $ext = 'audio';
            }
            if (in_array($ext, array('mp4', 'wmv', 'dat'))) {
                $ext = 'video';
            }
        }

        if (array_key_exists($ext, $arr)) {
            return $arr[$ext];
        } else {
            return '';
        }
    }

    /**
     * Ham lay danh sach kieu du lieu khi tao bien cau hinh
     * 16/08/2016 - doanpv
     * @param null $id
     * @return array|string
     */
    public static function getConfigDataType($id = null)
    {
        $arr = array(
            'String' => 'String',
            'Integer' => 'Integer',
            'Double' => 'Double',
            'Datetime' => 'Datetime'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham lay danh sach loai VOTE
     * 04/08/2016 by doanpv
     * @return array
     */
    public static function getVoteType($id = null)
    {
        $arr = array(
            'view' => 'View',
            'like' => 'Like',
            'follow' => 'Follow'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    public static function checkExitListKey($key = array(), $value = array())
    {
        try {
            if (is_array($key) && is_array($value)) {
                if (count($key) > 0 && count($value) > 0) {
                    $status = true;
                    foreach ($key as $cost) {
                        if (!array_key_exists($cost, $value)) {
                            $status = false;
                            break;
                        }
                    }
                    if ($status == false) return false; else return true;
                } else {
                    return false;
                }
            } else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function convertViewCount($number = null)
    {
        if (!is_int($number)) {
            return "";
        }
        try {
            if ($number > 1000 && $number <= 1000000) {
                $dem = $number / 1000;
                $dem = (int)$dem;
                return $dem . " K";
            } elseif ($number > 1000000 && $number <= 1000000000) {
                $dem = $number / 1000000;
                $dem = (int)$dem;
                return $dem . " M";
            } else {
                return $number;
            }


        } catch (Exception $e) {
            return "";
        }

    }
    /**
     * Ham lay danh sach key blacklist
     * 26/08/2016 by hieudd
     * @return array
     */
    public static function getArrayBlackList(){
        $CI = & get_instance();
        $CI->load->model("Mkeyword_blacklist");
        $keyData = $CI->Mkeyword_blacklist->getAll();
        foreach ($keyData as $value) {
            $listKeyBlack[] = trim($value["name"]); 
        }
        foreach ($listKeyBlack as $value) {
            $arrayBlackKey[mb_strtolower($value, 'UTF-8')] = "***";
        }
        return $arrayBlackKey;
    }

    /**
     * Ham kiem tra duong dan anh trong DB
     * Neu co http:// hoac https:// thi lay nguyen duong dan
     * Neu ko co thi ghep them base_url vao
     * 08/08/2016 - doanpv
     * @param $base_url
     * @param $image_path
     * @return string
     */
    public static function getUserAvatarPath($base_url, $image_path){
        if($base_url != '' && $image_path != ''){
            $image_path2 = str_replace(base_url(), '', $image_path);
            $image_path2 = str_replace('/upload', 'upload', $image_path2);
            $image_path2 = str_replace('/public', 'public', $image_path2);
            //
            $image_path2 = FCPATH.$image_path2;
            if(! file_exists($image_path2)){
                return base_url('upload/avatar/user.jpg');
            }else{
                if(preg_match("/^(.*)(http:\/\/|https:\/\/)(.*)$/", $image_path)){
                    return $image_path;
                }else{
                    return base_url($image_path);
                }
            }
        }else{
            return null;
        }
    }
    /**
     * convert 1000 to 1k
     * 12/9/2016 by hieudd
     * @return string
     */
    public static function number_format_short( $n, $precision = 1 ) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }

    /**
     * json decode ajax
     * 4/10/2016 by hieudd
     * @return json
     */ 
    public static function json_ajax($data){
        header("Content-type: application/json; charset=utf-8");
        die(json_encode($data));
    }

    /**
     * Ham lay danh sach loai su kien cua tin tuc
     * 11/10/2016 by doanpv
     * @return array
     */
    public static function getNewsEventType($id = null)
    {
        $arr = array(
            'normal' => 'Normal',
            'hot' => 'Hot'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Ham convert sdt tu 0 sang 84
     * 11/10/2016 by hieudd 
    */
    public static function convertMobileSaveDB($phoneNumber){
        if (preg_match("/^0/", $phoneNumber)) {
            $phoneNumber = substr($phoneNumber, 1);
            $phoneNumber = "84".$phoneNumber;
        }
        return $phoneNumber;
    }

    /**
     * Ham convert sdt tu 84 sang 0
     * 11/10/2016 by hieudd 
    */
    public static function convertMobileToDisplay($phoneNumber){
        if (preg_match("/^84/", $phoneNumber)) {
            $phoneNumber = substr($phoneNumber, 2);
            $phoneNumber = "0".$phoneNumber;
        }
        return $phoneNumber;
    }

    /**
     * simple dectect mobile device
     * 14/10/2016 by hieudd 
    */
    public static function detectMobileDevice(){
        $useragent=$_SERVER['HTTP_USER_AGENT'];

        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
            return true;
        }else{
            return false;
        }

    }

    /**
     * Hàm check avatar facebook, google
     * by hieudd 
    **/
    public static function checkAvatarFG($avatar){
        if (preg_match("/http/", $avatar)) {
            return str_replace('http://', 'https://', $avatar);
        }else{
            return base_url().$avatar;
        }
    }
    /**
     * Ham lay type cua tin tuc
     * @param null $id
     * @return array|string
     */
    public static function getNewTopicType($id = null)
    {
        $arr = array(
            'event' => 'event',
            'news' => 'news',
            'ads' => 'ads'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }
    /**
     * Ham lay ten topic category
     * @param null $id
     * @return array|string
     */
    public static function getTopicCategoryName($name){
        switch ($name) {
            case 'music':
                $topicName = "Âm nhạc";
                break;
            case 'knowledge':
                $topicName = "Kiến thức";
                break;
            case 'proactive':
                $topicName = "Năng động";
                break;
            
            default:
                $topicName = '';
                break;
        }
        return $topicName;
    }

    public static function getListTelco()
    {
        $lstTelco = array(
            'viettel' => 'Viettel',
            'mobifone' => 'MobiFone',
            'vinaphone' => 'Vinaphone',
            'gate' => 'Gate',
            'vcoin' => 'Vcoin',
            'zing' => 'Zing',
            'bit' => 'Bit',
            'vnmobile' => 'Vietnam Mobile'
        );
        return $lstTelco;
    }

    public static function getListTelcoSMSPlus()
    {
        $lstTelco = array(
            'viettel' => 'Viettel',
            'mobifone' => 'MobiFone',
            'vinaphone' => 'Vinaphone',
            'vnmobile' => 'Vietnam Mobile'
        );
        return $lstTelco;
    }

    public static function responseJson($data){
        header("Content-type: application/json; charset=utf-8");
        die(json_encode($data));
    }
    // Ham tra ve so KC qui doi khi nap xu qua the cao
    public static function getDiamondByCardCharging($telco, $amount)
    {
        $CI = & get_instance();
        $CI->load->model('MConfig');
        $diamond = 0;
        switch (intval($amount)){
            case 10000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_10K_VNP', 136);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_10K', 136);
                }
                break;
            }
            case 20000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_20K_VNP', 274);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_20K', 274);
                }
                break;
            }
            case 50000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_50K_VNP', 688);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_50K', 688);
                }
                break;
            }
            case 100000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_100K_VNP', 1382);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_100K', 1382);
                }
                break;
            }
            case 200000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_200K_VNP', 2772);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_200K', 2772);
                }
                break;
            }
            case 300000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_300K_VNP', 4164);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_300K', 4164);
                }
                break;
            }
            case 500000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_500K_VNP', 6948);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_CARD_CHARGING_500K', 6948);
                }
                break;
            }
            default:{
                $diamond = 0;
            }
        }
        return $diamond;
    }
    // Ham tra ve so KC qui doi khi nap xu qua sms  vina
    public static function getDiamondBySmsVinaCharging($telco, $amount)
    {
        $CI = & get_instance();
        $CI->load->model('MConfig');
        $diamond = 0;
        switch (intval($amount)){
            case 2000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_2K_VNP', 20);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_2K', 20);
                }
                break;
            }
            case 5000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_6K_VNP', 60);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_6K', 60);
                }
                break;
            }
            case 10000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_10K_VNP', 140);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_10K', 140);
                }
                break;
            }
            case 15000:{
                if($telco == 'vinaphone'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_20K_VNP', 200);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_VINA_CHARGING_20K', 200);
                }
                break;
            }
            default:{
            $diamond = 0;
            }
        }
        return $diamond;
    }

    // Ham tra ve so KC qui doi khi nap xu qua sms 1 pay
    public static function getDiamondBySms1PayCharging($telco, $amount)
    {
        $CI = & get_instance();
        $CI->load->model('MConfig');
        $diamond = 0;
        switch (intval($amount)){
            case 1000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_1K_VNP', 10);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_1K', 10);
                }
                break;
            }
            case 2000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_2K_VNP', 20);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_2K', 20);
                }
                break;
            }
            case 3000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_3K_VNP', 30);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_3K', 30);
                }
                break;
            }
            case 4000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_4K_VNP', 40);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_4K', 40);
                }
                break;
            }
            case 5000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_5K_VNP', 60);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_5K', 60);
                }
                break;
            }
            case 10000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_10K_VNP', 160);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_10K', 160);
                }
                break;
            }
            case 15000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_15K_VNP', 220);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_15K', 220);
                }
                break;
            }
            case 20000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_20K_VNP', 330);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_20K', 330);
                }
                break;
            }
            case 30000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_30K_VNP', 440);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_30K', 440);
                }
                break;
            }
            case 50000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_50K_VNP', 650);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_50K', 650);
                }
                break;
            }
            case 100000:{
                if($telco == '1pay'){
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_100K_VNP', 1300);
                }else{
                    $diamond = $CI->MConfig->getValueByCode('EXCHANGE_RATE_SMS_1PAY_CHARGING_100K', 1300);
                }
                break;
            }
            default:{
            $diamond = 0;
            }
        }
        return $diamond;
    }

    /* Check IP */
    public static function ipValidator($ip, $range)
    {
        $exIp = explode(".", $ip);

        if ($exIp[0] == "10") {
            return "F5";
        } elseif ($exIp[0] == "113" && $exIp[1] == "185" && $exIp[2] != "0") {
            $exRange = explode(".", $range);

            if ($exIp[2] != $exRange && in_array($exIp[2], array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39"))) {
                $range = $exRange[0] . "." . $exRange[1] . "." . $exIp[2] . "." . $exRange[3];
            }

            if (strpos($range, '/') == false) {
                $range .= '/32';
            }

            list($range, $netmask) = explode('/', $range, 2);

            $range_decimal = ip2long($range);
            $ip_decimal = ip2long($ip);
            $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
            $netmask_decimal = ~$wildcard_decimal;

            $result = (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
            if (isset($result) && $result == true) {
                return "F5";
            } else {
                return "UNKNOW";
            }
        } else {
            return "UNKNOW";
        }
    }

    public static function mobileValidator($mobile)
    {
        if (preg_match('/^(84|0|)(91|94|123|124|125|127|129|88)\d{7}$/', $mobile)) {
            return true;
        }

        return false;
    }

    /**
     * Hàm xử lý login 3G khi user truy cập từ mobile có đk 3G -------------------------------------------------------
     * Created by: hieudd - dd/mm/yyyy
     * Updated by: doanpv - 29/09/2017
     * Lý do update: tối ưu quản lý tập trung thông tin IDOL bằng class model. Khi update trường dữ liệu thì chỉ cần
     * ... update ở class core.
     * File class: htdocs\bigidol_v2\application\libraries\models\User.php
     * @param $mobile
     * @param $loginBy
     */
    public static function login3G($mobile, $loginBy){
        $CI = & get_instance();
        $CI->load->model('Muser');
        $CI->load->model('Muser_log');
        $mobile = self::convertMobileSaveDB($mobile);
        $check = $CI->Muser->checkLogin($mobile, 'mb');
        if ($check) {
            // Thiett lap session
            $sessionData = array(
                'id' => $check[0]['_id']->{'$id'},
                'fullname' => $check[0]['fullname'],
                'email' => $check[0]['email'],
                'username' => $check[0]['username'],
                'avatar' => MyHelper::checkAvatar($check[0]['avatar']),
                'room_id' => time(),
                'nameSlug' => $check[0]['nameSlug']
            );
            $sessionData['time_login'] = date('Y-m-d H:i:s');
            $CI->Muser_log->add('LOGIN/LOGOUT', $check[0]['username'], 'SUCCESS');
            $CI->session->set_userdata($sessionData);
            $CI->Muser->update_status_user_1($CI->session->userdata('id'));
            $update = array(
                'login_by' => $loginBy,
                'room_id' => $sessionData['room_id'],
                'updated_at' => date('Y-m-d H:i:s')
                );
            $CI->Muser->update($check[0]['_id']->{'$id'}, $update);
            $CI->load->model('Muser_login');
            $insertOnline = array(
                'user_id' => $check[0]['_id']->{'$id'},
                'time_login' => date('Y-m-d H:i:s'),
                'last_request' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
                );
            $CI->Muser_login->add($insertOnline);
            // if ($check[0]['account_type'] == 'mb' && (empty($check[0]['date_gif_receive']) || date('Ymd') != date('Ymd', strtotime($check[0]['date_gif_receive'])))) {
            //     $CI->load->model('Mstore_user');
            //     $checkUser = $CI->Mstore_user->getByUserId($check[0]['_id']->{'$id'});
            //     if (!empty($checkUser)) {
            //         $numberDiamond = $checkUser[0]['total_diamond'];
            //         $numberDiamond = $numberDiamond + 50;
            //         $updateStore = array(
            //             'total_diamond' => (int)$numberDiamond,
            //             'updated_at' => date('Y-m-d H:i:s')
            //             );
            //         $CI->Mstore_user->update($checkUser[0]['_id']->{'$id'}, $updateStore);
            //     }else{
            //         $numberDiamond = 50;
            //         $dataStore = array(
            //             'user_id' => $check[0]['_id']->{'$id'},
            //             'total_diamond' => $numberDiamond,
            //             'total_gold' => 0,
            //             'total_money' => 0,
            //             'created_at' => date('Y-m-d H:i:s'),
            //             'updated_at' => date('Y-m-d H:i:s'),
            //             );
            //         $CI->Mstore_user->add($dataStore);
            //     }
            //     $updateUser = array(
            //         'date_gif_receive' => date("Y-m-d H:i:s", time()),
            //         'updated_at' => date("Y-m-d H:i:s", time())
            //         );
            //     $CI->load->model('Muser');
            //     $CI->Muser->update($check[0]['_id']->{'$id'}, $updateUser);
            // }
        }else{
            $CI->load->model('Muser_log_sms_code');
            $avatar = "upload/avatar/user.jpg";
            $a = $CI->Muser_log_sms_code->getTheMostSmsCode();
            if($a){
                $sms_log = $a + 2;
            }else {
                $sms_log = 0;
            }
            //
            $user = new SchemaUser();
            $user->setUsername($mobile);
            $user->setFullname(self::convertMobileToDisplay($mobile));
            $user->setMobile($mobile);
            $user->setIsActive(1);
            $user->setAvatar($avatar);
            $user->setAccountType('mb');
            $user->setIsOnline(1);
            $user->setIsHot(0);
            $user->setIsHighlight(0);
            $user->setVipStatus(0);
            $user->setGuardStatus(1);
            $user->setVipGif(0);
            $user->setNewUserGif(0);
            $user->setViewNumber(0);
            $user->setLikeNumber(0);
            $user->setFollowNumber(0);
            $user->setShareNumber(0);
            $user->setIsBan(0);
            $user->setIsVipSub(0);
            $user->setTotalLiveTime(0);
            $user->setTotalCharging(0);
            $user->setLevel(1);
            $user->setUptoLevelPercentage(0);
            $user->setLoginBy($loginBy);
            $user->setSmsCode($sms_log);
            $user->setIsFindMe('on');
            //
            $user->add();
            //
            /*$dataInsert = array(
                //'username' => $mobile,
                'password' => null,
                //'fullname' => self::convertMobileToDisplay($mobile),
                //'address' => null,
                //'email' => null,
                //'mobile' => $mobile,
                //'birthday' => null,
                //'sex' => null,
                //'register_date' => date("Y-m-d H:i:s", time()),
                //'age' => 0,
                //'is_active' => 1,
                //'avatar' => $avatar,
                //'image_cover_path' => 'public/frontend/img/cover1.png',
                //'account_type' => 'mb',
                'createtime_block' => null,
                'endtime_block' => null,
                //'is_online' => 1,
                //'is_hot' => 0,
                //'is_highlight' => 0,
                //'vip_status' => 0,
                'vip_package_expried' => null,
                //'guard_status' => 1,
                'guard_package_expried'=> null,
                'vehicle' => null,
                //'vip_gif' => 0,
                'date_gif_receive' => array(
                    'vip' => null,
                    'normal' => null
                    ),
                'number_gif_receive' => array(
                    'vip' => 0,
                    'normal' => 0
                    ),
                //'new_user_gif' => 0,
                //'view_number' => 0,
                //'like_number' => 0,
                //'follow_number' => 0,
                //'share_number' => 0,
                //'is_ban' => 0,
                'banned_at' => null,
                'banned_by' => null,
                //'is_vip_sub' => 0,
                //'total_live_time' => 0,
                //'total_charging' => 0,
                //'level' => 1,
                //'upto_level_percentage' => 0,
                //'login_by' => $loginBy,
                //'created_at' => date("Y-m-d H:i:s", time()),
                //'updated_at' => date("Y-m-d H:i:s", time()),
                //'sms_code' => $sms_log,
                //'nameSlug'=>$nameSlug,
                'room_id' => $time,
                'indentifier' => null,
                'date_issue' => null,
                'place_issue' => null,
                'is_find_me' => 'on',
                'last_livestream' => array(
                    'room_id' => 0,
                    'topic' => null,
                    'category_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'time_live' => 0,
                    'is_live' => 0
                ),
                'passport_updated_at' => null
            );*/
            //$CI->Muser->add($dataInsert);

            $checkLogin = $CI->Muser->checkLogin($mobile, 'mb');
            if(!empty($checkLogin)){
                $sessionData = array(
                    'id' => $checkLogin[0]['_id']->{'$id'},
                    'fullname' => $checkLogin[0]['fullname'],
                    'email' => $checkLogin[0]['email'],
                    'username' => $checkLogin[0]['username'],
                    'avatar' => base_url().$checkLogin[0]['avatar'],
                    'room_id' => time(),
                );
                $sessionData['time_login'] = date('Y-m-d H:i:s');
                //$CI->session->set_userdata($sessionData);
            }
            if (!empty($checkLogin) && $checkLogin[0]['account_type'] == 'mb' && (empty($checkLogin[0]['date_gif_receive']) || date('Ymd') != date('Ymd', strtotime($checkLogin[0]['date_gif_receive'])))) {
                $CI->load->model('Mstore_user');
                $checkUser = $CI->Mstore_user->getByUserId($checkLogin[0]['_id']->{'$id'});
                if (!empty($checkUser)) {
                    $numberDiamond = $checkUser[0]['total_diamond'];
                    $numberDiamond = $numberDiamond + 50;
                    $updateStore = array(
                        'total_diamond' => (int)$numberDiamond,
                        'updated_at' => date('Y-m-d H:i:s')
                        );
                    $CI->Mstore_user->update($checkUser[0]['_id']->{'$id'}, $updateStore);
                }else{
                    $numberDiamond = 50;
                    $dataStore = array(
                        'user_id' => $checkLogin[0]['_id']->{'$id'},
                        'total_diamond' => $numberDiamond,
                        'total_gold' => 0,
                        'total_money' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        );
                    $CI->Mstore_user->add($dataStore);
                }
            }
        }
    }

    /**
     * Hàm tạo link hủy đăng ký dịch vụ
     * @return string
     */
    public static function renderLinkUnRegister(){
        $link = 'http://bigidol.vn';

        $requestid = date('YmdHis');
        $requestdatetime = date('YmdHis');
        $returnurl = $link;
        $backurl = $link;
        $cp = "CP_DCV";
        $service = "BIGIDOL";
        $channel = "wap";
        $package = 'NGAY';
        $securepass = "DCV@30112016";
        $params = $requestid . $returnurl . $backurl . $cp . $service . $package . $requestdatetime . $channel . $securepass;

        $securecode = md5($params);

        $link = 'http://dk1.vinaphone.com.vn/unreg.jsp?requestid=' . $requestid . '&returnurl=' . $returnurl . '&backurl=' . $backurl . '&cp=' . $cp . '&service=' . $service . '&package=' . $package . '&requestdatetime=' . $requestdatetime . '&channel=' . $channel . '&securecode=' . $securecode;

        try{
            //$created_at = date('Y-m-d H:i:s');
            //error_log("\n".$created_at."\n".'Log UnRegister Params '.$params."\n".' Securecode: '.$securecode."\n".'Render => Link: '.$link."\n\n", 3, "/var/www/html/bigidolv2/log/link-".date("Ymd").".log");
        }catch (Exception $e){
            //
        }

        return $link;
    }

    /**
     * Hàm tạo link đăng ký dịch vụ
     * @return string
     */
    public static function renderLinkRegister(){
        $link = 'http://bigidol.vn';

        $requestid = date('YmdHis');
        $requestdatetime = date('YmdHis');
        $returnurl = $link;
        $backurl = $link;
        $cp = "CP_DCV";
        $service = "BIGIDOL";
        $channel = "wap";
        $package = 'NGAY';
        $securepass = "DCV@30112016";
        $params = $requestid . $returnurl . $backurl . $cp . $service . $package . $requestdatetime . $channel . $securepass;

        $securecode = md5($params);

        $link = 'http://dk1.vinaphone.com.vn/reg.jsp?requestid=' . $requestid . '&returnurl=' . $returnurl . '&backurl=' . $backurl . '&cp=' . $cp . '&service=' . $service . '&package=' . $package . '&requestdatetime=' . $requestdatetime . '&channel=' . $channel . '&securecode=' . $securecode;

        try{
            //$created_at = date('Y-m-d H:i:s');
            //error_log("\n".$created_at."\n".'Log Register Params '.$params."\n".' Securecode: '.$securecode."\n".'Render => Link: '.$link."\n\n", 3, "/var/www/html/bigidolv2/log/link-".date("Ymd").".log");
        }catch (Exception $e){
            //
        }

        return $link;
      }

    public static function getSubInfo($tel){
        return true;
        // $CI = & get_instance();
        // $CI->load->model('Mcore_api');
        // $data = $CI->Mcore_api->getByMsisdn($tel);
        // if (!empty($data)) {
        //     if ($data[0]["reg_YTE"] == null || $data[0]["unreg_YTE"] >= $data[0]["reg_YTE"]) {
        //         return false;
        //     }else{
        //         return true;
        //     }
        // }else{
        //     return false;
        // }
    }

    public static function checkDate($date){
        $temp = time() - strtotime($date);
        if(0 == $temp){
            $text = 'Vừa xong';
        }elseif (0 < $temp && $temp < 60) {
            $text = $temp.' giây trước';
        }elseif(60 <= $temp && $temp < 3600){
            $text = floor($temp/60).' phút trước';
        }elseif(3600 <= $temp && $temp < 86400){
            $text = floor($temp/3600).' giờ trước';
        }elseif(86400 <= $temp && $temp < 604800){
            $text = floor($temp/86400).' ngày trước';
        }elseif(604800 <= $temp && $temp < 2592000){
            $text = floor($temp/604800).' tuần trước';
        }elseif(2592000 <= $temp && $temp < 31104000){
            $text = floor($temp/2592000).' tháng trước';
        }else{
            $text = floor($temp/31104000).' năm trước';
        }
        return $text;
    }

    public static function getItemTypeName($itemType){
        switch ($itemType) {
            case 'gold':
                $name = "Vàng";
                break;
            case 'item':
                $name = "Vật phẩm";
                break;
            case 'vip':
                $name = "Gói vip";
                break;
            case 'guard':
                $name = "Gói bảo hộ";
                break;
            default:
                $name = "";
                break;
        }
        return $name;
    }

    public static function checkAdminLogin(){
        $CI =& get_instance();
        if(! $CI->session->userdata('admin_id')){
            redirect(base_url().'index.php/backend/account/login');
        }
    }

    public static function getListTypeDayMission(){
        $list = array(
            'LIVE_STREAM' => 'Stream nhận quà',
            'ONLINE' => 'Online nhận quà',
            'GIVE_GIF' => 'Tặng quà',
            'SHARE' => 'Chia sẻ',
            'FOLLOW' => 'Theo dõi thành công',
            'BUY' => 'Sử dụng kim cương',
            'ALL' => 'Nhiệm vụ chung'
            );
        return $list;
    }

    public static function checkCsrf($csrf){
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $origin = $_SERVER['HTTP_REFERER'];
        } else {
            $origin = $_SERVER['REMOTE_ADDR'];
        }
        $CI =& get_instance();
        $csrf_server = $CI->security->get_csrf_hash();
        if ($csrf != $csrf_server || $origin != 'http://localhost') {
            redirect(base_url(),'refresh');
            die();
        }
    }

    // put firebase
    public static function putFirebase($fields){
        $headers = array(
            'Authorization: key=' . self::FIREBASE_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
    }

    /**
     * Hàm lấy ds các tỉnh/TP -----------------------------------------------------------------------------------------
     * Created by: doanpv - 19/07/2017
     * Updated by: xxx
     * Usage: khi đăng ký tài khoản và update thông tin cá nhân
     * @param null $id
     * @return string
     */
    public static function getListProvince($id=null)
    {
        $data['89']= 'An Giang';
        $data['77']= 'Bà Rịa - Vũng Tàu';
        $data['24']= 'Bắc Giang';
        $data['06']= 'Bắc Kạn';
        $data['95']= 'Bạc Liêu';
        $data['27']= 'Bắc Ninh';
        $data['83']= 'Bến Tre';
        $data['52']= 'Bình Định';
        $data['74']= 'Bình Dương';
        $data['70']= 'Bình Phước';
        $data['60']= 'Bình Thuận';
        $data['96']= 'Cà Mau';
        $data['04']= 'Cao Bằng';
        $data['66']= 'Đắk Lắk';
        $data['67']= 'Đắk Nông';
        $data['11']= 'Điện Biên';
        $data['75']= 'Đồng Nai';
        $data['87']= 'Đồng Tháp';
        $data['64']= 'Gia Lai';
        $data['02']= 'Hà Giang';
        $data['35']= 'Hà Nam';
        $data['42']= 'Hà Tĩnh';
        $data['30']= 'Hải Dương';
        $data['93']= 'Hậu Giang';
        $data['17']= 'Hoà Bình';
        $data['33']= 'Hưng Yên';
        $data['56']= 'Khánh Hòa';
        $data['91']= 'Kiên Giang';
        $data['62']= 'Kon Tum';
        $data['12']= 'Lai Châu';
        $data['68']= 'Lâm Đồng';
        $data['20']= 'Lạng Sơn';
        $data['10']= 'Lào Cai';
        $data['80']= 'Long An';
        $data['36']= 'Nam Định';
        $data['40']= 'Nghệ An';
        $data['37']= 'Ninh Bình';
        $data['58']= 'Ninh Thuận';
        $data['25']= 'Phú Thọ';
        $data['54']= 'Phú Yên';
        $data['44']= 'Quảng Bình';
        $data['49']= 'Quảng Nam';
        $data['51']= 'Quảng Ngãi';
        $data['22']= 'Quảng Ninh';
        $data['45']= 'Quảng Trị';
        $data['94']= 'Sóc Trăng';
        $data['14']= 'Sơn La';
        $data['72']= 'Tây Ninh';
        $data['34']= 'Thái Bình';
        $data['19']= 'Thái Nguyên';
        $data['38']= 'Thanh Hóa';
        $data['46']= 'Thừa Thiên Huế';
        $data['82']= 'Tiền Giang';
        $data['92']= 'TP Cần Thơ';
        $data['48']= 'TP Đà Nẵng';
        $data['01']= 'TP Hà Nội';
        $data['31']= 'TP Hải Phòng';
        $data['79']= 'TP Hồ Chí Minh';
        $data['84']= 'Trà Vinh';
        $data['08']= 'Tuyên Quang';
        $data['86']= 'Vĩnh Long';
        $data['26']= 'Vĩnh Phúc';
        $data['15']= 'Yên Bái';
        //
        if ($id != null) {
            if (array_key_exists($id, $data)) {
                return $data[$id];
            } else {
                return '';
            }
        } else {
            return $data;
        }
    }

    /**
     * Hàm lấy tên domain, nếu gặp lỗi, trả về mặc định bigidol.vn ----------------------------------------------------
     * Created by: doanpv - 02/08/2017
     * Updated by: xxx
     * @return string
     */
    public static function getDomain()
    {
        if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != ''){
            return $_SERVER['SERVER_NAME'];
        }else{
            return 'bigidol.vn';
        }
    }

    /**
     * Hàm lấy base url dựa vào domain --------------------------------------------------------------------------------
     * Created by: doanpv - 02/08/2017
     * Updated by: xxx
     * @return string
     */
    public static function getBaseUrl($suffix=null){
        if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != ''){
            return 'http://'.$_SERVER['SERVER_NAME'].'/';
        }else{
            return 'http://bigidol.vn/';
        }
    }

    /**
     * Hàm lấy ngôn ngữ tương ứng với domain --------------------------------------------------------------------------
     * Created by: doanpv - 02/08/2017
     * Updated by: xxx
     * @param $key
     * @return string
     */
    public static function t($key, $desc=null)
    {
        $CI = & get_instance();
        if($CI->lang->line($key) != ''){
            return $CI->lang->line($key);
        }else{
            return '-?-';
        }
    }

    public static function tVal($key, $desc=null)
    {
        $CI = & get_instance();
        if($CI->lang->line($key) != ''){
            return $CI->lang->line($key);
        }else{
            return '-?-';
        }
    }

     public static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function checkRemoteFile($url){
        if (@getimagesize($url)) {
            return true;
        }else{
            return false;
        }
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$url);
        // // don't download content
        // curl_setopt($ch, CURLOPT_NOBODY, 1);
        // curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // if(curl_exec($ch)!==FALSE){
        //     return true;
        // }
        // else{
        //     return false;
        // }
    }

    public static function getLinkTv($path){
        $ch = curl_init();

        // Set query data here with the URL
        curl_setopt($ch, CURLOPT_URL, $path . time()); 

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $link = trim(curl_exec($ch));
        curl_close($ch);
        return $link;
    }

    /**
     * Hàm convert định dạng png->jpg
     * Created by: hieudd - ?
     * Updated by: doanpv - 27/09/2017
     * @param $originalImage
     * @param $outputImage
     * @param $quality
     */
    public static function convertImage($originalImage, $outputImage, $quality)
    {
        //$ext = mime_content_type($originalImage);
        $ext = get_mime_by_extension($originalImage);
        if (preg_match('/png/i', $ext)) {
            $imageTmp = imagecreatefrompng($originalImage);
            $bg = imagecreatetruecolor(imagesx($imageTmp), imagesy($imageTmp));
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
            imagealphablending($bg, TRUE);
            imagecopy($bg, $imageTmp, 0, 0, 0, 0, imagesx($imageTmp), imagesy($imageTmp));
            imagedestroy($imageTmp);
            imagejpeg($bg, $outputImage, $quality);
            imagedestroy($bg);
        }
    }

    /**
     * Ham lay gioi tinh
     * Created by: xxx
     * Updated by: doanpv - 03/10/2017
     * Các giá trị của nớ: male (giới tính Nam), female (Giới tính nữ), private (Giới tính bí mật)
     * Hàm này nếu ko truyền tham số ID thì sẽ trả về mảng, nếu có ID thì sẽ trả về giá trị tương ứng
     * @param null $id
     * @return array|string
     */
    public static function getSex($id = null)
    {
        $arr = array(
            'male' => 'male',
            'female' => 'female',
            'private' => 'private'
        );
        if ($id != null) {
            if (array_key_exists($id, $arr)) {
                return $arr[$id];
            } else {
                return '';
            }
        } else {
            return $arr;
        }
    }

    /**
     * Hàm kiểm tra trong 1 controller có được gán ít nhất 1 action nào không
     * Created by: doanpv - 03/10/2017
     * Updated by: xxx
     * Nếu là super admin thì luôn full quyền, chỉ kiểm tra khác quyền super admin
     * Nếu gán thì được hiển thị menu
     * Nếu không gán thì sẽ ẩn controller đi
     * Giải thuật:
     * B1: Từ controller name -> controller id -> list action -> ds action của hệ thống
     * B2: Duyệt list action được gán nếu có trong cái của hệ thống thì đánh dấu là có/true quyền
     * Ngược lại, ko có quyền
     * @param $controller_name
     * @param $array_action
     * @return bool
     */
    public static function checkAssignAction($controller_name, $array_action)
    {
        $CI = & get_instance();
        $CI->load->model('Mcontroller');
        $CI->load->model('Maction');
        // Lấy thông tin controller
        $controller = $CI->Mcontroller->checkExistedByName($controller_name);
        $result = false;
        // Nếu không phải là super admin
        if($CI->session->userdata('admin_is_super') != 1){
            if(isset($controller[0]) && is_array($array_action)){
                $controller_id = $controller[0]['_id']->{'$id'};
                // Lấy ds action trong hệ thống
                $list_action = $CI->Maction->getByArrControllerId(array($controller_id));
                $list = array();
                if(count($list_action) > 0){
                    foreach($list_action as $val){
                        $list[] = $val['name'];
                    }
                }
                // Duyệt mảng action được gán và so sánh với mảng action của hệ thống
                foreach($array_action as $val){
                    if(in_array($val, $list)){
                        $result = true;
                        break;
                    }
                }
            }
        }else{
            $result = true;
        }
        return $result;
    }

    /**
     * Hàm kiểm tra hiển thị submenu trong CMS khi phân quyền
     * Created by: doanpv - 03/10/2017
     * Không kiểm tra với super admin
     * @param $action_name
     * @param $array_action
     * @return bool
     */
    public static function showCmsSubMenu($action_name, $array_action)
    {
        $CI = & get_instance();
        $result = false;
        // Nếu không phải là super admin
        if($CI->session->userdata('admin_is_super') != 1){
            if(is_array($array_action) && in_array($action_name, $array_action)){
                $result = true;
            }
        }else{
            $result = true;
        }
        return $result;
    }

    public static function checkText($text){
        if (!empty($text)) {
            $arrayBlackKey = MyHelper::getArrayBlackList();
            foreach ($arrayBlackKey as $key => $value) {
                $listBlackKey[] = '/\b' . preg_quote($key, '/') . '\b/ui' ;
                $listRemoveKey[] = $value;
            }
            $message = preg_replace($listBlackKey, $listRemoveKey, $text);
            $text = trim($message);
        }
        return $text;
    }

    public static function getListTvChannel(){
        $CI = & get_instance();
        $CI->load->model('Mconfig');
        $array = $CI->Mconfig->getListLiveTVByCodeLike('TV_');
        return $array;
    }

    //Kiem tra truyen thieu tham so
    public static function validateNullParams($arrayParams)
    {
        foreach ($arrayParams as $key => $values) {
            $values = trim($values);
            if (!$values || $values == '' || $values == null || empty($values)) {
                return $key;
            }
        }
        return false;
    }

    //Tra ve gia tri khi muon tra ve api
    public static function responseApi($arrResult)
    {
        header('Content-Type: application/json');
        if (is_array($arrResult) && count($arrResult) >= 4) {
            echo json_encode($arrResult);
        } else {
            $data['urlApi'] = isset($arrResult['urlApi']) ? $arrResult['urlApi'] : base_url() . 'api.php/api/?';
            $data['errorCode'] = 4;
            $data['message'] = 'Co loi tu du lieu tra ve. Ban vui long, thu lai sau!';
            $data['data'] = null;
            echo json_encode($data);
        }
        die();
    }

    /**
     * Hàm lưu dữ liệu wap_his cho vas
     * @param $data
     */
    public static function saveWapHis($data)
    {
        $CI = & get_instance();
        $CI->load->model('Mwap_his');
        $CI->Mwap_his->add($data);
    }

}
/* End */
