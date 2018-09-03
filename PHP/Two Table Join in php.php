//v.01

$master_tbl = $this->utilities->findById('NM_APPLICATION','ACTIVE_FLAG','N');
$child_tbl = $this->utilities->findAll('NM_QUOTA');

$new_tble = array();

foreach ($master_tbl as $key=>$master_tbl_row) {
        $row = array(); //Row creation
        $row[] = $master_tbl_row->FULL_NAME_ENG;
        $row[] = $master_tbl_row->APPLICATION_ID;
        $row[] = $master_tbl_row->MERIT_POSITION;

        foreach ($child_tbl as $child_tbl_row)
        {
            if ($master_tbl_row->QUOTA_ID == $child_tbl_row->QUOTA_ID) {
                $row[] = $child_tbl_row->QUOTA_NAME;
                break;
            }
        }

    $new_tble[] = $row;
}


//v.02 with key [incomplete]

$master_tbl = $this->utilities->findById('NM_APPLICATION','ACTIVE_FLAG','N');
        $child_tbl = $this->utilities->findAll('NM_QUOTA');

        $new_tble = array();
        //die(var_dump($master_tbl));
        $i = 0;
        foreach ($master_tbl as $key=>$master_tbl_row) {
                $master_tbl_row_arr =  (array) $master_tbl_row; //if obj convert to array
                $keys = array_keys($master_tbl_row_arr);

                $row = array(); //Row creation
                $row[] = $master_tbl_row->FULL_NAME_ENG;
                $row[] = $master_tbl_row->APPLICATION_ID;
                $row[] = $master_tbl_row->MERIT_POSITION;

                foreach ($child_tbl as $child_tbl_row)
                {
                    if ($master_tbl_row->QUOTA_ID == $child_tbl_row->QUOTA_ID) {
                        $row[] = $child_tbl_row->QUOTA_NAME;
                        break;
                    }
                }

            $new_tble[] = $row;
            $i++;
        }

        die(var_dump($new_tble));
        $data['merit_list'] = $new_tble;


//v.03



