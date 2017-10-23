# edx_quiz

Created an integration prototype between IIT-Bombay-X and IIT-Bombay's Moodle (Learning management systems) as part
of India’s national mission on education through ICT.  
Developed a plugin in Moodle using PHP to incorporate out of the box features.

Abstract
IITBX grades are present on the instructor dashboard of the website and can be exported to CSV format from there.  
The CSV file is transferred to Moodle using scp.  
IITBX quiz data is inserted into Moodle’s tables.  
A local plugin is created in Moodle to view the quiz results fromthe course administration menu

Plugin Development
Create the required directory structure for a local plugin.Edit files in the directory with required features.
Change ownership of directory and give it write permissions
Install the plugin from Moodle’s admin interface.
Update the database from Moodle’s XMLDB editor.Add the plugin to the course administration block.

Database Description
Custom tables in Moodle:-
mdl-edX-quiz:  To store the quiz details from IITBX.
mdl-edX-quiz-result:  To store the quiz results from IITBX

Inbuilt tables in Moodle:-
mdl-user:User details
mdl-quiz:Quiz details
mdl-quiz-attempts:Details of quiz attempts in Moodle
mdl-user-enrolments:Course enrolment details of users
mdl-role-assignments:Assigns a role number to each role inMoodle

