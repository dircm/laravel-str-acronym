<?php

use Illuminate\Support\Str;
use KoenHendriks\StrAcronym\StrServiceProvider;
use Orchestra\Testbench\TestCase;

class AcronymStrTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            StrServiceProvider::class,
        ];
    }

    public function testAcronym()
    {
        $this->assertSame('lidsa', Str::acronym('lorem ipsum dolor sit amet'));
        $this->assertSame('Life', Str::acronym('Laravel is freaking everywhere'));
        $this->assertSame('fB', Str::acronym('foo  Bar'));
        $this->assertSame('ts', Str::acronym('trailing spaces   '));
        $this->assertSame('ty', Str::acronym('the year 2013'));
        $this->assertSame('lpf', Str::acronym("laravel\t\tphp\n\nframework"));
        $this->assertSame('ÉL', Str::acronym("Érico Leitão"));
        $this->assertSame('HW', (string) Str::of('hello world')->headline()->acronym());
    }

    public function testAcronymWithLimit()
    {
        // Test cases with the limit parameter
        $this->assertSame('li', Str::acronym('lorem ipsum dolor sit amet', limit: 2));
        $this->assertSame('L', Str::acronym('Laravel is freaking everywhere', '', 1));
        $this->assertSame('fB', Str::acronym('foo  Bar', '', 3)); // No truncation as it's within the limit
        $this->assertSame('ts', Str::acronym('trailing spaces   ', '', 2));
        $this->assertSame('ty', Str::acronym('the year 2013', '', 3));
        $this->assertSame('lp', Str::acronym("laravel\t\tphp\n\nframework", limit: 2));
        $this->assertSame('É', Str::acronym("Érico Leitão", '', 1));
        $this->assertSame('HW', (string) Str::of('hello world')->headline()->acronym('', 2));
    }

}
