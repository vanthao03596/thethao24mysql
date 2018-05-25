<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MNews extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setCollection('news');
	}

	public function adminCountAll($topic_id=null, $title=null, $filterByType=null)
	{
		if ($topic_id != null) {
			$this->db->where('topic_id', $topic_id);
		}
		if ($filterByType != null) {
			$this->db->where('type', $filterByType);
		}
		if ($title != null) {
			$this->db->like('title', $title);
		}
		return $this->db->count_all_results($this->collection);
	}

	public function adminGetPagination($topic_id=null, $title, $filterByType=null, $limit, $offset)
	{
		if ($topic_id != null) {
			$this->db->where(['topic_id' => $topic_id]);
		}
		if ($filterByType != null) {
			$this->db->where(['type' => $filterByType]);
		}
		if ($title != null) {
			$this->db->like('title', $title);
		}
		$this->db->order_by('title', 'ASC');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get($this->collection)->result_array();
	}//Phan trang

	public function getByIdCMS($id)
	{
		try {
			$this->db->where('_id', $id);
			$this->db->limit(1);
			return $this->db->get($this->collection)->result_array();
		} catch (Exception $e) {
			return [];
		}
	}

	public function getByTopicIdLimit($id, $is_active = false, $limit=null)
	{
		$this->db->where('topic_id', $id);
		if ($is_active == true) {
			$this->db->where('is_active', 1);
		}
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get($this->collection)->result_array();
	}

	public function getNewsBySkip($id, $skip, $is_active = false, $limit)
	{
		$this->db->where('topic_id', $id);
		if ($is_active == true) {
			$this->db->where('is_active', 1);
		}
		if (!empty($skip)) {
			$this->db->offset($skip);
		}
		$this->db->limit($limit);
		return $this->db->get($this->collection)->result_array();
	}

	public function getByTitle($keyword, $skip, $is_active = false, $limit)
	{
		if ($keyword != null) {
            $this->db->like('title', $keyword);
		}
		if ($is_active == true) {
			$this->db->where('is_active', 1);
		}
		if (!empty($skip)) {
			$this->db->offset($skip);
		}
		$this->db->limit($limit);
		return $this->db->get($this->collection)->result_array();
	}
	public function getBySlug($slug)
	{
		$this->db->where(array(
			'slug' => $slug
		));
		return $this->db->get($this->collection)->result_array();
	}

	public function getByTopicId($topic_id, $id)
	{

		$this->db->where_not_in('_id', $id);
		$this->db->where(array(
			'topic_id' => $topic_id
		));
		return $this->db->get($this->collection)->result_array();
	}

	public function insertMany($data)
	{
		return $this->db->insert_batch($this->collection, $data);
	}
}

/* End of file MNews.php */
/* Location: ./application/models/MNews.php */
