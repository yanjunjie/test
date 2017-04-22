<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.each demo</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
<div id="test"></div>
<script>
    $.ajax({
        type: 'POST',
        url: 'main.php',
        data: { param: 'value' },
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        success: function (data) {
           if(data){
               $.each(data, function(index, obj) {

                    $("#test").append(obj.id+" ");
                    //data and obj twice are groups
               });
           }else{
               console.log("Log: We connected to the server but it returned an error");
           }
        },
        error: function(){
            console.log("Log: Server Connection Error");
        }
    });
</script>
 
</body>
</html>