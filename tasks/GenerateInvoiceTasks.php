<?php
include __DIR__ . '/../config/config.php';

use Crunz\Schedule;


$schedule = new Schedule();
$schedule->run('php ' . __DIR__ . '/../cronjobs/generateinvoice.php')
    ->monthly()
    ->description('Generate Invoices for Active Leases');
return $schedule;
