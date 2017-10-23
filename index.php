<?php
/* 
 * This is a one-line short description of the file
 * This file displays two links on the index page to quiz result and final result.
 * @package    local_edx_quiz
 * @copyright  2015 SummerInterns
*/

//header files
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_login();
global $USER,$DB;
$url=new moodle_url('/local/edx_quiz/index.php');
//Set up page object
$strtitle='edX_grade';
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
$PAGE->set_title($strtitle);
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading($strtitle);

//outputAPI which sends output to the browser, $OUTPUT object is used here
echo $OUTPUT->header();
?>
<!DOCTYPE html>
<html>
<body>
<a href="/moodle/local/edx_quiz/quizResult.php" target="_blank">Quiz Result</a><br>
<a href="/moodle/local/edx_quiz/finalResult.php" target="_blank">Final Result</a>
</body>
</html>
<?php
echo $OUTPUT->footer();
?>
