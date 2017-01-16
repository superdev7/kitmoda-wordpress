jQuery(document).ready(function($) {
	// Tooltips on the dashboard icons
	$( ".tips, .help_tip" ).tipTip({
		'attribute' : 'data-tip',
		'fadeIn' : 50,
		'fadeOut' : 50,
		'delay' : 200
	});
});