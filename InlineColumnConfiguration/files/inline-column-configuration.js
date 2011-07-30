jQuery(document).ready(function($) {
	
	var InlineColumnConfiguration = {
		copyValuesToHiddenField : function(target, fieldName) {

			var columns = Array();
			
			$("#columns_" + target + " :checked").each(function(index, element) {
				columns.push(element.id.substring(2));
			});
			
			$('[name=' + fieldName + ']').val(columns.join());
		}	
		
	}
	
	$('.inline-configure-columns').click(function(e) {
		e.preventDefault();
		$('#manage-view-forms').dialog({ width: 'auto' });
		$('.sortable').sortable();
	});
	
	$('#manage-columns-form').submit(function(e) {
		InlineColumnConfiguration.copyValuesToHiddenField('1', 'view_issues_columns');
		InlineColumnConfiguration.copyValuesToHiddenField('2', 'print_issues_columns');
		InlineColumnConfiguration.copyValuesToHiddenField('3', 'csv_columns');
		InlineColumnConfiguration.copyValuesToHiddenField('4', 'excel_columns');
	});
});