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
            'EVENT_MENU_FILTER' => 'add_configure_columns_link'
        );
    }
    
    public function add_configure_columns_link() {
        
        // TODO: remove OB once we have echo_link in MantisBT core
        ob_start();
        echo '&#160;';
        print_link( 'account_manage_columns_page.php', plugin_lang_get( 'configure_columns' ) );
        
        $link = ob_get_contents();
        
        ob_end_clean();
        
        return $link;
    }
}

?>