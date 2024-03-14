<?php

namespace App\Middlewares;

use Closure;
use App\Http\Request;

abstract class Middleware
{
    abstract public function handle(Request $request, Closure $next);
}