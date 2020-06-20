<?php

namespace Tests\Feature;

use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_need_to_be_authenticated_to_see_companies()
    {
        $this->get(route('companies.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function companies_are_correctly_created_and_shown()
    {
        $this->actingAs($this->admin);

        $this->post(route('companies.store'), [
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com',
            'website' => 'cyberduck.co.uk'
        ])->assertRedirect(route('companies.index'));

        $this->get(route('companies.index'))
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

    /** @test */
    public function a_company_name_and_email_are_required()
    {
        $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'name' => '',
                'email' => ''
            ])->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'email' => 'The email field is required.'
            ]);
    }

    /** @test */
    public function a_company_email_must_be_unique()
    {
        factory('App\Company')->create([
            'email' => 'cyberduck@gmail.com'
        ]);

        $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'name' => 'CyberDuck',
                'email' => 'cyberduck@gmail.com'
            ])->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);
    }

    /** @test */
    public function a_company_email_must_be_valid()
    {
        $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'name' => 'CyberDuck',
                'email' => 'cyberduck'
            ])->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);
    }

    /** @test */
    public function a_company_can_be_created_if_valid()
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
    public function a_company_name_and_email_are_required_when_updating()
    {
        $company = factory('App\Company')->create();

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => '',
                'email' => ''
            ])->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'email' => 'The email field is required.'
            ]);
    }

    /** @test */
    public function a_company_email_must_be_valid_when_updating()
    {
        $company = factory('App\Company')->create();

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'new name',
                'email' => 'invalidemail'
            ])->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);
    }

    /** @test */
    public function a_company_email_must_be_unique_when_updating()
    {
        $company = factory('App\Company')->create([
            'email' => 'cyberduck@gmail.com'
        ]);

        factory('App\Company')->create([
            'email' => 'newduck@gmail.com'
        ]);

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'new name',
                'email' => 'cyberduck@gmail.com'
            ])->assertRedirect(route('companies.index'));

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'new name',
                'email' => 'newduck@gmail.com'
            ])->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);
    }

    /** @test */
    public function a_company_can_be_updated_if_valid()
    {
        $company = factory('App\Company')->create([
            'name' => 'Cyber-Duck',
            'email' => 'cyberduck@gmail.com',
            'website' => 'cyber-duck.co.uk'
        ]);

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'New-Duck',
                'email' => 'newduck@gmail.com',
                'website' => 'new-duck.co.uk'
            ])->assertRedirect(route('companies.index'));

        tap($company->fresh(), function($company) {
            $this->assertEquals('New-Duck', $company->name);
            $this->assertEquals('newduck@gmail.com', $company->email);
            $this->assertEquals('new-duck.co.uk', $company->website);
        });
    }

    /** @test */
    public function a_company_can_be_deleted()
    {
        $company = factory('App\Company')->create();

        $this->assertEquals(1, Company::count());

        $this->actingAs($this->admin)
            ->delete(route('companies.destroy', $company))
            ->assertRedirect(route('companies.index'));

        $this->assertEquals(0, Company::count());
    }
}
