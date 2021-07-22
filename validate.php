<?php

namespace App;

class ObjectValidator {

    private $validationresult;

    public function __construct() {

        $this->validationresult = new ValidationResult;
    }

    public function validate($data) {

        foreach ($data->get_params() as $key => $value) {
            switch ($key) {
                case 'firstname':
                case 'lastname':
                    $this->validateName($key, $value);
                    break;
                case 'email':
                    break;
                case 'age':
                    $this->validateAge($key, $value);
                    break;
            }
        }

        return $this->validationresult->getErrors();
    }

    private function validateName($key, $value) {

        $name = trim($value);

        if (empty($name)) {
            $this->validationresult->addError($key.' cannot be empty');
        } else if (preg_match('~[0-9]+~', $name)) {
            $this->validationresult->addError($key.' must be string');
        } else if (strlen($name) < 2 || strlen($name) > 10) {
            $this->validationresult->addError($key.' is too short or long');
        }
    }

    private function validateAge($key, $value) {

        $age = $value;

        if (!is_numeric($age)) {
            $this->validationresult->addError($key.' must be numeric');
        } else if ($age < 20 || $age > 60) {
            $this->validationresult->addError($key.' is too high or low');
        }
    }
}

class ValidationResult {

    private $result = array();

    public function isValid() {
    }
    
    public function addError(string $error) {
        $this->result['errors'][] = $error;
    }
    
    public function getErrors() {
        return $this->result;
    }
}
