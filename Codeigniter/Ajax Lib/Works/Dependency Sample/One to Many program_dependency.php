<option value="" selected disabled>-Select-</option>
<?php foreach($result as $ky=>$row2) {?>
    <option value="<?php echo $row2->PROGRAM_ID; ?>" <?php echo  set_select("PROGRAM_ID", "$row2->PROGRAM_ID"); ?> ><?php echo $row2->PROGRAM_NAME; ?></option>
<?php } ?>