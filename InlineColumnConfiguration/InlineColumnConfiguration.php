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

        $this->version = "1.0";
        $this->requires = array(
			"MantisCore" => "1.2.6",
			"jQueryUI" => "1.8"
        );

        $this->author = "Robert Munteanu";
        $this->contact = "robert@lmn.ro";
    }
    
    public function hooks() {
        
        return array (
            'EVENT_MENU_FILTER' => 'add_configure_columns_link',
        	'EVENT_LAYOUT_RESOURCES' => 'resources',
        	'EVENT_LAYOUT_BODY_END' => 'add_columns_form'
        );
    }
    
    public function resources( $p_event ) {
        return '<script type="text/javascript" src="' . plugin_file( 'inline-column-configuration.js' ) . '"></script>';
    }    
    
    public function add_configure_columns_link() {
        
        // TODO: remove OB once we have echo_link in MantisBT core
        ob_start();
        echo '&#160;';
        print_link( 'account_manage_columns_page.php', plugin_lang_get( 'configure_columns' ), false, 'inline-configure-columns' );
        
        $link = ob_get_contents();
        
        ob_end_clean();
        
        return $link;
    }
    
    public function add_columns_form() {
        
        if  ( basename($_SERVER['SCRIPT_NAME']) != 'view_all_bug_page.php' )
            return;
        
        $t_user_id = auth_get_current_user_id();
        $t_project_id = helper_get_current_project();
        
        $t_all_columns = columns_get_all( $t_project_id );
        $t_view_columns = helper_get_columns_to_view( COLUMNS_TARGET_VIEW_PAGE, /* $p_viewable_only */ false );
        
        echo '<form id="manage-columns-form-"'. $p_target .'" method="post" action="">';
        echo '<table id="manage-view-forms" style="display: none" title="' . plugin_lang_get('configure_columns') .'">';
        echo ' <tr> ';
        
        $this->add_columns_form_by_target(COLUMNS_TARGET_VIEW_PAGE, $t_user_id, $t_project_id);
        $this->add_columns_form_by_target(COLUMNS_TARGET_CSV_PAGE, $t_user_id, $t_project_id);
        $this->add_columns_form_by_target(COLUMNS_TARGET_PRINT_PAGE, $t_user_id, $t_project_id);
        $this->add_columns_form_by_target(COLUMNS_TARGET_EXCEL_PAGE, $t_user_id, $t_project_id);
        
        echo ' </tr>';
        echo ' <tr><td colspan="4">';
        echo '  <input type="submit" class="button" value="' . plugin_lang_get('submit') . '" ></input>';
        echo ' </td></tr>';
        echo '</table>';
        
        echo '</form>';
    }
    
    private function add_columns_form_by_target ( $p_target , $p_user_id, $p_project_id ) {

        $t_all_columns = columns_get_all( $p_project_id );
        $t_view_columns = helper_get_columns_to_view( $p_target, /* $p_viewable_only */ false , $p_user_id);
        
        echo '<td width="25%">';
        
        echo '<legend>' . plugin_lang_get('view_columns_' . $p_target) . '</legend>';
        echo '<fieldset>';
        echo '<ol class="sortable">';
        foreach ( $t_all_columns as $t_column ) {
            echo '<li>';
            echo '<input type="checkbox" id="' . $t_column .'" ';
            check_checked(in_array ( $t_column, $t_view_columns ) );
            echo ' ></input>';
            echo '<label for="' . $t_column .'">'. $t_column .'</label>';
            echo '</li>';
        }
        echo '</fieldset>';
        echo '</td>';
        
    }
}

?>