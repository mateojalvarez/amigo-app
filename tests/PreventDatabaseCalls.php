<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\AssertionFailedError;

/**
 * Trait to prevent database calls in unit tests.
 *
 * This trait must be used in all unit test classes to ensure that no accidental
 * database calls are made. If a test needs to access the database, it should be
 * moved to the integration tests directory.
 *
 * @throws AssertionFailedError When a database call is detected
 *
 * @example
 * class UserTest extends TestCase
 * {
 *     use PreventDatabaseCalls;
 *
 *     public function test_something(): void
 *     {
 *         $this->assertTrue(true);
 *     }
 * }
 */
trait PreventDatabaseCalls
{
    /**
     * Sets up the prevention of database calls.
     * Runs automatically before each test.
     *
     * @throws AssertionFailedError When a database call is detected
     */
    protected function setUp(): void
    {
        parent::setUp();

        DB::beforeExecuting(function ($query) {
            $message = <<<EOF

                   \e[41;1m ERROR \e[0m  \e[1mLlamada a base de datos en test unitario\e[0m

                  \e[33m• Soluciones permitidas:\e[0m
                    \e[32m✓\e[0m Mockear las dependencias que acceden a la base de datos
                    \e[32m✓\e[0m Mover test a:
                        \e[36mtests/Integration/\e[0m


                  \e[33m• Query detectada:\e[0m
                    \e[90m{$query}\e[0m

                EOF;

            $this->fail($message);
        });
    }
}
