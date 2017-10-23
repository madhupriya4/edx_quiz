<?php
/* 
 * This is a one-line short description of the file
 * This file defines the version of plugin created
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/

 
defined('MOODLE_INTERNAL') || die();
 
$plugin->version   =  2010022400;
$plugin->requires  = 2010021900;
$plugin->cron      = 0;
$plugin->component = 'local_edx_quiz';
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   =  'v2.7-r1';
$plugin->dependencies = array(
    'mod_forum' => ANY_VERSION,
    'mod_data'  => TODO);
?>

