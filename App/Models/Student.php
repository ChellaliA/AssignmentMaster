<?php

namespace App\Models;

use App\Models\Model as ModelsModel;


class Student extends ModelsModel
{

  protected $table = 'students';

  public function __construct()
  {
  }

  public function getStudentId($user_id)
  {
      $query = "
          SELECT
              student_id
          FROM
              Students
          WHERE
              user_id = :user_id;
      ";
      $params = [':user_id' => $user_id];
      return $this->executeSQL($query, 'fetch', $params);
  }
  

}
