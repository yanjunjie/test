<?php
  $conn = mysqli_connect("localhost", "root", '', "test");
?>
<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
<h2 style="text-align:center">Employee Information</h2>

<table>

  <tr>
    <th>Employee Name</th>
    <th>E-mail</th>
  </tr>
  <?php
    $sql = "select * from test_table";
    $result = $conn->query($sql);

    foreach( $result as $data ){
      echo "<tr data-id='".$data['id']."'>
              <td data-field-name='full_name' data-value='".$data['full_name']."'>".$data['full_name']."</td>
              <td data-field-name='email' data-value='".$data['email']."'>".$data['email']."</td>
            </tr>";
    }
  ?>
  
</table>

<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  
  
	<script type="text/javascript">
		var table = $("table");
		table.find("td").click(function(){
			var td = $(this);
			
			if($(this).find("input").val()){
				//tdValue = $("td input").val();
			}else{
				tdValue = td.attr("data-value");
				td.html('<input class="test" type="text" value="'+tdValue+'"/>');
				$(this).find("input").focus();
			}
		});
		
		table.find("td").focusout(function(){
			var td = $(this);
			
			if($(this).find("input").val()){
				tdValue = $(this).find("input").val();
				td.attr("data-value", tdValue);
				td.html(tdValue);
			}

      var formData = {
          "field_name":td.attr("data-field-name"),
          "value":tdValue,
          "id": td.closest("tr").attr("data-id")
      }

      $.ajax({
        data:formData,
        url:"<?php echo 'update_data.php'; ?>",
        type: 'POST',
        success:function(result){

        }
      });

		});

	  
	</script>
</body>
</html>
