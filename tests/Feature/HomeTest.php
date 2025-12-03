<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Test the public home route returns a successful response.
     */
    public function test_public_home_route_returns_successful_response(): void
    {
        $response = $this->get(route('public.home'));

        $response->assertStatus(200);
    }
}
