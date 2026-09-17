<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_promotions_are_shown_on_the_promotions_page_and_home_page(): void
    {
        $promotion = Product::query()->create([
            'name' => 'Акционный автобокс',
            'slug' => 'promotional-roof-box',
            'price' => 10000,
            'old_price' => 12500,
            'is_on_sale' => true,
            'promotion_label' => 'Осенняя скидка',
            'promotion_ends_at' => now()->addDay(),
            'stock' => 1,
            'is_active' => true,
        ]);
        Product::query()->create([
            'name' => 'Завершённая акция',
            'slug' => 'expired-promotion',
            'price' => 10000,
            'old_price' => 12500,
            'is_on_sale' => true,
            'promotion_ends_at' => now()->subDay(),
            'stock' => 1,
            'is_active' => true,
        ]);

        $this->get(route('promotions.index'))
            ->assertOk()
            ->assertSee($promotion->name)
            ->assertSee('Осенняя скидка')
            ->assertDontSee('Завершённая акция');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($promotion->name)
            ->assertSee(route('promotions.index'))
            ->assertDontSee('Завершённая акция');
    }
}
