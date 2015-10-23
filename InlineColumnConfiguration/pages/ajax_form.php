<?php

function print_columns_inputs_by_target ( $p_target ) {
	$t_all_columns = columns_get_all();
	$t_view_columns = helper_get_columns_to_view( $p_target, /* $p_viewable_only */ false);
	$t_deselected_columns = array_diff( $t_all_columns, $t_view_columns );
	$f_token = gpc_get('ajax_form_token');
	?>
	<form method="post" action="<?php echo plugin_page( 'ajax_form_update' ) ?>">
		<div class="columns_form_actions">
			<div class="action_div floatleft text_result">
				<span><?php echo plugin_lang_get( 'dialog_text' ) ?></span>
			</div>
			<div class="action_div floatright">
				<input type="submit" class="button_submit" value="<?php echo plugin_lang_get( 'button_update' ) ?>" />
			</div>
		</div>
		<fieldset>
			<?php echo form_security_field( 'ajax_form', $f_token ) ?>
			<input type="hidden" name="target" value="<?php echo $p_target ?>" />
			<input type="hidden" name="project_id" value="<?php echo $f_project_id ?>" />
			<ol class="sortable">
				<?php foreach( $t_view_columns as $t_column ) { ?>
				<li>
					<input type="checkbox" name="columns[]" value="<?php echo $t_column ?>" id="<?php echo $p_target . '_' . $t_column ?>" checked="checked" />
					<label for="<?php echo $p_target . '_' . $t_column ?>"><?php echo $t_column ?></label>
				</li>
				<?php } ?>
				<?php foreach( $t_deselected_columns as $t_column ) { ?>
				<li>
					<input type="checkbox" name="columns[]" value="<?php echo $t_column ?>" id="<?php echo $p_target . '_' . $t_column ?>" />
					<label for="<?php echo $p_target . '_' . $t_column ?>"><?php echo $t_column ?></label>
				</li>
				<?php } ?>
			</ol>
		</fieldset>
	</form>
	<?php
}


if( !@form_security_validate( 'ajax_form' ) ) {
	exit;
}
$f_project_id = gpc_get( 'project_id', null );
if( null === $f_project_id ) {
	header( ' ', true, 400 );
	exit;
}

?>
<div class="jqui_tabs">
	<div id="dialog_title">
		<?php echo lang_get( 'manage_columns_config' ) . ' (' . lang_get( 'email_project' ) . ': ' . project_get_name( $f_project_id ) . ')' ?>
	</div>
	<ul class="tabs">
		<li><a href='#tab1'><?php echo lang_get( 'view_issues_columns_title' ) ?></a></li>
		<li><a href='#tab2'><?php echo lang_get( 'print_issues_columns_title' ) ?></a></li>
		<li><a href='#tab3'><?php echo lang_get( 'csv_columns_title' ) ?></a></li>
		<li><a href='#tab4'><?php echo lang_get( 'excel_columns_title' ) ?></a></li>
	</ul>
	<div class="columns_form_inner">

		<div id="tab1" class="columns_form_container">
			<?php print_columns_inputs_by_target( COLUMNS_TARGET_VIEW_PAGE ) ?>
		</div>

		<div id="tab2" class="columns_form_container">
			<?php print_columns_inputs_by_target( COLUMNS_TARGET_PRINT_PAGE ) ?>	
		</div>

		<div id="tab3" class="columns_form_container">
			<?php print_columns_inputs_by_target( COLUMNS_TARGET_CSV_PAGE ) ?>		
		</div>

		<div id="tab4" class="columns_form_container">
			<?php print_columns_inputs_by_target( COLUMNS_TARGET_EXCEL_PAGE ) ?>		
		</div>

	</div>
</div>
<?php




