<?php
# Copyright (c) 2011 Robert Munteanu (robert@lmn.ro)

# Inline column configuration for MantisBT is free software: 
# you can redistribute it and/or modify it under the terms of the GNU
# General Public License as published by the Free Software Foundation, 
# either version 2 of the License, or (at your option) any later version.
#
# Inline column configuration plugin for MantisBT is distributed in the hope 
# that it will be useful, but WITHOUT ANY WARRANTY; without even the 
# implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
# See the GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Inline column configuration plugin for MantisBT.  
# If not, see <http://www.gnu.org/licenses/>.

class InlineColumnConfigurationPlugin extends MantisPlugin {

	public function register() {
		$this->name = plugin_lang_get("title");
		$this->description = plugin_lang_get("description");

		$this->version = "1.2.0";

		if( version_compare( MANTIS_VERSION, '2.2', '>=') ) {
			$this->requires = array(
				"MantisCore" => "2.2",
				"jQueryUI" => "1.8"
			);
		} else {
			$this->requires = array(
				"MantisCore" => "1.3, <2.2"
			);
		}

		$this->author = "Robert Munteanu, Carlos Proensa";
		$this->contact = "robert@lmn.ro";
		$this->url ="http://www.mantisbt.org/wiki/doku.php/mantisbt:inlinecolumnconfiguration";
		
		$this->scripts = array(
			'view_all_bug_page.php',
		);
	}

	#Check for conditions when this plugin is allowed to hook
	function check_page() {
		return auth_is_user_authenticated() && !current_user_is_protected() &&  in_array( basename( $_SERVER['SCRIPT_NAME'] ), $this->scripts );
	}	
	
	public function hooks() {
		$h = array(
			'EVENT_MENU_FILTER' => 'add_configure_columns_link',
			'EVENT_LAYOUT_RESOURCES' => 'resources',
			'EVENT_LAYOUT_BODY_END' => 'add_columns_dialog'
		);
		return $h;
	}

	public function resources( $p_event ) {
		if( $this->check_page() ) {
			return '<script type="text/javascript" src="' . plugin_file( 'inline-column-configuration.js' ) . '"></script>'
				 . '<link rel="stylesheet" type="text/css" href="'. plugin_file( 'inline-column-configuration.css' ) .'"/>';
		}
	}

	public function add_configure_columns_link() {
		if( !$this->check_page() ) {
			return;
		}
		$t_token = form_security_token( 'ajax_form' );
		$t_url = plugin_page( 'ajax_form' ) . '&project_id=' . helper_get_current_project() . '&ajax_form_token=' . $t_token;
		$t_link = '<a href="account_manage_columns_page.php" data-remote="' . $t_url . '" class="columns_form_trigger">'
				. plugin_lang_get( 'configure_columns' )
				. '</a>';
		return $t_link;
	}

	public function add_columns_dialog() {
		if( !$this->check_page() ) {
			return;
		}
		$t_title = lang_get( 'manage_columns_config' ) . ' (' . lang_get( 'email_project' ) . ': ' . project_get_name( helper_get_current_project() ) . ')';
		?>
		<div id="column_config_dialog" class="dialog" title="<?php echo $t_title ?>">
		<?php echo plugin_lang_get( 'please_wait' ) ?>
		</div>
		<?php
	}
	
}
