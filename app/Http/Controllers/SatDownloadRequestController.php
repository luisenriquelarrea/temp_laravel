<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\DescargaMasivaSatService;

class SatDownloadRequestController extends Controller
{
    protected DescargaMasivaSatService $descargaMasivaService;

    public function __construct(DescargaMasivaSatService $descargaMasivaService)
    {
        $this->descargaMasivaService = $descargaMasivaService;
    }
    public function create()
    {
        return view('sat_requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'download_type' => 'required|string',
            'request_type' => 'required|string',
            'document_type' => 'required|string',
            'document_status' => 'required|string',
        ]);

        $requestId = $this->descargaMasivaService->createCustomRequest(params: $validated);

        return redirect()->route('dashboard')
            ->with('success', "Download request created {$requestId}");
    }
}
