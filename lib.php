<?php
/* 
 * This is a one-line short description of the file
 * This function library, is automatically included by config.php. Hook function local_edx_quiz_extends_settings_navigation() and adds plugin to the navigation and settings blocks.
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
$context=context_system::instance();
// This function inserts the plugin in course admin block
function local_edx_quiz_extends_settings_navigation(settings_navigation $settingsnav, $context)
{
	global $DB,$USER,$COURSE,$PAGE;

	$admins = get_admins();
	$isadmin = false;
	foreach($admins as $admin)
	 {
    		if ($USER->id == $admin->id) 
		{
        		$isadmin = true;
        		break;
    		}
	 }
	$coursenode = $settingsnav->get('courseadmin');
	if ($coursenode ) 
	{
		$context = $PAGE->context;
		$coursecontext = $context->get_course_context();
		$categoryid = null;
		if ($coursecontext) 
			{ // No course context for system / user profile
				$courseid = $coursecontext->instanceid;
				$course = $DB->get_record('course', array('id' => $courseid), 'id, category');
					if ($course)
						 { // Should always exist, but just in case ...
							$categoryid = $course->category;
							
						 }	
			} 
		$sql= 'select ra.userid,c.category ,c.id from mdl_user u join mdl_role_assignments ra on ra.userid=u.id join mdl_role r on ra.roleid =r.id join mdl_context con on ra.contextid=con.id join mdl_course c on c.id=con.instanceid ';
	if($users=$DB->get_records_sql($sql))
		{ 
			foreach($users as $usr)
			{ 
				if($usr->category==$categoryid && $categoryid==4 && $courseid==$usr->id && $usr->userid==$USER->id && $courseid==116 )
					$coursenode->add('edx_grade', '/local/edx_quiz/index.php');
			}
				if($isadmin && $categoryid==4 && $courseid==116)
					$coursenode->add('edx_grade', '/local/edx_quiz/index.php');
		}
	}
}
?>
