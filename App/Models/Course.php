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



    // get course information for a student, including teacher information, 
    // the number of enrolled students, and the number of assignments related to it
    public function getCourseInfoForStudent($courseId)
    {
        $query = "
            SELECT
                c.course_id,
                c.course_name,
                c.course_description,
                c.teacher_id,
                t.teacher_name,
                t.teacher_lastname,
                t.eacher_number,
                COUNT(DISTINCT e.student_id) AS enrolled_students,
                COUNT(DISTINCT a.assignment_id) AS assignments_count
            FROM
                Courses c
            LEFT JOIN
                Teachers t ON c.teacher_id = t.teacher_id
            LEFT JOIN
                Enrollments e ON c.course_id = e.course_id
            LEFT JOIN
                Assignments a ON c.course_id = a.course_id
            WHERE
                c.course_id = :course_id
            GROUP BY
                c.course_id;
        ";
        $params = [':course_id' => $courseId];
        return $this->executeSQL($query, 'fetch', $params);
    }
    


    // get course information for a teacher, 
    // including the number of enrolled students and the number of assignments related to it.
    public function getCourseInfoForTeacher($courseId)
    {
        $query = "
            SELECT
                c.course_id,
                c.course_name,
                c.course_description,
                c.teacher_id,
                COUNT(DISTINCT e.student_id) AS enrolled_students,
                COUNT(DISTINCT a.assignment_id) AS assignments_count
            FROM
                Courses c
            LEFT JOIN
                Enrollments e ON c.course_id = e.course_id
            LEFT JOIN
                Assignments a ON c.course_id = a.course_id
            WHERE
                c.course_id = :course_id
            GROUP BY
                c.course_id;
        ";
        $params = [':course_id' => $courseId];
        return $this->executeSQL($query, 'fetch', $params);
    }
    
}
