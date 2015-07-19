$(document).ready(
	function(){
		$('[data-toggle="tooltip"]').tooltip();
		$("#backIcon , #backIcon2").click(function(){
			$("#reg-form , #fp-form").fadeOut();
			$(".wrapper").delay(500).animate({height : '100px'});
			$("#w-header-reg").delay(1000).fadeOut();
			$("#w-header-fp").delay(1000).fadeOut();
			$("#w-header-login").delay(1500).fadeIn();
			$(".wrapper").delay(2000).animate({height : '470px'});
			$("#login-form").delay(3000).fadeIn();
			$("#w-footer").delay(3000).fadeIn();
		});
		$("#reg").click(function(){
			$("#login-form , #w-footer").fadeOut();
			$(".wrapper").delay(500).animate({height : '100px'});
			$("#w-header-login").delay(1000).fadeOut();
			$("#w-header-reg").delay(1500).fadeIn();
			$(".wrapper").delay(2000).animate({height : '530px'});
			$("#reg-form").delay(3000).fadeIn();
			$("#backIcon").delay(3500).fadeIn();
		});

		$("#fp").click(function(){
			$("#login-form , #w-footer").fadeOut();
			$(".wrapper").delay(500).animate({height : '100px'});
			$("#w-header-login").delay(1000).fadeOut();
			$("#w-header-fp").delay(1500).fadeIn();
			$(".wrapper").delay(2000).animate({height : '300px'});
			$("#fp-form").delay(3000).fadeIn();
			$("#backIcon2").delay(3500).fadeIn();
		});
	}
);
