<?php

namespace Tests;

use Illuminate\Support\Str;

trait TestHelpers
{
    public function assertDatabaseEmpty($table, $connection = null)
    {
        $total = $this->getConnection($connection)->table($table)->count();
        $this->assertSame(0, $total, sprintf(
                "Failed asserting table [%s] table is empty. %s %s found.",
                $table,
                $total,
                Str::plural('row', $total))
        );
    }

    public function assertDatabaseCount($table, $expected, $connection = null)
    {
        $found = $this->getConnection($connection)->table($table)->count();
        $this->assertSame($expected, $found, sprintf(
                "Failed asserting table [%s] has %s %s. %s %s found.",
                $table,
                $expected,
                Str::plural('row', $expected), $found,
                Str::plural('row', $found)
            )
        );
    }

    protected function withData(array $custom = [])
    {
        return array_merge($this->defaultData(), $custom);
    }

    protected function defaultData()
    {
        return $this->defaultData;
    }
}