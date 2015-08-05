$(document).ready(
	function(){
        $('[data-toggle="tooltip"]').tooltip();
		$(".sub-usrtb").hover(function(){
            $(this).animate({borderTopWidth : "10px" ,
                             backgroundColor : "#4dc941" ,
                            }, 200);
        },function(){
            $(this).animate({borderTopWidth : "0px" ,
                             backgroundColor : "#0c7769",
                            }, 200);
        });
	}
);
