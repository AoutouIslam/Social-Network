$(document).ready(function(){


	// on click sign up ;hide login  and sshow registration form
$("#signup").click(function(){

	$("#first").slideUp("slow",function(){

		$("#second").slideDown("slow");
	});

});


// on click sign up ;hide login  and sshow loginin form
$("#signin").click(function(){

	$("#second").slideUp("slow",function(){

		$("#first").slideDown("slow");
	});

});


});