<?php
/**
 * This file is part of Strict Username plugin for MyBB.
 * Copyright (C) Lukasz Tkacz <lukasamd@gmail.com>
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
 * Plugin Installator Class
 * 
 */
class strictUsernameInstaller 
{

    public static function install()
    {
        global $db, $lang, $mybb;
        self::uninstall();
        
        $result = $db->simple_select('settinggroups', 'MAX(disporder) AS max_disporder');
        $max_disporder = $db->fetch_field($result, 'max_disporder');
        $disporder = 1;

        $settings_group = array(
            'gid' => 'NULL',
            'name' => 'strictUsername',
            'title' => $db->escape_string($lang->strictUsernameName),
            'description' => $db->escape_string($lang->strictUsernameGroupDesc),
            'disporder' => $max_disporder + 1,
            'isdefault' => '0'
        );
        $db->insert_query('settinggroups', $settings_group);
        $gid = (int) $db->insert_id();

        $options = 'select\nreject=' . $lang->strictUsernameOptionReject . '\n';
        $options .= 'allow=' . $lang->strictUsernameOptionAllow . '\n';
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameMode',
            'title' => $db->escape_string($lang->strictUsernameMode),
            'description' => $db->escape_string($lang->strictUsernameModeDesc),
            'optionscode' => $options,
            'value' => 'reject',
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameStatusCharsSmall',
            'title' => $db->escape_string($lang->strictUsernameStatusCharsSmall),
            'description' => $db->escape_string($lang->strictUsernameStatusCharsSmallDesc),
            'optionscode' => 'onoff',
            'value' => '0',
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameStatusCharsBig',
            'title' => $db->escape_string($lang->strictUsernameStatusCharsBig),
            'description' => $db->escape_string($lang->strictUsernameStatusCharsBigDesc),
            'optionscode' => 'onoff',
            'value' => '0',
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameStatusNumeric',
            'title' => $db->escape_string($lang->strictUsernameStatusNumeric),
            'description' => $db->escape_string($lang->strictUsernameStatusNumericDesc),
            'optionscode' => 'onoff',
            'value' => '0',
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameStatusSpaces',
            'title' => $db->escape_string($lang->strictUsernameStatusSpaces),
            'description' => $db->escape_string($lang->strictUsernameStatusSpacesDesc),
            'optionscode' => 'onoff',
            'value' => '1',
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameStatusPunctuation',
            'title' => $db->escape_string($lang->strictUsernameStatusPunctuation),
            'description' => $db->escape_string($lang->strictUsernameStatusPunctuationDesc),
            'optionscode' => 'onoff',
            'value' => '1',
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameStatusSpecials',
            'title' => $db->escape_string($lang->strictUsernameStatusSpecials),
            'description' => $db->escape_string($lang->strictUsernameStatusSpecialsDesc),
            'optionscode' => 'onoff',
            'value' => '1',
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        $setting = array(
            'sid' => 'NULL',
            'name' => 'strictUsernameStatusAdditional',
            'title' => $db->escape_string($lang->strictUsernameStatusAdditional),
            'description' => $db->escape_string($lang->strictUsernameStatusAdditionalDesc),
            'optionscode' => 'text',
            'value' => $lang->strictUsernameAdditionalChars,
            'disporder' => $disporder++,
            'gid' => $gid
        );
        $db->insert_query('settings', $setting);
        
        rebuild_settings();
    }

    public static function uninstall()
    {
        global $db;
        
        $result = $db->simple_select('settinggroups', 'gid', "name = 'strictUsername'");
        $gid = (int) $db->fetch_field($result, "gid");
        
        if ($gid > 0)
        {
            $db->delete_query('settings', "gid = '{$gid}'");
        }
        $db->delete_query('settinggroups', "gid = '{$gid}'");
        
        rebuild_settings();
    }

}
