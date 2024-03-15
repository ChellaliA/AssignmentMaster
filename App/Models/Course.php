<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use App\Exceptions\DatabaseException;


class Course extends ModelsModel
{

    protected $table = 'courses';

    public function __construct()
    {
    }


    public function createCourse($data)
    {
        $query = "
            INSERT INTO Courses (course_name, course_description, teacher_id)
            VALUES (:course_name, :course_description, :teacher_id);
        ";
        $params = [
            ':course_name' => $data['course_name'],
            ':course_description' => $data['course_description'],
            ':teacher_id' => $data['teacher_id']
        ];
        return $this->executeSQL($query, 'insert', $params);
    }
    
    public function getTeacherCreatedCourses(int $teacherId)
    {

        $query = "
            SELECT
            c.course_id,
            c.course_name,
            c.course_description,
            COUNT(DISTINCT e.student_id) AS total_enrollments,
            COUNT(DISTINCT a.assignment_id) AS total_assignments
        FROM
            Courses c
        LEFT JOIN
            Enrollments e ON c.course_id = e.course_id
        LEFT JOIN
            Assignments a ON c.course_id = a.course_id
        WHERE
            c.teacher_id = :teacher_id
        GROUP BY
            c.course_id,
            c.course_name,
            c.course_description;";
        $params = [':teacher_id' => $teacherId];
        return $this->executeSQL($query, 'fetchAll', $params);
    }
}
