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
 * Create plugin object
 * 
 */
$plugins->objects['strictUsername'] = new strictUsername();
/**
 * Standard MyBB info function
 * 
 */
function strictUsername_info()
{
    global $lang;

    $lang->load("strictUsername");
    
    $lang->strictUsernameDesc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' . 
        '<input type="hidden" name="hosted_button_id" value="3BTVZBUG6TMFQ">' .
        '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->strictUsernameDesc;

    return Array(
        'name' => $lang->strictUsernameName,
        'description' => $lang->strictUsernameDesc,
        'website' => 'https://tkacz.it',
        'author' => 'Lukasz Tkacz',
        'authorsite' => 'https://tkacz.it',
        'version' => '1.0.0',
        'guid' => '',
        'compatibility' => '18*',
        'codename' => 'strict_username'
    );
}

/**
 * Standard MyBB installation functions 
 * 
 */
function strictUsername_install()
{
    require_once('strictUsername.settings.php');
    strictUsernameInstaller::install();
}

function strictUsername_is_installed()
{
    global $mybb;

    return (isset($mybb->settings['strictUsernameMode']));
}

function strictUsername_uninstall()
{
    require_once('strictUsername.settings.php');
    strictUsernameInstaller::uninstall();
}

/**
 * Plugin Class 
 * 
 */
class strictUsername
{
    // Check username mode
    private $mode;
    
    // Allow/reject chars
    private $chars = array();
    
    // Wrong chars in username
    private $wrongChars = array();

    /**
     * Constructor - add plugin hooks
     */
    public function __construct()
    {
        global $plugins;

        // Add all hooks
        $plugins->hooks["datahandler_user_validate"][10]["strictUsername_validateUsername"] = array("function" => create_function('', 'global $plugins; $plugins->objects[\'strictUsername\']->validateUsername();'));
        $plugins->hooks["xmlhttp_username_availability"][10]["strictUsername_validateXMLHTTP"] = array("function" => create_function('', 'global $plugins; $plugins->objects[\'strictUsername\']->validateXMLHTTP();'));
        $plugins->hooks["pre_output_page"][10]["strictUsername_pluginThanks"] = array("function" => create_function('&$arg', 'global $plugins; $plugins->objects[\'strictUsername\']->pluginThanks($arg);'));
    }

    /**
     * Validate username on standard check (non-AJAX)
     */
    public function validateUsername()
    {
        global $db, $lang, $user, $userhandler;

        if (THIS_SCRIPT != 'member.php' && THIS_SCRIPT != 'usercp.php')
        {
            return;
        }

        $this->init();
        $this->setMode($this->getConfig('Mode'));
        $this->checkUsername($user['username']);

        if (sizeof($this->wrongChars) > 0)
        {
            $lang->load("strictUsername");

            $userhandler->set_error("bad_characters_username");
            $userhandler->set_error($lang->strictUsernameError . "'" . implode("', '", $this->wrongChars) . "'");
        }
    }

    /**
     * Validate username on XMLHTTP request (AJAX)
     */
    public function validateXMLHTTP()
    {
        global $charset, $db, $lang, $mybb, $username;

        $this->init();
        $this->setMode($this->getConfig('Mode'));
        $this->checkUsername($username);

        if (sizeof($this->wrongChars) > 0)
        {
            echo json_encode($lang->banned_characters_username . ": '" . implode("', '", $this->wrongChars) . "'");
            exit;
        }
    }

    /**
     * Initiate allow/reject chatacters table
     */
    private function init()
    {
        if ($this->getConfig('StatusCharsSmall'))
        {
            $this->chars = array_merge($this->chars, array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'));
        }

        if ($this->getConfig('StatusCharsBig'))
        {
            $this->chars = array_merge($this->chars, array('Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'));
        }

        if ($this->getConfig('StatusNumeric'))
        {
            $this->chars = array_merge($this->chars, array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'));
        }

        if ($this->getConfig('StatusSpaces'))
        {
            $this->chars[] = ' ';
        }

        if ($this->getConfig('StatusPunctuation'))
        {
            $this->chars = array_merge($this->chars, array('.', ',', ':', ';', '!', '?', '-', '_', '[', ']', '(', ')', '{', '}'));
        }

        if ($this->getConfig('StatusSpecials'))
        {
            $this->chars = array_merge($this->chars, array('@', '|', '#', '$', '%', '^', '*', '+', '=', '/', '\\'));
        }

        if ($this->getConfig('StatusAdditional') != '')
        {
            $additionalChars = explode(',', $this->getConfig('StatusAdditional'));
            $additionalChars = array_diff($additionalChars, $this->chars);
            $this->chars = array_merge($this->chars, $additionalChars);
        }
    }

    /**
     * Check is username valid
     * 
     * @param string $username Username to check
     */
    private function checkUsername($username)
    {
        $this->wrongChars = array();

        switch ($this->mode)
        {
            case 'allow':
                $changed_name = str_replace($this->chars, '', $username);
                $length = mb_strlen($changed_name);
                if ($length > 0)
                {
                    for ($i = 0; $i < $length; $i++)
                    {
                        $this->wrongChars[] = $changed_name[$i];
                    }
                }
                $this->wrongChars = array_unique($this->wrongChars);
                break;

            case 'reject':
            default:
                if ($numChars = count($this->chars))
                {
                    for ($i = 0; $i < $numChars; $i++)
                    {
                        if ($this->chars[$i] != '' && mb_strstr($username, $this->chars[$i]))
                        {
                            $this->wrongChars[] = $this->chars[$i];
                        }
                    }
                }
                break;
        }
    }

    /**
     * Setter for check username mode 
     * 
     * @param string $mode Check username mode - allow / reject
     */
    private function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Helper function to get variable from config
     * 
     * @param string $name Name of config to get
     * @return string Data config from MyBB Settings
     */
    private function getConfig($name)
    {
        global $mybb;

        return $mybb->settings["strictUsername{$name}"];
    }
    
    /**
     * Say thanks to plugin author - paste link to author website.
     * Please don't remove this code if you didn't make donate
     * It's the only way to say thanks without donate :)     
     */
    public function pluginThanks(&$content)
    {
        global $session, $lukasamd_thanks;
        
        if (!isset($lukasamd_thanks) && $session->is_spider)
        {
            $thx = '<div style="margin:auto; text-align:center;">This forum uses <a href="https://tkacz.it">Lukasz Tkacz</a> MyBB addons.</div></body>';
            $content = str_replace('</body>', $thx, $content);
            $lukasamd_thanks = true;
        }
    }

}
