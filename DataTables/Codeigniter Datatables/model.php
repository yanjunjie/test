<?php

//v.01

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


    //v.02

     ############## DATA TABLR ################
      function allposts_count()
    {
        $query = $this
                ->db
                ->get('aca_course');

        return $query->num_rows();

    }

    function allCourse($limit,$start,$col,$dir)
    {
       /*$query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('aca_course');*/
                /*
        $query=$this->db->query("SELECT a.*,b.DEPT_NAME FROM aca_course a
                                    left join ins_dept b on a.DEPT_ID=b.DEPT_ID ORDER BY a.$col $dir LIMIT $start,$limit")->result();
                                    */
        $query=$this->db->query("SELECT * FROM (SELECT ROWNUM  RN ,a.*,b.DEPT_NAME FROM aca_course a left join ins_dept b on a.DEPT_ID=b.DEPT_ID ORDER BY a.COURSE_ID) k WHERE RN BETWEEN $start and $limit")->result();


        if(!empty($query))
        {
            return $query;
        }
        else
        {
            return null;
        }

    }

    function posts_search($limit,$start,$search,$col,$dir)
    {
    //  echo $col;
        $query=$this->db->query("SELECT * FROM (SELECT ROWNUM RN,a.*,b.DEPT_NAME FROM aca_course a
                                    left join ins_dept b on a.DEPT_ID=b.DEPT_ID
                                    where
                                        a.COURSE_TITLE like '%$search%' or
                                         b.DEPT_NAME like '%$search%'
                                    ORDER BY a.$col $dir) k WHERE RN BETWEEN $start and $limit");


        if(!empty($query))
        {
            return [$query->result(),$query->num_rows()];
        }
        else
        {
            return null;
        }
    }
    ################# END DATA TABLE #########################

    

