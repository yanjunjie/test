//html:
<div class="table-responsive">
	<table id="member-add-table" class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th>???? ??</th>
			<th>???</th>
			<th>???</th>
			<th>????</th>
			<th colspan="2">?????? ?????</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>1</td>
			<td><input type="text" name="family_member_name[]" required="required"></td>
			<td><input type="text" name="family_member_age[]" required="required"></td>
			<td><input type="text" name="family_member_job[]" required="required"></td>
			<td colspan="2"><input type="text" name="family_member_phone[]" required="required"></td>
		</tr>
		</tbody>
	</table>
	<button type="button" id="addMember" class="btn btn-primary pull-right">????? ????? ????</button>
</div>

//Js:
	//Add Member/dynamically form field add
    var count = 1;
    $('#addMember').click(function(){
      //alert('hi');
      count = count + 1;
      var html_code = "<tr id='row"+count+"'>";
      html_code +="<td>"+count+"</td>";
      html_code +='<td><input type="text" name="family_member_name[]" required="required"></td>';
      html_code +='<td><input type="text" name="family_member_age[]" required="required"></td>';
      html_code +='<td><input type="text" name="family_member_job[]" required="required"></td>';
      html_code +='<td><input type="text" name="family_member_phone[]" required="required"></td>';
      html_code +='<td><button type="button" data-row="row'+count+'" class="btn btn-danger btn-xs remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>';
      html_code +='</tr>';
      $('#member-add-table').append(html_code);
    });

    $(document).on('click', '.remove', function(){
      var delete_row = $(this).data("row");
      $('#' + delete_row).remove();
    });
    
//Codeigniter Model:
	public function save_renterFM_data($renterFMData){
        for($i = 0; $i < count($renterFMData['family_member_name']); $i++)
            $batch[] = array(   "renter_id" =>$renterFMData['renter_id'],
                                "family_member_name" => $renterFMData['family_member_name'][$i],
                                "family_member_age" => $renterFMData['family_member_age'][$i],
                                "family_member_job" => $renterFMData['family_member_job'][$i],
                                "family_member_phone" => $renterFMData['family_member_phone'][$i]
                            );

        return $this->db->insert_batch(self::$renter_familymember, $batch);
    }

	

	
	
	