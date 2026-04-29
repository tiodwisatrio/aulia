<?php

use Illuminate\Support\Facades\Route;

// FRONTEND ROUTES (Public)
// Note: Frontend routes are now provided by module ServiceProviders
// The home route is provided by the Core module (app/Modules/Core/routes.php)

// DASHBOARD ROUTES
// Note: Dashboard routes are now provided by Core module
// The dashboard route is defined in: app/Modules/Core/routes.php
// All CRUD routes are provided by Module ServiceProviders
// Module routes can be found in: app/Modules/*/routes.php

require __DIR__.'/auth.php';
