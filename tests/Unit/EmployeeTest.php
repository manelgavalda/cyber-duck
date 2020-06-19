<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_employee_belongs_to_a_company()
    {
        $employee = factory('App\Employee')->create();
        $company = factory('App\Company')->create();

        $employee->company()->associate($company);

        $this->assertTrue($employee->company->is($company));
    }
}
