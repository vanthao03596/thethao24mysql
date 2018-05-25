<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/05/2016
 * Time: 3:08 CH
 */

class MAdminLogAction extends MY_Model {
    protected $_collection;

    public function __construct(){
        parent::__construct();
        $this->setCollection('admin_log_action');
    }

    public function add($module=null, $action=null, $description=null, $info_before=null, $info_after=null, $model=null, $collection=null, $record_id=null, $zone='BE'){
        $dataInsert = array(
            'actor_id' => ($this->session->userdata('admin_id')) ? $this->session->userdata('admin_id') : '',
            'actor_name' => ($this->session->userdata('admin_email')) ? $this->session->userdata('admin_email') : '',
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'info_before' => $info_before,
            'info_after' => $info_after,
            'model' => $model,
            'collection' => $collection,
            'record_id' => $record_id,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'zone' => $zone,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->mongo_db->insert($this->getCollection(), $dataInsert);
    }

    //Phan trang
    public function countAll($email=null, $filterByAction=null, $filterByModule=null){
        if($email != null){
            $this->mongo_db->where(array(
                'actor_name' => new MongoRegex("/.*$email.*/i")
            ));
        }
        if($filterByAction != null){
            $this->mongo_db->where(array('action' => $filterByAction));
        }
        if($filterByModule != null){
            $this->mongo_db->where(array('module' => $filterByModule));
        }
        return $this->mongo_db->count($this->getCollection());
    }

    public function getPagination($email, $filterByAction=null, $filterByModule=null, $limit, $offset){
        if($email != null){
            $this->mongo_db->where(array(
                'actor_name' => new MongoRegex("/.*$email.*/i")
            ));
        }
        if($filterByAction != null){
            $this->mongo_db->where(array('action' => $filterByAction));
        }
        if($filterByModule != null){
            $this->mongo_db->where(array('module' => $filterByModule));
        }
        $this->mongo_db->order_by(array('created_at' => 'DESC'));
        $this->mongo_db->limit($limit);
        $this->mongo_db->offset($offset);
        return $this->mongo_db->get($this->getCollection());
    }

} 