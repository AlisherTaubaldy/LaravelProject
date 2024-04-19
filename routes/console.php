<?php

use App\Console\Commands\CheckBookRentals;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

$schedule = new Schedule();

$schedule->command('rentals:check')->daily();

// Register the schedule with the Laravel application (assuming you're using Artisan)
$schedule->command('schedule:run');

