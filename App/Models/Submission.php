<?php

namespace App\Models;

use App\Models\Model as ModelsModel;


class Submission extends ModelsModel
{

  protected $table = 'submissions';

  public function __construct()
  {
  }

  public function getAssignmentSubmissions($assignmentId)
  {
      $query = "
          SELECT
              s.submission_id,
              s.submission_date,
              s.evaluation,
              s.text_submission,
              st.student_id,
              st.student_name,
              st.student_lastname,
              st.student_number
          FROM
              Submissions s
          INNER JOIN
              Students st ON s.student_id = st.student_id
          WHERE
              s.assignment_id = :assignment_id;
      ";
      $params = [':assignment_id' => $assignmentId];
      return $this->executeSQL($query, 'fetchAll', $params);
  }
  

}
