<?php

namespace App\Models;

use App\Models\Model as ModelsModel;


class Assignment extends ModelsModel
{

    protected $table = 'assignments';

    public function __construct()
    {
    }

    public function createAssignment($data)
    {
        $query = "
          INSERT INTO Assignments (assignment_name, assignment_description, due_date, course_id)
          VALUES (:assignment_name, :assignment_description, :due_date, :course_id);
      ";
        $params = [
            ':assignment_name' => $data['assignment_name'],
            ':assignment_description' => $data['assignment_description'],
            ':due_date' => $data['due_date'],
            ':course_id' => $data['course_id']
        ];
        return $this->executeSQL($query, 'insert', $params);
    }


    public function getAssignmentInfoForStudent($assignmentId, $studentId)
    {
        $query = "
            SELECT
                a.assignment_id,
                a.assignment_name,
                a.assignment_description,
                a.due_date,
                c.course_id,
                c.course_name,
                s.submission_id,
                CASE
                    WHEN s.submission_id IS NOT NULL THEN 'Submitted'
                    ELSE 'Not Submitted'
                END AS submission_status
            FROM
                Assignments a
            INNER JOIN
                Courses c ON a.course_id = c.course_id
            LEFT JOIN
                Submissions s ON a.assignment_id = s.assignment_id
                               AND s.student_id = :student_id
            WHERE
                a.assignment_id = :assignment_id;
        ";
        $params = [
            ':assignment_id' => $assignmentId,
            ':student_id' => $studentId // Assuming you have access to the student ID in this method
        ];
        return $this->executeSQL($query, 'fetch', $params);
    }
    
    public function getAssignmentInfoForTeacher($assignmentId)
    {
        $query = "
                SELECT
                    a.assignment_id,
                    a.assignment_name,
                    a.assignment_description,
                    a.due_date,
                    c.course_id,
                    c.course_name,
                    COUNT(s.submission_id) AS submission_count
                FROM
                    Assignments a
                INNER JOIN
                    Courses c ON a.course_id = c.course_id
                LEFT JOIN
                    Submissions s ON a.assignment_id = s.assignment_id
                WHERE
                    a.assignment_id = :assignment_id
                GROUP BY
                    a.assignment_id, c.course_id;
            ";
        $params = [':assignment_id' => $assignmentId];
        return $this->executeSQL($query, 'fetch', $params);
    }



    public function getAssignmentsForTeacher($courseId)
    {
        $query = "
            SELECT
                a.assignment_id,
                a.assignment_name,
                a.assignment_description,
                a.due_date,
                a.created_at,
                COUNT(s.submission_id) AS submission_count
            FROM
                Assignments a
            LEFT JOIN
                Submissions s ON a.assignment_id = s.assignment_id
            WHERE
                a.course_id = :course_id
            GROUP BY
                a.assignment_id
            ORDER BY
                a.created_at;
        ";
        $params = [':course_id' => $courseId];
        return $this->executeSQL($query, 'fetchAll', $params);
    }



    public function getAssignmentsForStudent($courseId, $studentId)
    {
        $query = "
        SELECT
            a.assignment_id,
            a.assignment_name,
            a.assignment_description,
            a.due_date,
            s.submission_id,
            s.submission_date,
            s.evaluation,
            CASE
                WHEN s.submission_id IS NOT NULL THEN 'Submitted'
                ELSE 'Not Submitted'
            END AS submission_status
        FROM
            Assignments a
        LEFT JOIN
            Submissions s ON a.assignment_id = s.assignment_id AND s.student_id = :student_id
        WHERE
            a.course_id = :course_id;";
        $params = [
            ':course_id' => $courseId,
            ':student_id' => $studentId
        ];
        return $this->executeSQL($query, 'fetchAll', $params);
    }
}
