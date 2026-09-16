<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Public and admin feature tests rely on the initial catalog directory.
     */
    protected $seed = true;
}
