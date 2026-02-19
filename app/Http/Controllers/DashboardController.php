<?php

namespace App\Http\Controllers;

use App\Models\SatDownloadRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $requests = SatDownloadRequest::with('packages')
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('requests'));
    }
}
