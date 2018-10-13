$(document).ready(function(){
	$('#submit').click(function(){
		//formData = $("#rform").serializeArray();
		var formData = new FormData($('#rform')[0]);
		var formAction = $("#rform").attr("action");

		$.ajax({
            type: "POST",
            data: formData,
            url: formAction,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".loadingImg").html("");
            },
            success: function (data) {
                //$("#success").html(data);
				//$("#success").fadeIn(); 
				//$("#success").fadeOut(2800); 
				//$("input").val('');
				if($.trim(data)=="yes")
				{
					alert('Success!');
				}
				else
				{
					alert('Error!');
				}
				$("#create_view").load(location.href + " #create_view");
            }
        });
				
		$("#rform").submit(function(){
			return false;
		});
	});

});
