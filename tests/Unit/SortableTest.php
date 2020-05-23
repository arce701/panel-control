<?php

namespace Tests\Unit;

use App\Sortable;
use Tests\TestCase;

class SortableTest extends TestCase
{
    protected $sortable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sortable = new Sortable('https://panel.dev/usuarios');
    }

    /** @test */
    function gets_the_info_about_the_column_name_and_order_direction()
    {
        $this->assertSame(['first_name', 'asc'], Sortable::info('first_name'));
        $this->assertSame(['first_name', 'desc'], Sortable::info('first_name-desc'));
        $this->assertSame(['email', 'asc'], Sortable::info('email'));
        $this->assertSame(['email', 'desc'], Sortable::info('email-desc'));
    }

    /** @test */
    function builds_a_url_with_sortable_data()
    {
        $this->assertSame(
            'https://panel.dev/usuarios?order=name',
            $this->sortable->url('name')
        );
    }

    /** @test */
    function appends_query_data_to_the_url()
    {
        $this->sortable->appends(['a' => 'parameter', 'and' => 'another-parameter']);
        $this->assertSame(
            'https://panel.dev/usuarios?a=parameter&and=another-parameter&order=name',
            $this->sortable->url('name')
        );
    }

    /** @test */
    function builds_a_url_with_descendent_order_current_column()
    {
        $this->sortable->appends(['order' => 'name']);

        $this->assertSame(
            'https://panel.dev/usuarios?order=name-desc',
            $this->sortable->url('name')
        );
    }

    /** @test */
    function returns_a_css_class_to_indicate_the_column_is_sortable()
    {
        $this->assertSame('link-sortable', $this->sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_ascendant_order()
    {
        $this->sortable->appends(['order' => 'name']);

        $this->assertSame('link-sortable link-sorted-up', $this->sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
    {
        $this->sortable->appends(['order' => 'name-desc']);

        $this->assertSame('link-sortable link-sorted-down', $this->sortable->classes('name'));
    }
}
