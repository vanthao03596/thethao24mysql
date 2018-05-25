<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/05/2016
 * Time: 3:08 CH
 */

class MAdmin extends MY_Model {

    public function __construct(){
        parent::__construct();
        $this->setCollection('admin');
    }

    /**
     * Ham kiem tra dang nhap - login
     * @param $email
     * @param $password
     * @return mixed
     */
    public function checkLogin($email, $password){
        $this->db->where(array(
            'email' => $email,
            'password' => $password,
            'is_active' => 1,
            'type' => 'dcv'
        ));
        $this->db->limit(1);
        return $this->db->get($this->getCollection());
    }

    /**
     * Ham kiem tra login cua Partner
     * doanpv - 15/12/2016
     * @param $email
     * @param $password
     * @return mixed
     */
    public function checkLoginPartner($email, $password){
        $this->db->where(array(
            'email' => $email,
            'password' => $password,
            'is_active' => 1,
            'type' => 'partner'
        ));
        $this->db->limit(1);
        return $this->db->get($this->getCollection());
    }

    /**
     * Kiem tra xem da co super admin mac dinh chua. Neu chua co thi add.
     * @param $username
     * @return mixed
     */
    public function checkSuperAdmin($username){
        $this->db->where(array(
            'username' => $username
        ));
        $this->db->limit(1);
        return $this->db->get($this->getCollection());
    }

    //Lay du lieu de hien thi khi co khoa ngoai (user_id)
    public function getListUsernameAndId($is_active=false){
        $this->db->select(array('_id', 'username', 'fullname'));
        if($is_active == true){
            $this->db->where(array('is_active' => 1));
        }
        $this->db->order_by('username', 'ASC');
        $arr = $this->db->get($this->getCollection())->result_array();
        $list = array();
        if(count($arr) > 0){
            foreach($arr as $val){
                $list[$val['_id']] = $val['username'];
            }
        }
        return $list;
    }

    //Kiem tra su ton tai cua ten
    public function checkExistedByField($field, $value, $admin_id=null){
        $this->db->where(array($field => $value));
        if($admin_id != null){
            $this->db->where_not_in('_id', array(new MongoId($admin_id)));
        }
        return $this->db->get($this->getCollection());
    }

    //Phan trang CMS
    public function adminCountAll($filterByUserName=null, $filterByIsActive=null)
    {
        if($filterByUserName != null){
            $this->db->like('username', $filterByUserName,'both');
            $this->db->like('email', $filterByUserName,'both');
        }
        if($filterByIsActive != null){
            $this->db->where('is_active', $filterByIsActive);
        }
        return $this->db->count_all_results($this->getCollection());
    }

    public function adminGetPagination($filterByUserName=null, $filterByIsActive=null, $limit, $offset)
    {
        if($filterByUserName != null){
            $this->db->like('username', $filterByUserName,'both');
            $this->db->like('email', $filterByUserName,'both');
        }
        if($filterByIsActive != null){
            $this->db->where('is_active', $filterByIsActive);
        }
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get($this->getCollection())->result_array();
    }//Phan trang CMS

    public function countIsActive(){
        $this->db->where(array('is_active' => 1));
        return $this->db->count_all_results($this->getCollection());
    }


}
