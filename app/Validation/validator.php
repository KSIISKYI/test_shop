<?php

use Rakit\Validation\Validator;
use App\Validation\Rules\EmailAvailable;

$validator = new Validator;
$validator->addValidator('emailAvailable', new EmailAvailable);

return $validator;
