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

  
  
}
