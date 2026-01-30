<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = null;

        if ($request->filled('search')) {
            $search = $request->search;

            $users = User::where('id', '!=', auth()->id())
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('pseudo', 'like', "%{$search}%");
                })
                ->get();
        }

        return view('dashboard', compact('users'));
    }
}
