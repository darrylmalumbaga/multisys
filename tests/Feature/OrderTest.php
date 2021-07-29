<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class OrderTest extends TestCase
{
    /** @test */
    public function test_order_with_right_quantity()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->call('post', 'api/order', [
                'product_id' => 1,
                'quantity' => 1,
            ]);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function test_order_with_more_quantity_than_stock()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->call('post', 'api/order', [
                'product_id' => 1,
                'quantity' => 9999,
            ]);
        $this->assertEquals(400, $response->getStatusCode());
    }
}
