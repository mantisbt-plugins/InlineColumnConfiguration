<?php

$t_option = null;
$ok = true;
$error_msg = '';

if( current_user_is_protected() ){
	$ok = false;
	$error_msg = 'User is protected, not allowed to change preferences';
}

if( $ok && !@form_security_validate('ajax_form')){
	$ok = false;
	$error_msg = 'Form has expired, reload';
}

$f_project_id = @gpc_get('project_id', null);
$f_target = @gpc_get( 'target', null);
$f_columns = @gpc_get_string_array( 'columns', array() );


if( $ok && (null === $f_project_id || null === $f_target ) ){
		$ok = false;
	$error_msg = 'Missing parameters';
}

switch($f_target){
	case COLUMNS_TARGET_VIEW_PAGE:
		$t_option = 'view_issues_page_columns';
		break;
	case COLUMNS_TARGET_CSV_PAGE:
		$t_option = 'csv_columns';
		break;
	case COLUMNS_TARGET_PRINT_PAGE:
		$t_option = 'print_issues_page_columns';
		break;
	case COLUMNS_TARGET_EXCEL_PAGE:
		$t_option = 'excel_columns';
		break;
	default:
		$ok = false;
		$error_msg = 'Column type is not valid';
}



if( $ok ) {
	$t_all_columns = columns_get_all();
	$ok = @columns_ensure_valid( $t_option, $f_columns, $t_all_columns );
	if( !$ok ) {
		$error_msg = 'There is an invalid column name';
	}
}

if( $ok ) {
	$t_user_id = auth_get_current_user_id();
	if( json_encode( config_get( $t_option, '', $t_user_id, $f_project_id ) ) !== json_encode( $t_option ) ) {
		$ok = @config_set( $t_option, $f_columns, $t_user_id, $f_project_id );
	}
	if( !$ok ) {
		$error_msg = 'Error saving configuration';
	}
}


if( $ok ){
	echo '<span class="result_ok">';
	echo plugin_lang_get('result_text_ok');
	if( COLUMNS_TARGET_VIEW_PAGE == $f_target ){
		echo '<br />' . plugin_lang_get('result_text_reload');
	}
	echo '</span>';
}
else {
	echo '<span class="result_error">ERROR: '. $error_msg . '</span>';
}

