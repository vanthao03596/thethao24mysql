<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/05/2016
 * Time: 3:08 CH
 */

class MAdminLog extends CI_Model {
    protected $_collection;

    public function __construct(){
        parent::__construct();
        $this->_collection = 'admin_log';
    }

    public function add($action, $account_input, $result, $type='BE'){
        $dataInsert = array(
            'action' => $action,
            'time_login' => date('Y-m-d H:i:s'),
            'account_input' => $account_input,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'type' => $type,
            'result' => $result,
            'time_logout' => null,
            'duration' => null
        );
        return $this->mongo_db->insert($this->_collection, $dataInsert);
    }

    public function update($tlogLoginId){
        $time_logout = date('Y-m-d H:i:s');
        $duration = (int)(strtotime($time_logout) - strtotime($this->session->userdata('admin_time_login')));
        $dataUpdate = array(
            'time_logout' => $time_logout,
            'duration' => $duration
        );
        $this->mongo_db->where(array(
            '_id' => new MongoId($tlogLoginId)
        ));
        $this->mongo_db->set($dataUpdate);
        $this->mongo_db->update($this->_collection);
    }

    //Delete
    public function delete($id){
        $this->mongo_db->where(array('_id' => new MongoId($id)));
        return $this->mongo_db->delete($this->_collection);
    }

    public function getAll(){
        $users = $this->mongo_db->get($this->_collection);
        return $users;
    }

    //Phan trang
    public function countAll($email=null, $filterByAction=null){
        if($email != null){
            $this->mongo_db->where(array(
                'account_input' => new MongoRegex("/.*$email.*/i")
            ));
        }
        if($filterByAction != null){
            $this->mongo_db->where(array(
                'action' => $filterByAction
            ));
        }
        return $this->mongo_db->count($this->_collection);
    }

    public function getPagination($email, $filterByAction=null, $limit, $offset){
        if($email != null){
            $this->mongo_db->where(array(
                'account_input' => new MongoRegex("/.*$email.*/i")
            ));
        }
        if($filterByAction != null){
            $this->mongo_db->where(array(
                'action' => $filterByAction
            ));
        }
        $this->mongo_db->order_by(array('time_login' => 'DESC'));
        $this->mongo_db->limit($limit);
        $this->mongo_db->offset($offset);
        return $this->mongo_db->get($this->_collection);
    }

} 