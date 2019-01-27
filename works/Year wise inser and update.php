<?php

// insert............................................
// insert status
        $success = 0;

        $sailorInfo = $this->db->query("SELECT SAILORID FROM sailor WHERE SAILORID = '$sailorID' AND OFFICIALNUMBER = '$officNumber' AND SAILORSTATUS = 1")->row('SAILORID');
        if ($sailorInfo) {
            $exist = $this->db->query("select * from jesthatapadaktran where SailorID = $sailorID and JesthataPadakID = $JESHTATA_PADAK_NAME ")->row('JesthataPadakID');
            if(!$exist) {
                $totalEntryDayes = $this->db->query("SELECT DATEDIFF('$awardDate',ENTRYDATE) totalEntryDayes FROM sailor WHERE SAILORID = $sailorID")->row('totalEntryDayes');

                // first check eligible or not
                if($totalEntryDayes >= 3650) {
                    $jesthataPadakExists = $this->db->query("select JesthataPadakID, count(*) total_padak from jesthatapadaktran where SailorID = $sailorID and JesthataPadakID in (select JestotaMedal_ID from bn_jesthatapadak)")->row();

                    //die(var_dump($jesthataPadakExists));
                    // awarded any padak or not
                    if($jesthataPadakExists->total_padak > 0) {
                        $totalLastAwardDayes = $this->db->query("SELECT DATEDIFF('$awardDate',jt.AwardDate) totalLastAwardDayes
                                                                FROM sailor s
                                                                LEFT JOIN jesthatapadaktran jt on jt.SailorID = s.SAILORID
                                                                WHERE jt.SailorID = $sailorID
                                                                ORDER BY JesthataPadakTranID DESC LIMIT 1")->row('totalLastAwardDayes');
                        // save second padak
                        if($totalLastAwardDayes >= 3650 && $jesthataPadakExists->total_padak == 1) {
                            $success = 1;
                            //$this->utilities->insertDataB($jesthatran,'jesthatapadaktran'); # Inserting data
                        }
                        // save third padak
                        else if($totalLastAwardDayes >= 2555 && $jesthataPadakExists->total_padak == 2) {
                            $success = 1;
                            //$this->utilities->insertDataB($jesthatran,'jesthatapadaktran'); # Inserting data
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p><strong>Alert! </strong> This Sailor Is Not Eligible For The Award</p>
                            </div>';
                        }
                    } else {
                        // save first padak
                        if ($JESHTATA_PADAK_NAME == 1) {
                            $success = 1;
                            //$this->utilities->insertDataB($jesthatran, 'jesthatapadaktran'); # Inserting data
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p><strong>Alert! </strong> Please Select Jesthata Padak-I </p>
                            </div>';
                        }
                    }

                } else {
                    echo '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>Alert! </strong> This Sailor\'s From Joining Date To Till Now Less Than 10 Years</p>
                    </div>';
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>Alert! </strong> This Sailor Already Awarded The Award</p>
                    </div>';
            }

            if($success == 1)
            {
                $this->db->trans_start(); # Starting Transaction
                $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well
                $this->utilities->insertDataB($jesthatran, 'jesthatapadaktran'); # Inserting data
                $this->db->trans_complete(); # Completing transaction

                /* Optional */
                if ($this->db->trans_status() === FALSE) {
                    # Something went wrong.
                    $this->db->trans_rollback();
                    echo '<div class="alert alert-danger alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <p><strong>Success!</strong> Jesthata Padak Information Insert Failed</p>
                          </div>';
                } else {
                    # Everything is Perfect.
                    # Committing data to the database.
                    $this->db->trans_commit();
                    if ($success) {
                        echo '<div class="alert alert-success alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <p><strong>Success!</strong> Jesthata Padak Information Inserted Successfully</p>
                          </div>';
                    }
                }
            }

        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p><strong>Alert! </strong> There Is No Valid Sailor Info</p>
                </div>';
        }


// Update .............................................

$success = 0;
        $update = 0;
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well

        $sailorInfo = $this->db->query("SELECT SAILORID FROM sailor WHERE SAILORID = '$sailorID' AND SAILORSTATUS = 1")->row('SAILORID');
        if ($sailorInfo)
        {
            $exist = $this->db->query("select * from jesthatapadaktran where SailorID = $sailorID and JesthataPadakID = $JESHTATA_PADAK_NAME and JesthataPadakTranID != $id")->row();
            if(!$exist)
            {
                $totalDayes = $this->db->query("SELECT DATEDIFF('$awardDate',ENTRYDATE) totalJoiningDayes FROM sailor WHERE SAILORID = $sailorID")->row('totalJoiningDayes');

                if($JESHTATA_PADAK_NAME == 1)
                {
                    $joiningDayes = $this->db->query("SELECT DATEDIFF('$awardDate',ENTRYDATE) totalLastAwardDayes
                                    FROM sailor
                                    WHERE SAILORID = $sailorID")->row('totalLastAwardDayes');

                    if(!($joiningDayes >= 3650))
                    {
                        echo '<div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p><strong>Alert! </strong> This Sailor\'s From Joining Date To This Award Date Less Than 10 Years</p>
                            </div>';
                    }
                    else
                    {
                        $update = 1;
                    }
                }
                else if ($JESHTATA_PADAK_NAME == 2)
                {
                    $totalLastAwardDayes = $this->db->query("SELECT DATEDIFF('$awardDate',jt.AwardDate) totalLastAwardDayes
                                    FROM sailor s
                                    LEFT JOIN jesthatapadaktran jt on jt.SailorID = s.SAILORID
                                    WHERE jt.SailorID = $sailorID and jt.JesthataPadakID = 1")->row('totalLastAwardDayes');

                    if(!($totalLastAwardDayes >= 3650))
                    {
                        echo '<div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p><strong>Alert! </strong> This Sailor\'s From Last Award Date To This Award Date Less Than 10 Years</p>
                            </div>';
                    }
                    else
                    {
                        $update = 1;
                    }
                }
                else if ($JESHTATA_PADAK_NAME == 3)
                {
                    $totalLastAwardDayes = $this->db->query("SELECT DATEDIFF('$awardDate',jt.AwardDate) totalLastAwardDayes
                                    FROM sailor s
                                    LEFT JOIN jesthatapadaktran jt on jt.SailorID = s.SAILORID
                                    WHERE jt.SailorID = $sailorID and jt.JesthataPadakID = 2")->row('totalLastAwardDayes');

                    if(!($totalLastAwardDayes >= 2555))
                    {
                        echo '<div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p><strong>Alert! </strong> This Sailor\'s From Last Award Date To This Award Date Less Than 7 Years</p>
                            </div>';
                    }
                    else
                    {
                        $update = 1;
                    }
                }
                else
                {
                    $update = 0;
                }

                // update data
                if($update)
                {
                    $this->utilities->updateDataBablu('jesthatapadaktran', $jesthatran, array('JesthataPadakTranID' => $id));
                    $success = 1;
                }

            }
            else
            {
                echo '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>Alert! </strong> This Sailor Already Awarded The Award</p>
                    </div>';
            }

            $this->db->trans_complete(); # Completing transaction

            /* Optional */
            if ($this->db->trans_status() === FALSE) {
                # Something went wrong.
                $this->db->trans_rollback();
                echo '<div class="alert alert-danger alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <p><strong>Success!</strong> Jesthata Padak Information Update Failed</p>
                          </div>';
            } else {
                # Everything is Perfect.
                # Committing data to the database.
                $this->db->trans_commit();
                if ($success) {
                    echo '<div class="alert alert-success alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <p><strong>Success!</strong> Jesthata Padak Information Updated Successfully</p>
                          </div>';
                }
            }
        }
        else
        {
            echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p><strong>Alert! </strong> There Is No Valid Sailor Info</p>
                </div>';
        }


