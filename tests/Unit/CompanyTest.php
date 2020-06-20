<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_a_default_image_if_no_logo_selected()
    {
        $company = factory('App\Company')->create([
            'logo_path' => null
        ]);

        $this->assertEquals('default.png', $company->logo_path);

        $company = factory('App\Company')->create([
            'logo_path' => 'logos/one.png'
        ]);

        $this->assertEquals('logos/one.png', $company->logo_path);
    }

    /** @test */
    public function it_has_many_employees()
    {
        $company = factory('App\Company')->create();

        factory('App\Employee', 2)->create([
            'company_id' => $company->id
        ]);

        $this->assertEquals(2, $company->employees()->count());
    }
}
