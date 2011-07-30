jQuery(document).ready(function($) {
	$('.inline-configure-columns').click(function(e) {
		e.preventDefault();
		$('#manage-view-forms').dialog({ width: 'auto' });
		$('.sortable').sortable();
	});
});