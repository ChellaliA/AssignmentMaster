<?php

namespace App\Helpers\Validation;

class Validator extends Validation
{


    public function __construct()
    {
    }

    public function LoginValidate($inputData)
    {
        $inputData = $this->sanitizeInput($inputData);
        $allowed_fields = ['username', 'password'];
        $inputData = array_intersect_key($inputData, array_flip($allowed_fields));
        $inputData = $this->sanitizeInput($inputData);
        $rules = [
            'username' => 'required|min:4|max:255',
            'password' => 'required|min:4',
        ];
        return $this->validate($inputData, $rules);
    }


    
    private function sanitizeInput($inputData)
    {
        foreach ($inputData as $field => $value) {
            $inputData[$field] = htmlspecialchars($value, ENT_QUOTES);
        }
        return $inputData;
    }
}
