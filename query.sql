create table mdl_edX_quiz
(quizid integer,
quizname varchar(30),
courseid varchar(20),
maxmarks integer);


create table mdl_edX_quiz_result
(emailid varchar(30),
courseid varchar(20),
quizid integer,
result integer);

insert into mdl_edX_quiz values(1,'Pointers','CS101',10);
insert into mdl_edX_quiz values(2,'Stacks','CS101',10);
insert into mdl_edX_quiz values(3,'Queues','CS101',10);

insert into mdl_edX_quiz_result values('rahul@gmail.com','CS101',1,10);
insert into mdl_edX_quiz_result values('rahul@gmail.com','CS101',2,9);
insert into mdl_edX_quiz_result values('aman@gmail.com','CS101',2,8);
insert into mdl_edX_quiz_result values('aman@gmail.com','CS101',3,10);
insert into mdl_edX_quiz_result values('mappi94@gmail.com','CS101',2,8);
insert into mdl_edX_quiz_result values('mappi94@gmail.com','CS101',3,10);
insert into mdl_edX_quiz_result values('neha@gmail.com','CS101',1,8);
insert into mdl_edX_quiz_result values('neha@gmail.com','CS101',2,10);
insert into mdl_edX_quiz_result values('nidhi@gmail.com','CS101',1,6);
insert into mdl_edX_quiz_result values('nidhi@gmail.com','CS101',3,5);

