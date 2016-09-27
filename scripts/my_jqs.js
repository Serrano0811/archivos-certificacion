$(function() {
	$(".despl-activador-cer span").addClass("glyphicon");
	$(".despl-activador-cer span").addClass("glyphicon-triangle-top");
	$(".despl-activador-key span").addClass("glyphicon");
	$(".despl-activador-key span").addClass("glyphicon-triangle-top");
	$(".despl-activador-cer").click(function() {
		$(".despl-activador-cer span").toggleClass("glyphicon-triangle-top");
		$(".despl-activador-cer span").toggleClass("glyphicon-triangle-bottom");
		$(".despl-div-cer").slideToggle("slow");
	});
	$(".despl-activador-key").click(function() {
		$(".despl-activador-key span").toggleClass("glyphicon-triangle-top");
		$(".despl-activador-key span").toggleClass("glyphicon-triangle-bottom");
		$(".despl-div-key").slideToggle("slow");
	});
});