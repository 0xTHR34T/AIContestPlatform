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

		$(".sub-usrtb").click(function(){
		        $(".container > div").fadeOut();
						$(".agent-" + $(this).attr("name")).delay(1000).fadeIn();
						/*$(this).animate({borderTopWidth : "10px" ,
		                         backgroundColor : "#4dc941" ,
													 }, 200);*/
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
			$("#contestCreateBtn").attr("name" , this.innerHTML);
		});

		$("#joinModal .modal-body li a").click(function() {
			var nm = document.getElementById("joinModal");
			var url = "contests.php?query=join&contest="+ nm.name +"&agent="+ this.innerHTML;

			if (nm.role == "CREATE_CONTEST") {
				var url = "contests.php?query=create&number="+ nm.name +"&agent="+ this.innerHTML;
			}

			$("#joinModal .modal-body").html("<img src = 'images/25.GIF'>");
			$(this).load(url, function(responseTxt) {
				if (responseTxt.trim() == "You've Joined!" || responseTxt.trim() == "Created!") {
					$("#joinModal .modal-body").html("<div class = 'alert alert-success'><span class = 'glyphicon glyphicon-ok'></span>&nbsp;<strong>"+ responseTxt +"</strong></div>");
				} else {
					$("#joinModal .modal-body").html("<div class = 'alert alert-danger'><span class = 'glyphicon glyphicon-remove'></span>&nbsp;<strong>"+ responseTxt +"</strong></div>");
				}
			});
		});
	}
);
