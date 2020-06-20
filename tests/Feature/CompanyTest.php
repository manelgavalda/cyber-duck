<?php

namespace Tests\Feature;

use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = factory('App\User')->create();
    }

    /** @test */
    public function you_need_to_be_authenticated_to_see_companies()
    {
        $this->get(route('companies.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function companies_are_correctly_shown()
    {
        factory('App\Company')->create([
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com',
            'website' => 'cyberduck.co.uk'
        ]);

        $this->actingAs($this->admin)
            ->get(route('companies.index'))
            ->assertOk()
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

        $this->actingAs($this->admin)
            ->get(route('companies.index'))
            ->assertOk()
            ->assertSee($companies->get(9)->email)
            ->assertDontSee($companies->last()->email);
    }

    /** @test */
    public function a_company_can_be_deleted()
    {
        $company = factory('App\Company')->create();

        $this->assertEquals(Company::count(), 1);

        $this->actingAs($this->admin)
            ->delete(route('companies.destroy', $company))
            ->assertRedirect(route('companies.index'));

        $this->assertEquals(Company::count(), 0);
    }

    /** @test */
    public function a_company_can_be_created()
    {
        $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'name' => 'Cyber-Duck',
                'email' => 'cyberduck@gmail.com'
            ])->assertRedirect(route('companies.index'));

        $this->assertDatabaseHas('companies', [
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com'
        ]);
    }

    /** @test */
    public function a_company_can_be_updated()
    {
        $company = factory('App\Company')->create([
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com'
        ]);

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'New-Duck',
                'email' => 'newduck@gmail.com'
            ])->assertRedirect(route('companies.index'));

        tap($company->fresh(), function($company) {
            $this->assertEquals($company->name, 'New-Duck');
            $this->assertEquals($company->email, 'newduck@gmail.com');
        });
    }

    /** @test */
    public function a_company_can_be_shown()
    {
        $company = factory('App\Company')->create([
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com',
        ]);

        $this->actingAs($this->admin)
            ->get(route('companies.show', $company))
            ->assertOk()
            ->assertSeeInOrder([
                'Cyber-Duck',
                'cyberduck@gmail.com',
            ]);
    }

    /** @test */
    public function the_company_update_form_is_correctly_shown()
    {
        $company = factory('App\Company')->create([
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com'
        ]);

        $this->actingAs($this->admin)
            ->get(route('companies.edit', $company))
            ->assertOk()
            ->assertSeeInOrder([
                'Cyber-Duck',
                'cyberduck@gmail.com'
            ]);
    }

    /** @test */
    public function the_company_creation_form_is_correctly_shown()
    {
        $this->actingAs($this->admin)
            ->get(route('companies.create'))
            ->assertOk()
            ->assertSee('Create Company');
    }
}
