<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MNewsTopic extends MY_Model {

	public function __construct(){
        parent::__construct();
        $this->setCollection('news_topic');
    }


    /**
     * @param null $name
     *
     * @return mixed
     */
    public function countALl($name=null){
        if($name != null){
            $this->db->like('name', $name);
        }
        return $this->db->count_all_results($this->collection);
    }

    //Kiem tra su ton tai cua ten
    public function checkExistedByName($name, $cat_id=null){
        $this->db->where(array('name' => $name));
        if($cat_id != null){
            $this->db->where_not_in('_id', $cat_id);
        }
        return $this->db->get($this->collection);
    }

    public function adminGetPagination($name, $limit, $offset){
        if($name != null){
            $this->db->like('name', $name);
        }
        $this->db->order_by('name', 'ASC');
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get($this->collection)->result_array();
    }//Phan trang
    //Lay du lieu vào SelectBox khi tim kiem, add, edit
    public function getListForSelectBox($is_active=false){
        $this->db->select(array('_id', 'name'));
        if($is_active == true){
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('name', 'ASC');
        $arr = $this->db->get($this->collection)->result_array();
        $list = array();
        if(count($arr) > 0){
            foreach($arr as $val){
                $list[$val['_id']] = $val['name'];
            }
        }
        return $list;
    }

     public function getListItemNameAndId($is_active=false){
        $this->db->select(array('_id', 'name'));
        if($is_active == true){
            $this->db->where(array('is_active' => 1));
        }
        $this->db->order_by('name', 'ASC');
        $arr = $this->db->get($this->collection)->result_array();
        $list = array();
        if(count($arr) > 0){
            foreach($arr as $val){
                $list[$val['_id']] = $val['name'];
            }
        }
        return $list;
    }
}

/* End of file MNewsTopic.php */
/* Location: ./application/models/MNewsTopic.php */
 ?>
