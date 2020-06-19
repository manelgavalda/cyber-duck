<?php

namespace Tests\Feature;

use App\Company;
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

    /** @test */
    public function it_only_shows_10_companies_per_page()
    {
        $companies = factory('App\Company', 11)->create();

        $response = $this->get('/companies');

        $response->assertStatus(200)
            ->assertSee($companies->get(9)->email)
            ->assertDontSee($companies->last()->email);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $company = factory('App\Company')->create();

        $this->assertEquals(Company::count(), 1);

        $this->delete("/companies/{$company->id}");

        $this->assertEquals(Company::count(), 0);
    }

    /** @test */
    public function it_can_be_created()
    {
        $this->post('/companies', [
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com'
        ]);

        $this->assertDatabaseHas('companies', [
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com'
        ]);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $company = factory('App\Company')->create([
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com'
        ]);

        $this->put("/companies/{$company->id}", [
            'name' => 'New-Duck',
            'email' => 'newduck@gmail.com'
        ]);

        tap($company->fresh(), function($company) {
            $this->assertEquals($company->name, 'New-Duck');
            $this->assertEquals($company->email, 'newduck@gmail.com');
        });
    }
}
