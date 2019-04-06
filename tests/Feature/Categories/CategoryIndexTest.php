<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_a_collection_of_categories()
    {
        $categories = factory(Category::class, 2)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function ($category) use ($response) {
            $response->assertJsonFragment([
                    'slug' => $category->slug
            ]);
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_only_parent_categories()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
          $subCategory =  factory(Category::class)->create()
        );

        $this->json('GET', 'api/categories')
            ->assertJsonCount(1, 'data');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_categories_ordered_by_given_order()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $anotherCategory = factory(Category::class)->create([
            'order' => 1
        ]);

        $category->children()->save(
            $subCategory =  factory(Category::class)->create()
        );

        $this->json('GET', 'api/categories')
            ->assertSeeInOrder([
                $anotherCategory->slug,
                $category->slug
            ]);
    }
}
