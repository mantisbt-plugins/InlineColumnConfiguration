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
	
	$('div').on('click', 'a[href*="#inline-column-configuration"]', function(e) {
		e.preventDefault();
		$('#manage-view-forms').attr({"class":"nohidden"});
		$('#manage-view-forms').dialog({ width: 'auto' });
		$('.sortable').sortable().disableSelection();
	});
	
	$('#manage-columns-form').submit(function(e) {
		InlineColumnConfiguration.copyValuesToHiddenField('1', 'view_issues_columns');
		InlineColumnConfiguration.copyValuesToHiddenField('2', 'print_issues_columns');
		InlineColumnConfiguration.copyValuesToHiddenField('3', 'csv_columns');
		InlineColumnConfiguration.copyValuesToHiddenField('4', 'excel_columns');
	});
});
