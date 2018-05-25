<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Model
 * @property Mapi $Mapi
 */
class MY_Model extends CI_Model
{
    protected $collection;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        //
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * Hàm thực hiện insert 1 bản ghi vào DB
     * @param $array_data_insert
     * @return null
     */
    public function add($array_data_insert)
    {
        if ($this->collection != '') {
            if (is_array($array_data_insert) && count($array_data_insert) > 0) {
                return $this->db->insert($this->collection, $array_data_insert);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Hàm thực hiện update thông tin 1 bản ghi trong DB
     * @param $id
     * @param $array_data_update
     * @return bool
     */
    public function update($id, $array_data_update)
    {
        if ($this->collection != '') {
            if (is_array($array_data_update) && count($array_data_update) > 0 && $id != '') {
                try {
                    $this->db->where(array('_id' => $id));
                    $this->db->set($array_data_update);
                    return $this->db->update($this->collection);
                } catch (Exception $e) {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Hàm thực hiện xóa 1 bản ghi trogn DB
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        if ($this->collection != '') {
            if ($id != '') {
                try {
                    $this->db->where(array('_id' => $id));
                    return $this->db->delete($this->collection);
                } catch (Exception $e) {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Hàm thực hiện tìm kiếm bản ghi theo ID của nó
     * @param $id
     * @param bool|true $is_active
     * @return array
     */
    public function getById($id, $is_active = false)
    {
        if ($this->collection != '') {
            if ($id != '') {
                try {
                    $this->db->where(array('_id' => $id));
                    if ($is_active == true) {
                        $this->db->where(array('is_active' => 1));
                    }
                    $this->db->limit(1);
                    return $this->db->get($this->collection)->result_array();
                } catch (Exception $e) {
                    return array();
                }
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * Hàm đếm số lượng tất cả bản ghi
     * @param bool|true $is_active
     * @return mixed
     */
    public function getCountAll($is_active = true)
    {
        if ($is_active) {
            $this->db->where(array('is_active' => 1));
        }
        return $this->db->count($this->getCollection());
    }

    /**
     * Hàm lấy toàn bộ bản ghi trong collection
     * @return mixed
     */
    public function getAll()
    {
        return $this->db->get($this->getCollection());
    }

}
