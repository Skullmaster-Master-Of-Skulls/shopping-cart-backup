
$(document).ready(function() {
	$("#addOverlay").hide();
	$("#overlay").hide();	
	$("#Loginmenu").css("opacity",0);
	var pressCounter= 0;
	$( "#Loginbutton" ).click(function() {
		if($('#Loginmenu').css('opacity') == 1) {
			pressCounter++;
		}
		if (pressCounter==0){
			$("#Loginmenu").animate({
					"top":"+=75px",
					"opacity":1
			},500,"linear");
			pressCounter++;
		}
		else{
			console.log("hello");
			$("#Loginmenu").animate({
				"top":"-=75px",
				"opacity":0
			},500,"linear");
			pressCounter--;
		}
	});

	$("#overlaybutton").click(function(){
		location.href="index.php";
	});

	$("#Createbutton").click(function(){
		$("#overlay").show();
		$("#addOverlay").show();
	});

	$("#overlay").click(function(){
		$("#overlay").hide();
		$("#addOverlay").hide();
		$("#editOverlay").hide();
	});

	$("#editItemButton").click(function(){
		$("#editItemButton").preventDefault();
		$("#overlay").show();
		$("#editOverlay").show();
	});

});


