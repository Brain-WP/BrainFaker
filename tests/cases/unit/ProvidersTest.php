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
        $this->expectExceptionMessageMatches('/class/');

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass(__CLASS__, 'bar', 'baz');
    }

    public function testAddProviderClassFailsForNotExistentClass()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessageMatches('/class/');

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass('Meh', 'bar', 'baz');
    }

    public function testAddProviderClassFailsForMalformedClass()
    {
        $this->expectExceptionMessageMatches('/class/');

        $class = $this->declarePhpClass(null, null, 'protected');

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass($class, 'a', 'b');
    }

    public function testAddProviderClassFailsForNotInstantiableClass()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessageMatches('/not a valid provider class/');

        $class = $this->declarePhpClass(null, null, null, 'abstract');

        $provider = new Providers(Factory::create());
        /** @noinspection PhpUndefinedClassInspection */
        $provider->__addProviderClass($class, 'foo', 'bar');
    }

    public function testAddProviderClassFailsForReservedMethodOne()
    {
        $this->expectExceptionMessageMatches('/reserved method/');

        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass($class, 'wp', 'bar');
    }

    public function testAddProviderClassFailsForReservedMethodMany()
    {
        $this->expectExceptionMessageMatches('/reserved method/');

        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass($class, 'foo', '__call');
    }

    public function testAddProviderClassFailsForNotUniqueClass()
    {
        $this->expectExceptionMessageMatches('/uniquely identify/');

        $class1 = $this->declarePhpClass('ClassOne');
        $class2 = $this->declarePhpClass('ClassTwo');

        $provider = new Providers(Factory::create());
        $provider->__addProviderClass($class1, 'foo', 'notUnique');
        $provider->__addProviderClass($class2, 'notUnique', 'baz');

        /** @noinspection PhpUndefinedMethodInspection */
        $provider->wp()->notUnique();
    }

    public function testAddProviderClassSuccessfully()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        static::assertSame($provider, $provider->__addProviderClass($class, 'one', 'many'));
    }

    public function testCallNotRegisteredMethod()
    {
        $this->expectExceptionMessageMatches('/undefined method/');

        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');

        /** @noinspection PhpUndefinedMethodInspection */
        $provider->wp()->foo();
    }

    public function testCallOne()
    {
        $class = $this->declarePhpClass(null, 'return (object)["name" => "one"];');

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');
        /** @noinspection PhpUndefinedMethodInspection */
        $result = $provider->wp()->one();

        static::assertInstanceOf(\stdClass::class, $result);
        static::assertSame('one', $result->name);
    }

    public function testCallManyFailsIfNoNumber()
    {
        $this->expectExceptionMessageMatches('/number/');

        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');
        /** @noinspection PhpUndefinedMethodInspection */
        $provider->wp()->many('meh');
    }

    public function testCallManyFailsIfNoArray()
    {
        $this->expectExceptionMessageMatches('/array/');

        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');
        /** @noinspection PhpUndefinedMethodInspection */
        $provider->wp()->many(1, 'meh');
    }

    public function testCallMany()
    {
        $invoke = <<<'PHP'
$args['str'] = $this->uniqueGenerator->word();
$args['num'] = $this->generator->randomNumber();
return (object)$args;
PHP;

        $class = $this->declarePhpClass(null, $invoke);

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');

        /** @noinspection PhpUndefinedMethodInspection */
        $result = $provider->wp()->many(7);

        static::assertIsArray($result);
        static::assertCount(7, $result);

        $last = null;
        foreach ($result as $element) {
            static::assertNotSame($last, $element);
            static::assertInstanceOf(\stdClass::class, $element);
            static::assertIsString($element->str);
            static::assertIsInt($element->num);
            $last = $element;
        }
    }

    public function testCallManyWithDefaults()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');
        /** @noinspection PhpUndefinedMethodInspection */
        $result = $provider->wp()->many();

        static::assertIsArray($result);

        foreach ($result as $element) {
            static::assertInstanceOf(\stdClass::class, $element);
        }
    }

    public function testCallManyReturnEmptyArrayIfRequiringZeroItems()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');

        /** @noinspection PhpUndefinedMethodInspection */
        static::assertSame([], $provider->wp()->many(0));
    }

    public function testCallOneWithArgs()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');

        /** @noinspection PhpUndefinedMethodInspection */
        $result = $provider->wp()->one(['hello' => 'world']);

        static::assertInstanceOf(\stdClass::class, $result);
        static::assertSame('world', $result->hello);
    }

    public function testCallOneViaProperty()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');

        static::assertInstanceOf(\stdClass::class, $provider->wp()->one);
    }

    public function testCallManyViaProperty()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'one', 'many');

        static::assertIsArray($provider->wp()->many);
    }

    public function testAtLeast()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'item', 'items');
        /** @noinspection PhpUndefinedMethodInspection */
        $result = $provider->wp()->atLeast3items();

        static::assertIsArray($result);
        static::assertGreaterThanOrEqual(3, count($result));
    }

    public function testAtMost()
    {
        $class1 = $this->declarePhpClass('ExampleOne');
        $class2 = $this->declarePhpClass('ExampleTwo');

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class1, 'post', 'posts');
        $provider->__addProviderClass($class2, 'user', 'users');

        /** @noinspection PhpUndefinedMethodInspection */
        $atMost2posts = $provider->wp()->atMost2posts();
        /** @noinspection PhpUndefinedMethodInspection */
        $atMost3users = $provider->wp()->atMost3users();
        /** @noinspection PhpUndefinedMethodInspection */
        $atMost1users = $provider->wp()->atMost1users();
        /** @noinspection PhpUndefinedMethodInspection */
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
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'thing', 'things');

        /** @noinspection PhpUndefinedMethodInspection */
        $atLeastOneThing = $provider->wp()->atLeastOneThing();
        /** @noinspection PhpUndefinedMethodInspection */
        $atLeastTwoThings = $provider->wp()->atLeastTwoThings();
        /** @noinspection PhpUndefinedMethodInspection */
        $atLeastThreeThings = $provider->wp()->atLeastThreeThings();
        /** @noinspection PhpUndefinedMethodInspection */
        $atLeastFourThings = $provider->wp()->atLeastFourThings();
        /** @noinspection PhpUndefinedMethodInspection */
        $atLeastFiveThings = $provider->wp()->atLeastFiveThings();

        /** @noinspection PhpUndefinedMethodInspection */
        $atMostOneThing = $provider->wp()->atMostOneThing();
        /** @noinspection PhpUndefinedMethodInspection */
        $atMostTwoThings = $provider->wp()->atMostTwoThings();
        /** @noinspection PhpUndefinedMethodInspection */
        $atMostThreeThings = $provider->wp()->atMostThreeThings();
        /** @noinspection PhpUndefinedMethodInspection */
        $atMostFourThings = $provider->wp()->atMostFourThings();
        /** @noinspection PhpUndefinedMethodInspection */
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
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'thing', 'things');

        $allTheThings = [
            ['betweenOneAndThreeThings', 1, 3],
            ['betweenFiveAndTwoThings', 2, 5],
            ['betweenFourAndFourThings', 4, 4],
            ['between1AndThreeThings', 1, 3],
            ['between5AndTwoThings', 2, 5],
            ['between4AndFourThings', 4, 4],
            ['betweenOneAnd3Things', 1, 3],
            ['betweenFiveAnd2Things', 2, 5],
            ['betweenFourAnd4Things', 4, 4],
            ['between1And3Things', 1, 3],
            ['between5And2Things', 2, 5],
            ['between4And4Things', 4, 4],
        ];

        foreach ($allTheThings as [$method, $min, $max]) {
            $things = $provider->wp()->{$method}(['x' => 'X']);

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

    public function testBetweenDynamicWrongEdgeCases()
    {
        $class = $this->declarePhpClass();

        $provider = new Providers(Factory::create());

        $provider->__addProviderClass($class, 'thing', 'things');

        $methods = [
            'atLeastOneAndThreeThings',
            'atMost1And3Things',
            'atMostOneMeh',
            'between2Things',
            'between2And3Stuff',
        ];

        $expected = count($methods);
        $exceptionsCount = 0;

        try {
            execute: {
                $method = array_shift($methods);
                $provider->wp()->{$method}();
            }
        } catch (\Error $error) {
            static::assertRegExp('/undefined method/', $error->getMessage());
            $exceptionsCount++;
            if ($methods) {
                goto execute;
            }
        }

        static::assertSame($expected, $exceptionsCount);
    }

    /**
     * @param string $name
     * @param string|null $invokeBody
     * @param string $invokeVisibility
     * @param string|null $classModifier
     * @return string
     */
    private function declarePhpClass(
        ?string $name = null,
        ?string $invokeBody = null,
        ?string $invokeVisibility = null,
        ?string $classModifier = null
    ): string {

        isset($name) or $name = 'ExampleClass';
        isset($invokeBody) or $invokeBody = 'return (object)$args;';
        isset($invokeVisibility) or $invokeVisibility = 'public';
        isset($classModifier) or $classModifier = '';

            $php = <<<PHP
namespace Brain\Faker\Tests\Unit;

{$classModifier} class {$name} extends \Brain\Faker\Provider\Provider {
    {$invokeVisibility} function __invoke(array \$args = []) {
        {$invokeBody}
    }
}
PHP;
        @eval($php); // phpcs:ignore

        return "\\Brain\\Faker\\Tests\\Unit\\{$name}";
    }
}
