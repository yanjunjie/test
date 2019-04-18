<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class People_model extends CI_Model
{
    protected $table       = 'peoples'; // you MUST mention the table name
    protected $primary_key = 'id'; // you MUST mention the primary key
    public function get_all($limit, $page)
    {    	
        $offset = ($page - 1) * $limit;
        $query  = $this->db->limit($limit, $offset)->get($this->table);
        return $query->result();
    }
    public function get_total()
    {
        return $this->db->count_all($this->table);
    }
}