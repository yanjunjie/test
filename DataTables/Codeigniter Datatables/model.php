<?php

 //Datatables
    private function _get_datatables_query($table)
    {

        //Searchable columns
        $column = array('FULL_NAME_ENG','APPLICATION_ID', 'MERIT_POSITION');
        $order = array('MERIT_POSITION' => 'desc');

        $this->db->from($table);

        $i = 0;
        foreach ($column as $item)
        {
            if(!empty($_POST['search']['value']))
            {
                ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            }

            $column[$i] = $item;
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($table)
    {
        $this->_get_datatables_query($table);

        if(!empty($_POST['length']))
        {
            if($_POST['length'] != -1)
            {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
        }

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($table)
    {
        $this->_get_datatables_query($table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($table)
    {
        $this->db->from($table);
        return $this->db->count_all_results();
    }
    //End Datatables

