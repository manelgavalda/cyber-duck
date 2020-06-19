<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function companies_are_correctly_shown()
    {
        factory('App\Company')->create([
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com',
            'website' => 'cyberduck.co.uk'
        ]);

        $response = $this->get('/companies');

        $response->assertStatus(200)
            ->assertSeeInOrder([
                1,
                'Cyber-Duck',
                'cyberduck@gmail.com',
                'cyberduck.co.uk'
            ]);
    }
}
