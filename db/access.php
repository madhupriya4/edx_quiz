<?php
/*
 * This  is a one-line short description of the file
 * This file defines the capabilities
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/


$capabalities =array
    (
	'local/edx_quiz:view'=> array(
	'captype'=>'read',
	'contextlevel'=>CONTEXT_MODULE,
	'archetypes'=>array(
	'teacher'=>CAP_ALLOW,
	'admin'=>CAP_ALLOW,
	)
	),
	'local/edx_quiz:addinstance' => array(
    	'riskbitmask' => RISK_XSS,
    	'captype' => 'write',
    	'contextlevel' => CONTEXT_COURSE,
    	'archetypes' => array(
   	'editingteacher' => CAP_ALLOW,
    	'admin' => CAP_ALLOW
     	),
        'clonepermissionsfrom' => 'moodle/course:manageactivities'
    	)
    
    );

?>


