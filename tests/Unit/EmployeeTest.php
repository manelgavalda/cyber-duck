<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_company()
    {
        $employee = factory('App\Employee')->create();
        $company = factory('App\Company')->create();

        $employee->company()->associate($company);

        $this->assertTrue($employee->company->is($company));
    }
}
