<?php

namespace App\Models;

use App\Models\Model as ModelsModel;


class User extends ModelsModel
{

  protected $table = 'users';

  public function __construct()
  {
  }

  public function getUserByUsername($username)
  {
      $query = "
          SELECT
              user_id,
              username,
              password,
              user_type
          FROM
              Users
          WHERE
              username = :username;
      ";
      $params = [':username' => $username];
      return $this->executeSQL($query, 'fetch', $params);
  }
  

}
