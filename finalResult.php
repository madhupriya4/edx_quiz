<?php
 /*
 * This is a one-line short description of the file
 * This file displays the combined grades of quizes conducted on IITBombayX and Moodle
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/

//header files
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
//checks whether user is logged in or not
require_login();
//global variables
global $PAGE,$USER,$DB,$CFG;

//Set up page object

$url=new moodle_url('/local/edx_quiz/index.php');
$strtitle='Combined Grades';
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
$PAGE->set_title($strtitle);
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading($strtitle);
//Sets header for page
echo $OUTPUT->header();
$u_ln=$USER->lastname;
$courseid = $PAGE->course->id;

//database connection
$dbhost = '10.129.50.191';
$dbuser = 'moodleuser';
$dbpass = 'moodlepass';
$conn = mysql_connect($dbhost,$dbuser,$dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
        mysql_select_db('moodle');

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
//check roleid for teacher
$queryrole  = $DB->get_records('role_assignments',array('userid'=>$USER->id));
foreach($queryrole as $qrole)
$rid= $qrole->roleid;

if($isadmin || $rid==3)
{
        $table=new html_table();
	
       $th=array('Email','Username');
	
	$value=150;
	
	
        $sql_o="select quizname,quizid,'edX' system,maxmarks from mdl_edX_quiz where courseid='116' union all select name,id,'Moodle' system,grade as maxmarks from mdl_quiz where course=116 ";
        $k=1;$counte=0;$countm=0;
        if($users=$DB->get_records_sql($sql_o))
        {
                      
		$m=" ( select  a.emailid  as em1,a.username as u1 ";
                $e=" ( select  a.email   as em2,a.username as u2 ";


                foreach($users as $u)
		{
                        if($u->system=="edX")
                        {

                                $qe_id=$u->quizid;
                                $qe_name=$u->quizname;
                                $m=$m." ,SUM(CASE WHEN t.quizname = '".$qe_name."' THEN a.result ELSE NULL END) as value".$k;
                                $counte++;
				$qe_name=$u->system." ".$u->quizname."(".round($u->maxmarks).")";
                                array_push($th,$qe_name);


                        }
                        if($u->system=="Moodle")
                        {

                                $qm_id=$u->quizid;
                                $qm_name=$u->quizname;
                                $e=$e.",  max(CASE WHEN t.quiz = ".$qm_id." THEN t.sumgrades ELSE NULL END) as value".$k;
                                $countm++;
				$qm_name=$u->system." ".$u->quizname."(".round($u->maxmarks).")";
                                array_push($th,$qm_name);

                        }
                        $k++;
                }
		
                $table->head =$th;
              
                $m=$m." FROM mdl_edX_quiz_result as a,mdl_edX_quiz as t  where t.quizid=a.quizid  GROUP BY a.emailid) as t1";
                $e=$e." FROM mdl_user as a,mdl_quiz_attempts as t,mdl_user_enrolments as ue where t.userid=a.id and ue.enrolid=271 and ue.userid=a.id  GROUP BY a.email) as t2 on t1.em1=t2.em2";


		$final="select t1.*,t2.* from ".$m." left outer join".$e."  union all"." select t1.*,t2.* from ".$m." right outer join".$e." where t1.em1 is null";
               
		$output = "";
		$o = mysql_query($final,$conn);
		$columns_total = mysql_num_fields($o);

// Get The Field Name

	for ($i = 0; $i < $columns_total; $i++) 
	{
		$heading = mysql_field_name($o, $i);
		$output .= '"'.$heading.'",';
	}
	$output .="\n";

// Get Records from the table

	while ($row = mysql_fetch_array($o)) 
	{
		for ($i = 0; $i < $columns_total; $i++) 
		{
			$output .='"'.$row["$i"].'",';
		}
	}

	
        $retval = mysql_query( $final, $conn );
        if($users=$DB->get_records_sql($final))
                {
                        foreach($users as $u)
                        { 
                                
				$temp1=$u->em1;$temp2=$u->u1;

                                if(!strcmp($temp1,NULL))
                                {
                                        $temp1=$u->em2;
                                 
                                        $temp2=$u->u2;

                                }
                               
				$tv=array($temp1,$temp2);
      				for($i=2;$i<2+$counte;$i++)
                                        {
                                        $a=mysql_field_name($retval,$i);

                                        array_push($tv,round($u->$a));
                                        }
                              
                        	  for($i=2+2+$counte;$i<4+$counte+$countm;$i++)
       
			       {
                                        $a=mysql_field_name($retval,$i);

                                        array_push($tv,round($u->$a));
                                        }
                                $table->data[]=$tv;
                        }
		}
	
	}
	
		if(!empty($table->data))
		{
		
			echo html_writer::table($table);
		}
		
}

//else he/she is a student(User data)

else
{
	$table=new html_table();
	$th=array(); //array to store quiznames (tableheadings)
	$sql_o="select quizname,quizid,'edX' system,maxmarks from mdl_edX_quiz where courseid='116' union all select name,id,'Moodle' system ,grade as maxmarks from mdl_quiz where course=116";
        $k=1;$counte=0;$countm=0;
        if($users=$DB->get_records_sql($sql_o))
        {
                $m=" (SELECT a.emailid  as em1,u.firstname as f1 ,u.lastname as l1";
                $e=" (SELECT a.email   as em2,u.firstname as f2,u.lastname as l2";
	        foreach($users as $u)
                {
                        if($u->system=="edX")
                        {

                                $qe_id=$u->quizid;
                                $qe_name=$u->quizname;
                                $m=$m." ,SUM(CASE WHEN t.quizname = '".$qe_name."' THEN a.result ELSE NULL END) as value".$k;
				$qe_name=$u->system." ".$u->quizname."(".round($u->maxmarks).")";

                                array_push($th,$qe_name);

                                $counte++;

                        }
                        if($u->system=="Moodle")
                        {

                                $qm_id=$u->quizid;
                                $qm_name=$u->quizname;
                                $e=$e.",  max(CASE WHEN t.quiz = ".$qm_id." THEN t.sumgrades ELSE NULL END) as value".$k;
 				$qe_name=$u->system." ".$u->quizname."(".round($u->maxmarks).")";

                                array_push($th,$qe_name);
                                
				$countm++;

                        }
                        $k++;
                }
                $table->head =$th;
                $m=$m." FROM mdl_edX_quiz_result as a,mdl_edX_quiz as t,mdl_user as u where t.quizid=a.quizid and a.emailid=u.email and u.lastname='".$u_ln."' GROUP BY a.emailid) as t1";
		$e=$e." FROM mdl_user as a,mdl_quiz_attempts as t,mdl_user as u where t.userid=a.id and a.email=u.email  and u.lastname='".$u_ln."' GROUP BY a.email) as t2 on t1.em1=t2.em2";
                $final="select t1.*,t2.* from ".$m." left outer join".$e." union all"." select t1.*,t2.* from ".$m." right outer join".$e." where t1.em1 is null";
		$retval = mysql_query( $final, $conn );
		if($users=$DB->get_records_sql($final))
                {
                        foreach($users as $u)
                        {
                                $temp1=$u->em1;$temp2=$u->f1;$temp3=$u->l1;
                                if(!strcmp($temp1,NULL))
                                {
                                        $temp1=$u->em2;
                                        $temp2=$u->f2;
                                        $temp3=$u->l2;
                                }
                                $tv=array();// array to store grades(values) from both tables
				for($i=3;$i<3+$counte;$i++)
                                        {
                                        $a=mysql_field_name($retval,$i);

                                        array_push($tv,round($u->$a));
                                        }
                                for($i=3+3+$counte;$i<6+$counte+$countm;$i++)
                                        {
                                        $a=mysql_field_name($retval,$i);

                                        array_push($tv,round($u->$a));
                                        }
                                $table->data[]=$tv;
                        }
                }
        }
	if(!empty($table->data))
	 {
		echo html_writer::table($table);
	 }

} //else ends here
//closing connection
mysql_close($conn);
//displays footer
echo $OUTPUT->footer();
?>
