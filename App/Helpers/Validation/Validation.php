<?php

namespace App\Helpers\validation;

use DateTime;

abstract class Validation
{


    public function __construct()
    {
    }


    protected function validate($inputData, $rules)
    {
        $errors = [];
        $rulesCallbacks = [
            'required' => 'validateRequired',
            'email' => 'validateEmail',
            'num' => 'validateNumber',
            'min' => 'validateMin',
            'max' => 'validateMax',
            'unique' => 'validateUnique',
            'date' => 'validateDate',
            'enum' => 'validateEnum'
        ];

        foreach ($rules as $field => $rule) {
            $rulesList = explode('|', $rule);

            foreach ($rulesList as $singleRule) {
                $ruleParts = explode(':', $singleRule);
                $callbackFunction = $rulesCallbacks[$ruleParts[0]];
                $error = $this->$callbackFunction($field, $inputData, $ruleParts);

                if ($error) {
                    $errors[$field] = $error;
                    break; // Break inner loop if there is any error
                }
            }
        }

        return $errors;
    }

    // Helper functions
    private function validateRequired($field, $inputData, $ruleParts)
    {
        if (!isset($inputData[$field])) {
            return ucfirst($field) . ' field is required.';
        }
    }

    private function validateEmail($field, $inputData, $ruleParts)
    {
        if (isset($inputData[$field]) && !filter_var($inputData[$field], FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email format.';
        }
    }

    private function validateNumber($field, $inputData, $ruleParts)
    {
        if (isset($inputData[$field]) && !filter_var($inputData[$field], FILTER_VALIDATE_INT)) {
            return 'Invalid num format.';
        }
    }

    private function validateMin($field, $inputData, $ruleParts)
    {
        if (isset($inputData[$field]) && strlen($inputData[$field]) < $ruleParts[1]) {
            return ucfirst($field) . ' field must be at least ' . $ruleParts[1] . ' characters.';
        }
    }

    private function validateMax($field, $inputData, $ruleParts)
    {
        if (isset($inputData[$field]) && strlen($inputData[$field]) > $ruleParts[1]) {
            return ucfirst($field) . ' field must not be longer than ' . $ruleParts[1] . ' characters.';
        }
    }

    private function validateUnique($field, $inputData, $ruleParts)
    {
        static $previousValues = []; // keep track of previous values
        if (isset($inputData[$field]) && in_array($inputData[$field], $previousValues)) {
            return ucfirst($field) . ' field must be unique.'; // compare against previous values
        }
        $previousValues[] = $inputData[$field]; // store the value for future comparison
    }

    private function validateDate($field, $inputData, $ruleParts)
    {
        $dateFormat = $ruleParts[1] ?? 'Y-m-d'; // default date format if not provided
        if (isset($inputData[$field])) {
            $dateObj = DateTime::createFromFormat($dateFormat, $inputData[$field]);
            if (!$dateObj || $dateObj->format($dateFormat) !== $inputData[$field]) {
                return 'Invalid date format. Expected format: ' . $dateFormat;
            }
        } else {
            return ucfirst($field) . ' field is required.';
        }
    }

    private function validateEnum($field, $inputData, $ruleParts)
    {
        
        $allowedValues = explode(',', $ruleParts[1]); // Get the allowed values from the rule parts array
        if (!in_array($inputData[$field], $allowedValues)) {
            return ucfirst($field) . ' field must be one of the following values: ' . implode(', ', $allowedValues) . '.';
        }
    }
}
