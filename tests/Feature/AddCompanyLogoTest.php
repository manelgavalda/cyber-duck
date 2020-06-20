<?php

namespace Tests\Feature;

use App\Company;
use Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCompanyLogoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function a_valid_company_logo_must_be_provided()
    {
        $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'name' => 'Cyber-Duck',
                'email' => 'cyberduck@gmail.com',
                'logo' => $file = UploadedFile::fake()->image('logo.png', 99, 99)
            ])->assertSessionHasErrors([
                'logo' => 'The logo has invalid image dimensions.'
            ]);

        Storage::disk('public')->assertMissing('logos/' . $file->hashName());
    }

    /** @test */
    public function a_company_may_have_a_logo()
    {
        $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'name' => 'Cyber-Duck',
                'email' => 'cyberduck@gmail.com',
                'logo' => $file = UploadedFile::fake()->image('logo.png', 100, 100)
            ])->assertRedirect(route('companies.index'));

        Storage::disk('public')->assertExists('logos/' . $file->hashName());
    }

    /** @test */
    public function a_company_may_update_the_logo_with_a_valid_one()
    {
        $file = UploadedFile::fake()->image('logo.png', 100, 100);

        $file->store('logos', 'public');

        $company = factory('App\Company')->create([
            'logo_path' => 'logos/' . $file->hashName()
        ]);

        Storage::disk('public')->assertExists('logos/' . $file->hashName());

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'Cyber-Duck',
                'email' => 'cyberduck@gmail.com',
                'logo' => $newFile = UploadedFile::fake()->image('logo.png', 99, 99)
            ])->assertSessionHasErrors([
                'logo' => 'The logo has invalid image dimensions.'
            ]);

        Storage::disk('public')->assertExists('logos/' . $file->hashName());
        Storage::disk('public')->assertMissing('logos/' . $newFile->hashName());
    }

    /** @test */
    public function a_company_may_update_the_logo_just_if_provided()
    {
        $file = UploadedFile::fake()->image('logo.png', 100, 100);

        $file->store('logos', 'public');

        $company = factory('App\Company')->create([
            'logo_path' => 'logos/' . $file->hashName()
        ]);

        Storage::disk('public')->assertExists('logos/' . $file->hashName());

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'Cyber-Duck',
                'email' => 'cyberduck@gmail.com',
                'logo' => null
            ])->assertRedirect(route('companies.index'));

        Storage::disk('public')->assertExists('logos/' . $file->hashName());
    }

    /** @test */
    public function a_company_may_update_the_logo_if_valid()
    {
        $file = UploadedFile::fake()->image('logo.png', 100, 100);

        $file->store('logos', 'public');

        $company = factory('App\Company')->create([
            'logo_path' => 'logos/' . $file->hashName()
        ]);

        Storage::disk('public')->assertExists('logos/' . $file->hashName());

        $this->actingAs($this->admin)
            ->put(route('companies.update', $company), [
                'name' => 'Cyber-Duck',
                'email' => 'cyberduck@gmail.com',
                'logo' => $newFile = UploadedFile::fake()->image('logo.png', 100, 100)
            ])->assertRedirect(route('companies.index'));

        Storage::disk('public')->assertMissing('logos/' . $file->hashName());
        Storage::disk('public')->assertExists('logos/' . $newFile->hashName());
    }
}
