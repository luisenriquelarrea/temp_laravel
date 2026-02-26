<?php

namespace App\Http\Controllers;

use App\Models\SatDownloadRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $requests = SatDownloadRequest::with('packages')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('dashboard', compact('requests'));
    }
}
