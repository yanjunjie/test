<?php
//Pagination
    public function get_all($limit, $page)
    {       
        $offset = ($page - 1) * $limit;
        $query  = $this->db->limit($limit, $offset)->get(self::$landlord);
        return $query->result();
    }

    public function get_total()
    {
        return $this->db->count_all(self::$landlord);
    }
    //End pagination

    //Search pagination data
    public function search_publicityM($search_publicity)
    {
        $this->db->select('*');
        $this->db->from('landloard');
        $this->db->like('lnd_email', $search_publicity);
        $query = $this->db->get();
        return $query->result();
    }
