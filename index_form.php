<?php
/* 
 * This is a one-line short description of the file
 * This file defines a template for form creation.
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/

//header files
require_once("$CFG->libdir/formslib.php");
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
class lastaccess_form extends moodleform
{
	public function definition()
	{
		global $DB;
		$mform =& $this->_form;//check once
		$options=array();
		$options[0]=get_string('choose');	
		//Array to store quizlist
		$temp=array();
	
		$sql_o="select quizname from mdl_edX_quiz ";
		if($users=$DB->get_records_sql($sql_o))
		{ 
			foreach($users as $u)
			{
				array_push($temp,$u->quizname);
			}
		}

		//create dropdown list
		$mform->addElement('select', 'quizes', 'Quizzes', $temp);
		$mform->addElement('submit','save','display');
	}
}
?>
