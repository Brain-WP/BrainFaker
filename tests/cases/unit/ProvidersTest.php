<?php # -*- coding: utf-8 -*-
/*
 * This file is part of the BrainFaker package.
 *
 * (c) Giuseppe Mazzapica
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Brain\Faker\Tests\Unit;

use Brain\Faker\Providers;
use Brain\Faker\Tests\TestCase;
use Faker\Factory;

/**
 * @runTestsInSeparateProcesses
 */
class ProvidersTest extends TestCase
{
    public function testAddProviderClassFailsForNotProviderClass()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessageRegExp('/class/');

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass(__CLASS__, 'bar', 'baz');
    }

    public function testAddProviderClassFailsForNotExistentClass()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessageRegExp('/class/');

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass('Meh', 'bar', 'baz');
    }

    public function testAddProviderClassFailsForMalformedClass()
    {
        $this->expectExceptionMessageRegExp('/class/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    protected function __invoke(array $args = []) {
    }
}
PHP;
        @eval($php);

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass(ExampleClass::class, 'a', 'b');
    }

    public function testAddProviderClassFailsForNotInstantiableClass()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessageRegExp('/not a valid provider class/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

abstract class ThisClassIsAbstract extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass(ThisClassIsAbstract::class, 'foo', 'bar');
    }

    public function testAddProviderClassFailsForReservedMethodOne()
    {
        $this->expectExceptionMessageRegExp('/reserved method/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass(ExampleClass::class, 'wp', 'bar');
    }

    public function testAddProviderClassFailsForReservedMethodMany()
    {
        $this->expectExceptionMessageRegExp('/reserved method/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass(ExampleClass::class, 'foo', '__call');
    }

    public function testAddProviderClassFailsForNotUniqueClass()
    {
        $this->expectExceptionMessageRegExp('/uniquely identify/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ClassOne extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
    }
}

class ClassTwo extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass(ClassOne::class, 'foo', 'notUnique');
        $provider->__addProviderClass(ClassTwo::class, 'notUnique', 'baz');
        $provider->wp()->notUnique();
    }

    public function testAddProviderClassSuccessfully()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        static::assertSame(
            $provider,
            $provider->__addProviderClass(ExampleClass::class, 'one', 'many')
        );
    }

    public function testCallNotRegisteredMethod()
    {
        $this->expectExceptionMessageRegExp('/undefined method/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['name' => 'one'];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $provider->wp()->foo();
    }

    public function testCallOne()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['name' => 'one'];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $result = $provider->wp()->one();

        static::assertInstanceOf(\stdClass::class, $result);
        static::assertSame('one', $result->name);
    }

    public function testCallManyFailsIfNoNumber()
    {
        $this->expectExceptionMessageRegExp('/number/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['name' => 'one'];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $provider->wp()->many('meh');
    }

    public function testCallManyFailsIfNoArray()
    {
        $this->expectExceptionMessageRegExp('/array/');

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['name' => 'one'];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $provider->wp()->many(1, 'meh');
    }

    public function testCallMany()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['name' => 'one'];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $result = $provider->wp()->many(7);

        static::assertIsArray($result);
        static::assertCount(7, $result);

        $last = null;
        foreach ($result as $element) {
            static::assertNotSame($last, $element);
            static::assertInstanceOf(\stdClass::class, $element);
            static::assertSame('one', $element->name);
            $last = $element;
        }
    }

    public function testCallManyWithDefaults()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['name' => 'one'];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $result = $provider->wp()->many();

        static::assertIsArray($result);

        foreach ($result as $element) {
            static::assertSame('one', $element->name);
        }
    }

    public function testCallManyReturnEmptyArrayIfRequiringZeroItems()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['name' => 'one'];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');

        static::assertSame([], $provider->wp()->many(0));
    }

    public function testCallOneWithArgs()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        $args['foo'] = $this->generator->word;
        $args['bar'] = $this->uniqueGenerator->word;
        return (object)$args;
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $result = $provider->wp()->one(['hello' => 'world']);

        static::assertInstanceOf(\stdClass::class, $result);
        static::assertSame('world', $result->hello);
        static::assertIsString($result->foo);
        static::assertIsString($result->bar);
    }

    public function testCallOneViaProperty()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        $args or $args = ['default' => 'Yes!'];
        $args['foo'] = $this->generator->word;
        $args['bar'] = $this->uniqueGenerator->word;
        
        return (object)$args;
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $result = $provider->wp()->one;

        static::assertInstanceOf(\stdClass::class, $result);
        static::assertSame('Yes!', $result->default);
        static::assertIsString($result->foo);
        static::assertIsString($result->bar);
    }

    public function testCallManyViaProperty()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        $args or $args = ['default' => 'Yes sir'];
        
        return (object)$args;
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'one', 'many');
        $result = $provider->wp()->many;

        static::assertIsArray($result);
    }

    public function testAtLeast()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)[];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'item', 'items');
        $result = $provider->wp()->atLeast3items();

        static::assertIsArray($result);
        static::assertGreaterThanOrEqual(3, count($result));
    }

    public function testAtMost()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleOne extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)[];
    }
}

