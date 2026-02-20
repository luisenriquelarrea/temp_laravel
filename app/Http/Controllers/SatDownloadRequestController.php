<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\SatDownloadPackage;

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

    public function downloadPackage(SatDownloadPackage $package)
    {
        $path = "sat/{$package->package_id}.zip";

        if (!Storage::exists($path))
            abort(404, 'File not found');

        return Storage::download($path);
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
            ->with('success', "Solicitud de descarga creada {$requestId}");
    }
}
