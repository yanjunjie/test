$(document).ready(function(){
	$('#submit').click(function(){
		x=$("#rform").serializeArray();
		$.post($("#rform").attr("action"),x,function(data){
			$("#success").html(data);
			//$("#success").fadeIn(); 
			//$("#success").fadeOut(2800); 
			$("input").val('');
		});
				
		$("#rform").submit(function(){
			return false;
		});
	});

});
