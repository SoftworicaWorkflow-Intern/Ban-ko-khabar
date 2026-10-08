<?php

require __DIR__.'/vendor/autoload.php';
use App\Services\BikramSambat;

$r = BikramSambat::fromGregorian(new DateTime('2026-10-08'));
echo $r['day_name'].' '.$r['year'].' '.$r['month_name'].' '.$r['day'].PHP_EOL;
