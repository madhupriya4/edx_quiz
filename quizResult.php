<?php
/*
 * This is a one-line short description of the file
 * This file displays the grades of quizes conducted on IITBombayX
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/

//header files
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require($CFG->dirroot.'/local/edx_quiz/index_form.php'); 
require_once("$CFG->libdir/formslib.php");

//checks whether user is logged in or not
require_login();

//global variables
global $USER,$DB;

//set up page object
$url=new moodle_url('/local/edx_quiz/quizResult.php');
$strtitle='edX Quizzes';
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
$PAGE->set_title($strtitle);
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading($strtitle);

//outputAPI which sends output to the browser, $OUTPUT object is used here
echo $OUTPUT->header();


//check for admin
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
// check roleid for teacher
$queryrole  = $DB->get_records('role_assignments',array('userid'=>$USER->id));
foreach($queryrole as $qrole)
$rid= $qrole->roleid;

//create form element
$mform = new lastaccess_form('','');
$mform->display();

//obtain quiz names from dropdown
$temp=array();
   
$sql_o="select quizname from mdl_edX_quiz ";

if($users=$DB->get_records_sql($sql_o))
        {
	        foreach($users as $u)
                {
                        array_push($temp,$u->quizname);
                }
        }


if($data = $mform->get_data())
	{
     		$param_list = $_POST['quizes'];
       		if($isadmin || $rid==3)
		 {
			echo "<h5 align='left'>Maximum marks= ";
			$sql_qu = "SELECT q.emailid,q.username,q.courseid,q.quizid,q.result,maxmarks from mdl_edX_quiz_result as q,mdl_edX_quiz  where mdl_edX_quiz.quizname='".$temp[$param_list]."' and q.quizid=mdl_edX_quiz.quizid and mdl_edX_quiz.courseid='116'";
			
$table=new html_table();
			$value=150;//default max marks
			$table->head =array('EMAIL','USERNAME','GRADE');

			if($users=$DB->get_records_sql($sql_qu)) //returns array of objects
			{
				foreach($users as $u)
				{
					$value=$u->maxmarks;
		
					$table->data[]=array($u->emailid,$u->username,$u->result);

				}

			}
			echo $value;
			echo "</h1>";
			//display data in tabular structure
			if(!empty($table->data))
				echo html_writer::table($table);
		}

	       else
		{
			$u_ln=$USER->lastname;
			$sql_qu = "SELECT b.emailid,b.courseid,b.quizid,b.result from mdl_edX_quiz_result as b,mdl_user as a ,mdl_edX_quiz where mdl_edX_quiz.quizname='".$temp[$param_list]."' and b.quizid=mdl_edX_quiz.quizid and a.email=b.emailid and a.lastname='".$u_ln."'";
			$table=new html_table();
			$table->head =array('GRADE');
			if($users=$DB->get_records_sql($sql_qu)) //returns array of objects
			{      
				foreach($users as $u)
				$table->data[]=array($u->result);

			}
			if(!empty($table->data))
				echo html_writer::table($table);
			else
           			echo "Please attempt the quiz first";
		}


	}
echo $OUTPUT->footer();
?>