class ExampleTwo extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)[];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleOne::class, 'post', 'posts');
        $provider->__addProviderClass(ExampleTwo::class, 'user', 'users');
        $atMost2posts = $provider->wp()->atMost2posts();
        $atMost3users = $provider->wp()->atMost3users();
        $atMost1users = $provider->wp()->atMost1users();
        $atMost0posts = $provider->wp()->atMost0posts();

        static::assertIsArray($atMost2posts);
        static::assertIsArray($atMost3users);
        static::assertIsArray($atMost1users);
        static::assertSame([], $atMost0posts);
        static::assertContains(count($atMost2posts), [0, 1, 2]);
        static::assertContains(count($atMost3users), [0, 1, 2, 3]);
        static::assertContains(count($atMost1users), [0, 1]);
    }

    public function testAtLeastAndAtMostDynamic()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)[];
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'thing', 'things');

        $atLeastOneThing = $provider->wp()->atLeastOneThing();
        $atLeastTwoThings = $provider->wp()->atLeastTwoThings();
        $atLeastThreeThings = $provider->wp()->atLeastThreeThings();
        $atLeastFourThings = $provider->wp()->atLeastFourThings();
        $atLeastFiveThings = $provider->wp()->atLeastFiveThings();

        $atMostOneThing = $provider->wp()->atMostOneThing();
        $atMostTwoThings = $provider->wp()->atMostTwoThings();
        $atMostThreeThings = $provider->wp()->atMostThreeThings();
        $atMostFourThings = $provider->wp()->atMostFourThings();
        $atMostFiveThings = $provider->wp()->atMostFiveThings();

        static::assertIsArray($atLeastOneThing);
        static::assertIsArray($atLeastTwoThings);
        static::assertIsArray($atLeastThreeThings);
        static::assertIsArray($atLeastFourThings);
        static::assertIsArray($atLeastFiveThings);
        static::assertIsArray($atMostOneThing);
        static::assertIsArray($atMostTwoThings);
        static::assertIsArray($atMostThreeThings);
        static::assertIsArray($atMostFourThings);
        static::assertIsArray($atMostFiveThings);

        static::assertGreaterThanOrEqual(1, count($atLeastOneThing));
        static::assertGreaterThanOrEqual(2, count($atLeastTwoThings));
        static::assertGreaterThanOrEqual(3, count($atLeastThreeThings));
        static::assertGreaterThanOrEqual(4, count($atLeastFourThings));
        static::assertGreaterThanOrEqual(5, count($atLeastFiveThings));

        static::assertLessThanOrEqual(1, count($atMostOneThing));
        static::assertLessThanOrEqual(2, count($atMostTwoThings));
        static::assertLessThanOrEqual(3, count($atMostThreeThings));
        static::assertLessThanOrEqual(4, count($atMostFourThings));
        static::assertLessThanOrEqual(5, count($atMostFiveThings));
    }

    public function testBetweenDynamic()
    {
        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)$args;
    }
}
PHP;
        eval($php);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass(ExampleClass::class, 'thing', 'things');

        $allTheThings = [
            [$provider->wp()->betweenOneAndThreeThings(['x' => 'X']), 1, 3],
            [$provider->wp()->betweenFiveAndTwoThings(['x' => 'X']), 2, 5],
            [$provider->wp()->betweenFourAndFourThings(['x' => 'X']), 4, 4],
            [$provider->wp()->between1AndThreeThings(['x' => 'X']), 1, 3],
            [$provider->wp()->between5AndTwoThings(['x' => 'X']), 2, 5],
            [$provider->wp()->between4AndFourThings(['x' => 'X']), 4, 4],
            [$provider->wp()->betweenOneAnd3Things(['x' => 'X']), 1, 3],
            [$provider->wp()->betweenFiveAnd2Things(['x' => 'X']), 2, 5],
            [$provider->wp()->betweenFourAnd4Things(['x' => 'X']), 4, 4],
            [$provider->wp()->between1And3Things(['x' => 'X']), 1, 3],
            [$provider->wp()->between5And2Things(['x' => 'X']), 2, 5],
            [$provider->wp()->between4And4Things(['x' => 'X']), 4, 4],
        ];

        foreach ($allTheThings as [$things, $min, $max]) {
            static::assertIsArray($things);

            foreach ($things as $thing) {
                static::assertInstanceOf(\stdClass::class, $thing);
                static::assertSame('X', $thing->x);
            }

            $count = count($things);

            if ($min === $max) {
                static::assertSame($min, $count);
                continue;
            }

            static::assertGreaterThanOrEqual($min, $count);
            static::assertLessThanOrEqual($max, $count);
        }
    }
}
