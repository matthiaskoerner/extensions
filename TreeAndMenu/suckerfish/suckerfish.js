$(document).ready(function() {

	// IE has problems with title attribute in suckerfish menus
	$('.suckerfish a').removeAttr('title');

	// Suckerfish hover fix
	if(window.attachEvent) {
		$('.suckerfish li').mouseenter( function() { this.addClass('sfhover'); });
		$('.suckerfish li').mouseleave( function() { this.removeClass('sfhover'); });
	}

});