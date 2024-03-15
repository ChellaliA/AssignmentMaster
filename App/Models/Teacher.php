<?php

namespace App\Models;

use App\Models\Model as ModelsModel;


class Teacher extends ModelsModel
{

  protected $table = 'teachers';

  public function __construct()
  {
  }

  public function getTeacherById($userId)
  {
      $query = "
          SELECT
              t.teacher_id,
              t.teacher_name,
              t.teacher_lastname,
              t.teacher_number
          FROM
              Teachers t
          WHERE
              t.user_id = :user_id;
      ";
      $params = [':user_id' => $userId];
      return $this->executeSQL($query, 'fetch', $params);
  }
  


}
