<?php

Artisan::resolve('ScrapeCommand');
Artisan::add(new SummaryEmail);
Artisan::add(new SummaryEmailSignUps);