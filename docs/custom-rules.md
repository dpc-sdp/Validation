# Custom rules

You can also create and use your own rules. To do this, you will need to create
a rule and an exception to go with the rule.

To create a rule, you need to create a class that extends the AbstractRule class
and is within the Rules `namespace`. When the rule is called the logic inside the
validate method will be executed. Here's how the class should look:

```php
namespace My\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Attributes\Template;

#[Template(
    '{{name}} is something',
    '{{name}} is not something',
)]
final class Something extends AbstractRule
{
    public function validate(mixed $input): bool
    {
        // Do something here with the $input and return a boolean value
    }
}
```

The `'{{name}} is not something` message would be used then you call the rule
with the `not()`.

All classes in Validation are created by the `Factory` class. If you want
Validation to execute your rule (or rules) in the chain, you must overwrite the
default `Factory`.

```php
Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('My\\Validation\\Rules')
);
v::something(); // Try to load "My\Validation\Rules\Something" if any
```
