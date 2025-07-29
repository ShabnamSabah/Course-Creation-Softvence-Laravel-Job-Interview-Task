<?php

namespace App\Http\Controllers\backend\operator;


use App\Http\Controllers\Controller;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Http\Middleware\OperatorAuthenticationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller implements HasMiddleware
{

  public static function middleware(): array
  {
    return [
      BackendAuthenticationMiddleware::class,
      OperatorAuthenticationMiddleware::class
    ];
  }

  public function dashboard()
  {
    $data = array();
    $data['total_student'] = 0;
    $data['active_menu'] = 'dashboard';
    $data['page_title'] = 'Dashboard';
    return view('backend.operator.pages.dashboard', compact('data'));
  }
}
