/*
Author: Md. Bablu Mia
Copyright: Copyright all rights reserved, 2018
Version: v.1.0
Description: This plugin is made for Ajax CRUD operation for Frameworks i.e, Codeigniter, Laravel etc.
Website: w3public.com
*/


$(document).ready(function(){
	$(document).on('click','.submit',function(e){
		e.preventDefault();
		e.stopPropagation();
		var thisBtn = $(this);
        var thisForm = $(this).closest("form");
        var formData = new FormData($(thisForm)[0]);
		var formAction = $(thisForm).attr("action")?$(thisForm).attr("action"):thisBtn.attr("data-action");		
        var actionParam = thisBtn.attr("data-param")?thisBtn.attr("data-param"):formAction.substr(formAction.lastIndexOf('/') + 1);
		var pattern =/\d+/;
		var isNumberTheParam = pattern.test(actionParam); //true
        actionParam=isNumberTheParam?actionParam:''; //Param must be number or number+character i.e, 1,2,3... or foo3bar5
        var baseUrl = window.location.origin;

		$.ajax({
            type: "POST",
            data: formData,
            url: formAction+'/'+actionParam,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".loadingImg").html("");
            },
            success: function (data) {
				if($.trim(data)=="yes")
				{
					alert('Success!');
					$("#create_view").load(location.href + " #create_view");
				}
				else
				{
					alert('Error! Please try again');
				}
            }
        });

	});

});
