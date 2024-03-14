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
        $allowed_fields = ['email', 'mot_passe'];
        $inputData = array_intersect_key($inputData, array_flip($allowed_fields));
        $inputData = $this->sanitizeInput($inputData);
        $rules = [
            'email' => 'required|email|max:255',
            'mot_passe' => 'required|min:4',
        ];

        return $this->validate($inputData, $rules);
    }

    public function SignUpValidate($inputData)
    {
        $inputData = $this->sanitizeInput($inputData);
        $allowed_fields = ['email', 'mot_passe','nom','prenom','date_naissance','ville','telephone'];
        $inputData = array_intersect_key($inputData, array_flip($allowed_fields));
        $inputData = $this->sanitizeInput($inputData);
        $rules = [
            'email' => 'required|email|max:255',
            'mot_passe' => 'required|min:4',
            'nom' => 'required|max:50',
            'prenom' => 'required|max:50',
            'date_naissance'=>'required|date|max:10',
            'telephone'=>'required|num|max:10',
            'ville'=>'required|num|max:10',
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
