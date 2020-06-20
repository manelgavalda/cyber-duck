<?php

namespace Tests\Feature;

use App\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_need_to_be_authenticated_to_see_employees()
    {
        $this->get(route('employees.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function employees_are_correctly_shown()
    {
        factory('App\Employee')->create([
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà',
            'email' => 'manelgavalda1@gmail.com',
            'phone' => '699112233'
        ]);

        $this->actingAs($this->admin)
            ->get(route('employees.index'))
            ->assertOk()
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

        $this->actingAs($this->admin)
            ->get(route('employees.index'))
            ->assertOk()
            ->assertSee($employees->get(9)->email)
            ->assertDontSee($employees->last()->email);
    }


    /** @test */
    public function an_employee_can_be_deleted()
    {
        $employee = factory('App\Employee')->create();

        $this->assertEquals(Employee::count(), 1);

        $this->actingAs($this->admin)
            ->delete(route('employees.destroy', $employee))
            ->assertRedirect(route('employees.index'));

        $this->assertEquals(Employee::count(), 0);
    }

    /** @test */
    public function an_employee_can_be_created()
    {
        $this->actingAs($this->admin)
            ->post(route('employees.index'), [
                'first_name' => 'Manel',
                'last_name' => 'Gavaldà',
                'email' => 'manelgavalda@gmail.com'
            ])->assertRedirect(route('employees.index'));

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

        $this->actingAs($this->admin)
            ->put(route('employees.update', $employee), [
                'first_name' => 'Ramon',
                'last_name' => 'Zampon'
            ])->assertRedirect(route('employees.index'));

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

        $this->actingAs($this->admin)
            ->get(route('employees.show', $employee))
            ->assertOk()
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

        $this->actingAs($this->admin)
            ->get(route('employees.edit', $employee))
            ->assertOk()
            ->assertSeeInOrder([
                'Manel',
                'Gavaldà',
                'manelgavalda1@gmail.com'
            ]);
    }

    /** @test */
    public function the_employee_creation_form_is_correctly_shown()
    {
        $this->actingAs($this->admin)
            ->get(route('employees.create'))
            ->assertOk()
            ->assertSee('Create Employee');
    }
}
