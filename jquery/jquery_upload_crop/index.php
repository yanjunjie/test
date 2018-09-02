<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Image Crop</title>
	<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />
</head>
<body>
	
	<img src="http://jotform.org/demo/jquery-image-area-select-plugin/images/sweet-dogs.jpg" id="ladybug_ant">


  <script type="text/javascript" src="scripts/jquery.min.js"></script>
  <script type="text/javascript" src="scripts/jquery.imgareaselect.pack.js"></script>
  <script>
  	$('#ladybug_ant').imgAreaSelect({
	    handles: true,
	    onSelectEnd: function (img, selection) {
	        if (!selection.width || !selection.height) {
	            return;
	        }
	        $('#x1').val(selection.x1);
	        $('#y1').val(selection.y1);
	        $('#x2').val(selection.x2);
	        $('#y2').val(selection.y2);
	        $('#w').val(selection.width);
	        $('#h').val(selection.height);
	    },
	    //Default selection
	    x1: 120, y1: 90, x2: 280, y2: 210,
	    

	});
  </script>
</body>
</html>