<?php

/**
 * Description of Validator
 *
 * @author Nancy
 */
class Validator {

    private $data;
    private $errors = [];

    public function __construct($data) {
        $this->data = $data;
    }

    public function getField($field) {
        if (!isset($this->data[$field])) {
            return null;
        }
        return $this->data[$field];
    }

    public function isAlphanumerique($field, $errorMsg) {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isEmail($field, $errorMsg) {
        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isConfirm($field, $errorMsg) {
        if (empty($this->getField($field)) || $this->getField($field) != $this->getField($field . '_confirm') || strlen($this->getField($field)) < 5) {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isValid() {
        return empty($this->errors);
    }

    public function isUniq($field, $db, $table, $errorMsg) {
        $record = $db->query("SELECT id FROM $table WHERE $field = ?", [$this->getField($field)]);   
        if ($record) {
            $this->errors[$field] = $errorMsg;
        } else {
            $value['username'] = $_POST['username'];
        }
    }

    public function getErrors() {
        return $this->errors;
    }

}
