--FILE--
<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Respect\Validation\Validator as v;

exceptionMessages(static function (): void {
    v::key('email', v::email()->setTemplate('WRONG EMAIL!!!!!!'))->assert(['email' => 'qwe']);
});
?>
--EXPECT--
Array
(
    [email] => WRONG EMAIL!!!!!!
)
