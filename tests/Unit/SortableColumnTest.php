<?php

namespace Tests\Unit;

use App\Rules\SortableColumn;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortableColumnTest extends TestCase
{
    /** @test */
    function validate_sortable_values()
    {
        $rule = new SortableColumn(['id', 'first_name', 'email']);

        $this->assertTrue($rule->passes('order', 'id'));
        $this->assertTrue($rule->passes('order', 'first_name'));
        $this->assertTrue($rule->passes('order', 'email'));
        $this->assertTrue($rule->passes('order', 'id-desc'));
        $this->assertTrue($rule->passes('order', 'first_name-desc'));
        $this->assertTrue($rule->passes('order', 'email-desc'));

        $this->assertFalse($rule->passes('order', []));
        $this->assertFalse($rule->passes('order', 'name-descendant'));
        $this->assertFalse($rule->passes('order', 'asc-name'));
        $this->assertFalse($rule->passes('order', 'email-'));
        $this->assertFalse($rule->passes('order', 'email-des'));
        $this->assertFalse($rule->passes('order', 'name-descx'));
        $this->assertFalse($rule->passes('order', 'desc-name'));
    }
}
