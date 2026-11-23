<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodCategory;
use App\Models\FoodListing;
use App\Models\Organization;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()->isAdmin(), 403);

        return view('admin.dashboard', [
            'userCount' => User::count(),
            'organizationCount' => Organization::count(),
            'categoryCount' => FoodCategory::count(),
            'listingCount' => FoodListing::count(),
            'reservationCount' => Reservation::count(),
        ]);
    }
}