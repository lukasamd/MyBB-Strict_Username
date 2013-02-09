<?php
/**
 * This file is part of Strict Username plugin for MyBB.
 * Copyright (C) 2010-2013 Lukasz Tkacz <lukasamd@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */ 

/**
 * Disallow direct access to this file for security reasons
 * 
 */
if (!defined("IN_MYBB")) exit;

/**
 * Plugin Activator Class
 * 
 */
class strictUsernameActivator
{
    private static $tpl = array();
    
    
    private static function getTpl()
    {
    }
    
    public static function activate()
    {
        global $db;
        self::deactivate();

        find_replace_templatesets('member_register', '#username_availability#', 'strictUsername_Validate');	
    }

    public static function deactivate()
    {
        global $db;
        self::getTpl();
        
        include MYBB_ROOT . '/inc/adminfunctions_templates.php';
        find_replace_templatesets('member_register', '#strictUsername_Validate#', 'username_availability');
    }

}
