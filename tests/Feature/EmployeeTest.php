<?php

namespace Tests\Feature;

use App\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function employees_are_correctly_shown()
    {
        factory('App\Employee')->create([
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà',
            'email' => 'manelgavalda1@gmail.com',
            'phone' => '699112233'
        ]);

        $this->get('/employees')
            ->assertStatus(200)
            ->assertSeeInOrder([
                1,
                'Manel',
                'Gavaldà',
                'manelgavalda1@gmail.com',
                '699112233',
            ]);
    }

    /** @test */
    public function it_only_shows_10_employees_per_page()
    {
        $employees = factory('App\Employee', 11)->create();

        $this->get('/employees')
            ->assertStatus(200)
            ->assertSee($employees->get(9)->email)
            ->assertDontSee($employees->last()->email);
    }


    /** @test */
    public function an_employee_can_be_deleted()
    {
        $employee = factory('App\Employee')->create();

        $this->assertEquals(Employee::count(), 1);

        $this->delete("/employees/{$employee->id}");

        $this->assertEquals(Employee::count(), 0);
    }

    /** @test */
    public function an_employee_can_be_created()
    {
        $this->post('/employees', [
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà',
            'email' => 'manelgavalda@gmail.com'
        ]);

        $this->assertDatabaseHas('employees', [
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà',
            'email' => 'manelgavalda@gmail.com'
        ]);
    }

    /** @test */
    public function an_employee_can_be_updated()
    {
        $employee = factory('App\Employee')->create([
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà'
        ]);

        $this->put("/employees/{$employee->id}", [
            'first_name' => 'Ramon',
            'last_name' => 'Zampon'
        ]);

        tap($employee->fresh(), function($employee) {
            $this->assertEquals($employee->first_name, 'Ramon');
            $this->assertEquals($employee->last_name, 'Zampon');
        });
    }

    /** @test */
    public function an_employee_can_be_shown()
    {
        $employee = factory('App\Employee')->create([
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà',
            'email' => 'manelgavalda1@gmail.com'
        ]);

        $this->get("/employees/{$employee->id}")
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Manel',
                'Gavaldà',
                'manelgavalda1@gmail.com'
            ]);
    }

    /** @test */
    public function the_employee_update_form_is_correctly_shown()
    {
        $employee = factory('App\Employee')->create([
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà',
            'email' => 'manelgavalda1@gmail.com'
        ]);

        $this->get("/employees/{$employee->id}/edit")
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Manel',
                'Gavaldà',
                'manelgavalda1@gmail.com'
            ]);
    }

    /** @test */
    public function the_employee_creation_form_is_correctly_shown()
    {
        $this->get("/employees/create")
            ->assertStatus(200)
            ->assertSee('Create Employee');
    }
}
