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

        $this->assertEquals(0, Employee::count());
    }

    /** @test */
    public function an_employee_needs_a_first_a_last_name_and_an_email()
    {
        $this->actingAs($this->admin)
            ->post(route('employees.index'), [
                'first_name' => '',
                'last_name' => '',
                'email' => ''
            ])->assertSessionHasErrors([
                'first_name' => 'The first name field is required.',
                'last_name' => 'The last name field is required.',
                'email' => 'The email field is required.',
            ]);
    }

    /** @test */
    public function an_employee_email_must_be_unique()
    {
        factory('App\Employee')->create([
            'email' => 'cyberduck@gmail.com'
        ]);

        $this->actingAs($this->admin)
            ->post(route('employees.store'), [
                'first_name' => 'Manel',
                'last_name' => 'Gavaldà',
                'email' => 'cyberduck@gmail.com'
            ])->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);
    }

    /** @test */
    public function an_employee_email_must_be_valid()
    {
        $this->actingAs($this->admin)
            ->post(route('employees.store'), [
                'first_name' => 'Manel',
                'last_name' => 'Gavaldà',
                'email' => 'invalidemail'
            ])->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);
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
    public function an_employee_needs_a_first_and_a_last_name_to_be_updated()
    {
        $employee = factory('App\Employee')->create();

        $this->actingAs($this->admin)
            ->put(route('employees.update', $employee), [
                'first_name' => '',
                'last_name' => '',
                'email' => ''
            ])->assertSessionHasErrors([
                'first_name' => 'The first name field is required.',
                'last_name' => 'The last name field is required.',
                'email' => 'The email field is required.'
            ]);
    }

    /** @test */
    public function an_employee_email_must_be_valid_when_updating()
    {
        $company = factory('App\Employee')->create();

        $this->actingAs($this->admin)
            ->put(route('employees.update', $company), [
                'first_name' => 'Manel',
                'last_name' => 'Gavaldà',
                'email' => 'invalidemail',
            ])->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);
    }

    /** @test */
    public function a_company_email_must_be_unique_when_updating()
    {
        $employee = factory('App\Employee')->create([
            'email' => 'manelgavalda@gmail.com'
        ]);

        factory('App\Employee')->create([
            'email' => 'ramonzampon@gmail.com'
        ]);

        $this->actingAs($this->admin)
            ->put(route('employees.update', $employee), [
                'first_name' => 'new first name',
                'last_name' => 'new last name',
                'email' => 'manelgavalda@gmail.com',
            ])->assertRedirect(route('employees.index'));

        $this->actingAs($this->admin)
            ->put(route('employees.update', $employee), [
                'first_name' => 'new name',
                'last_name' => 'new last name',
                'email' => 'ramonzampon@gmail.com',
            ])->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);
    }

    /** @test */
    public function an_employee_can_be_updated()
    {
        $employee = factory('App\Employee')->create([
            'first_name' => 'Manel',
            'last_name' => 'Gavaldà',
            'email' => 'manelgavalda@gmail.com'
        ]);

        $this->actingAs($this->admin)
            ->put(route('employees.update', $employee), [
                'first_name' => 'Ramon',
                'last_name' => 'Zampon',
                'email' => 'ramonzampon@gmail.com'
            ])->assertRedirect(route('employees.index'));

        tap($employee->fresh(), function($employee) {
            $this->assertEquals('Ramon', $employee->first_name);
            $this->assertEquals('Zampon', $employee->last_name);
            $this->assertEquals('ramonzampon@gmail.com', $employee->email);
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
