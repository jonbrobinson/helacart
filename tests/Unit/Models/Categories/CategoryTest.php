<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestResult;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_children()
    {

        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $category->children->first());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_fetch_only_parents()
    {

        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->assertEquals(1, Category::parents()->count());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_is_ordered_by_a_numbered_order()
    {

        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $anotherCategory = factory(Category::class)->create([
            'order' => 1
        ]);


        $this->assertEquals($anotherCategory->name, Category::ordered()->first()->name);
    }
}
