<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

        $response = $this->get('/employees');

        $response->assertStatus(200)
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

        $response = $this->get('/employees');

        $response->assertStatus(200)
            ->assertSee($employees->get(9)->email)
            ->assertDontSee($employees->last()->email);
    }
}
