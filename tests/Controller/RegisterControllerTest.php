<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class RegisterControllerTest extends TestCase
{
    public function testSomething(): void
    {
        $register = new User();

        $this->assertEmpty($register->getEmail());
        $this->assertEmpty($register->getUsername());
        $this->assertEmpty($register->getId());
    }
}
