<?php

    /**
     * @method      Bootstrap Alert Message
     * @access      public
     * @author      Bablu <bablu@atilimited.net>
     * @return      Alert Message
     */
    function alert_message($type = '', $msg = '', $msg_prefix = '')
    {
        $alert = '';

        if($type == 'success' and $msg)
        {
            $alert = '<div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Success!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else if($type == 'info' and $msg)
        {
            $alert = '<div class="alert alert-info alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Info!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else if($type == 'warning' and $msg)
        {
            $alert = '<div class="alert alert-warning alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Warning!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else if($type == 'danger' and $msg)
        {
            $alert = '<div class="alert alert-danger alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Error!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else
        {
            $alert = '<div class="alert alert-info alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>Alert!</strong> The Alert Type & Text Message are required.</p>
                      </div>';
        }

        return $alert;
    }



//Call it

echo $this->alert_message('success','Unit Wise Sanction Inserted Successfully'); /*$type = '', $msg = '', $msg_prefix = '' ie. Alert, Success*/



