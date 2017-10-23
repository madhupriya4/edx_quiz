<?php
/* 
 * This is a one-line short description of the file
 * This file adds the plugin to the admin tree.
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/

defined('MOODLE_INTERNAL') || die;
if ($hassiteconfig)
	 { 
       		 $ADMIN->add('localplugins', new admin_externalpage('edx_quiz','edx_grade',$CFG->wwwroot.'/local/edx_quiz/index.php'));
	 }
?>
