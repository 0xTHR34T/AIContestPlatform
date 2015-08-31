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

		$(".sub-usrtb2").hover(function(){
						$(this).animate({borderTopWidth : "10px" ,
														 backgroundColor : "#db9539" ,
														}, 200);
				},function(){
						$(this).animate({borderTopWidth : "0px" ,
														 backgroundColor : "#a57a3a",
														}, 200);
				});

		$(".dropdown a").click(function(){
			$(".dropdown button").html(this.innerHTML + "&nbsp;<span class = 'caret'></span>");
		});

	}
);
