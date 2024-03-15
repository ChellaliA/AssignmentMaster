<?php

// Define the base URL
define('BASE_URL', 'http://localhost/AssignmentMaster');

// Define the login URL
define('LOGIN_URL', BASE_URL . '/login');





// Define the teacher dashboard URL
define('TEACHER_DASHBOARD_URL', BASE_URL . '/teacher/dashboard');

// Define the teacher course URL create/view/edit
define('TEACHER_COURSE_URL', BASE_URL . '/teacher/courses');

// Define the teacher assignment URL create/view/edit
define('TEACHER_ASSIGNMENT_URL', BASE_URL . '/teacher/assignments');

// Define the teacher submission URL view/evaluate
define('TEACHER_SUBMISSION_URL', BASE_URL . '/teacher/assignment/submissions');




// Define the student dashboard URL
define('STUDENT_DASHBOARD_URL', BASE_URL . '/student/dashboard');

// Define the student course URL
define('STUDENT_COURSE_URL', BASE_URL . '/student/courses');

// Define the student assignment URL
define('STUDENT_ASSIGNMENT_URL', BASE_URL . '/student/assignments');

// Define the student submission URL create/view/edit
define('STUDENT_SUBMISSION_URL', BASE_URL . '/student/assignment/submissions');




// Define DB connection information
define('DB_HOST', 'localhost');
define('DB_NAME', 'assignmentmasterdb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');



define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);