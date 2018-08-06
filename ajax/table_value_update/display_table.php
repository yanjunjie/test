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
    <th>Company</th>
    <th>Contact</th>
    <th>Country</th>
  </tr>
  <tr>
    <td data-value="Futterkiste" data-default="Futterkiste">Alfreds Futterkiste</td>
    <td data-value="Maria Anders">Maria Anders</td>
    <td data-value="Germany">Germany</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
  <tr>
    <td>Ernst Handel</td>
    <td>Roland Mendel</td>
    <td>Austria</td>
  </tr>
  <tr>
    <td>Island Trading</td>
    <td>Helen Bennett</td>
    <td>UK</td>
  </tr>
  <tr>
    <td>Laughing Bacchus Winecellars</td>
    <td>Yoshi Tannamuri</td>
    <td>Canada</td>
  </tr>
  <tr>
    <td>Magazzini Alimentari Riuniti</td>
    <td>Giovanni Rovelli</td>
    <td>Italy</td>
  </tr>
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
		});

    $.ajax({
      data:formData;
      url:formurl;
      type:post;
      success:function(result){

      }
    });
	  
	</script>
</body>
</html>
