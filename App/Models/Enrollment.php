<?php

namespace App\Models;

use App\Models\Model as ModelsModel;


class Enrollment extends ModelsModel
{

  protected $table = 'enrollments';

  public function __construct()
  {
  }
  public function getEnrolledStudents($courseId)
  {
    $query = "
          SELECT
              s.student_id,
              s.student_name,
              s.student_lastname,
              s.student_number,
              e.attempt_date,
              e.response_date,
              e.state
          FROM
              Enrollments e
          INNER JOIN
              Students s ON e.student_id = s.student_id
          WHERE
              e.course_id = :course_id
          AND
              e.state = 'accepted';
      ";
    $params = [':course_id' => $courseId];
    return $this->executeSQL($query, 'fetchAll', $params);
  }

  public function getPendingStudents($courseId)
{
    $query = "
        SELECT
            s.student_id,
            s.student_name,
            s.student_lastname,
            s.student_number,
            e.attempt_date,
            e.response_date,
            e.state
        FROM
            Enrollments e
        INNER JOIN
            Students s ON e.student_id = s.student_id
        WHERE
            e.course_id = :course_id
        AND
            e.state = 'pending';
    ";
    $params = [':course_id' => $courseId];
    return $this->executeSQL($query, 'fetchAll', $params);
}

}
