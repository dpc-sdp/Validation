--TEST--
getMessages() should include all validation messages in a chain
--FILE--
<?php

declare(strict_types=1);

date_default_timezone_set('UTC');

require 'vendor/autoload.php';

use Respect\Validation\Validator;

exceptionMessages(static function (): void {
    $input = [
        'username' => 'u',
        'birthdate' => 'Not a date',
        'password' => '',
    ];

    Validator::create()
        ->key('username', Validator::length(2, 32))
        ->key('birthdate', Validator::dateTime())
        ->key('password', Validator::notEmpty())
        ->key('email', Validator::email())
        ->assert($input);
});
?>
--EXPECT--
Array
(
    [username] => username must have a length between 2 and 32
    [birthdate] => birthdate must be a valid date/time
    [password] => password must not be empty
    [email] => email must be present
)
