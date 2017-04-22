<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.each demo</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>

	<form enctype="multipart/form-data" method="post" name="fileinfo">
	  <label>Your email address:</label>
	  <input type="email" autocomplete="on" autofocus name="userid" placeholder="email" required size="32" maxlength="64" /><br />
	  <label>Custom file label:</label>
	  <input type="text" name="filelabel" size="12" maxlength="32" /><br />
	  <label>File to stash:</label>
	 
	 
	  <input type="submit" value="Stash the file!" />
	</form>
	<div></div>
 <input type="file" id="input">
	<script>
		var form = document.forms.namedItem("fileinfo");
		var formData = new FormData(form);
		var selectedFile = document.getElementById('input').files[0];
		formData.append('userpic', selectedFile);
		formData.append("CustomField", "This is some extra data");

		var oReq = new XMLHttpRequest();
		oReq.onload = function(oEvent) {
		    if (oReq.status == 200) {
		      console.log(oEvent);
		    } else {
		      oOutput.innerHTML = "Error " + oReq.status + " occurred when trying to upload your file.<br \/>";
		    }
		};
		oReq.open("POST", "main.php", true);
		oReq.send(formData);

	</script>  
</body>
</html>