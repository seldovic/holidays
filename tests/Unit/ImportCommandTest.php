<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

class ImportCommandTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHolidays() // Dummy test
    {
  
    	Artisan::call('migrate:rollback');
    	Artisan::call('migrate');
    	Artisan::call('importjson'); // Import holidays

    	$this->assertDatabaseHas('holidays', ['id' => 12]);
    	$this->assertDatabaseHas('holidays', ['bank_holiday' => 'official']);
    }
}
