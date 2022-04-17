<?php

namespace Tests\Unit;

use Tests\TestCase;

class ImportTransactionsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_access_to_home_page()
    {
        $this->get('/home')->assertOk();
    }
}
