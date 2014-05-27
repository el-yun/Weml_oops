/*
    New Open Window
*/
function open_window(url)
{
	  window.open(url,'oopstool','fullscreen=yes,location=no');
}


$(document).ready(function(){
	$("#topnav ul li a").fadeTo("slow", 0.5); // This sets the opacity of the thumbs to fade down to 30% when the page loads
	$("#topnav ul li a").hover(function(){
		$(this).fadeTo("slow", 1.0); // This should set the opacity to 100% on hover
		},function(){
			$(this).fadeTo("slow", 0.5); // This should set the opacity back to 30% on mouseout
			});
			});
$(document).ready(function(){
	$("#topnav ul li a.active").fadeTo("slow", 1.0); // This sets the opacity of the thumbs to fade down to 30% when the page loads
	$("#topnav ul li a.active").hover(function(){
		$(this).fadeTo("slow", 1.0); // This should set the opacity to 100% on hover
		},function(){
			$(this).fadeTo("slow", 1.0); // This should set the opacity back to 30% on mouseout
			});
			});