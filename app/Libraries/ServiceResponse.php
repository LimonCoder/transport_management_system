<?php

namespace App\Libraries;

class ServiceResponse
{
    public $isSuccess;
    public $message;
    public $data;
    public $errors;
    public $statusCode;

    public function __construct(bool $success = true, string $message = '', $data = null, $errors = null, int $statusCode = 200)
    {
        $this->isSuccess = $success;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    /**
     * Create a success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return ServiceResponse
     */
    public static function success(string $message = 'Success', int $statusCode = 200, $data = null): self
    {
        return new self(true, $message, $data, null, $statusCode);
    }

    /**
     * Create an error response
     *
     * @param string $message
     * @param mixed $errors
     * @param int $statusCode
     * @return ServiceResponse
     */
    public static function error(string $message = 'Something went wrong', $errors = null, int $statusCode = 500): self
    {
        return new self(false, $message, null, $errors, $statusCode);
    }

} 