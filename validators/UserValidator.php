<?php
namespace Validators;

use Core\Validator;

class UserValidator extends Validator
{
    public $validated = [];

    public function __construct($request)
    {
        unset($request['__url']);
        $_SESSION['__OLD'] = $request;
        $_SESSION['__REQUEST_VALIDATED'] = $this->validated($request);
    }

    protected function validated($request)
    {
        $data = [
            'name' => isset($request['name']) ? $request['name'] : null,
            'email' => isset($request['email']) ? $request['email'] : null,
            'remember_token' => 12313,
            'password' => md5(12313),
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'remember_token' => 'required',
            'password' => 'required'
        ];

        if ($this->validate($data, $rules)) {
            $this->validated = $data;
        }

        return $this->validated;
    }

    public function setMessage($message){
        $_SESSION['__SUCCESS'] = $message;
    }
}
?>
