<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('update-ide-helper', function () {
    if (!app()->environment('production')) {
        Artisan::call('ide-helper:generate');
        Artisan::call('ide-helper:meta');
    } else {
        $this->warn('生产环境下不执行ide helper');
    }
})->describe('更新ide helper文件');
