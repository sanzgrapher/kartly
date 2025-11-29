<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StatusController extends Controller
{
    public function index()
    {
        // Check Typesense status
        $typesenseUrl = 'http://localhost:8108/health';
        $typesense = null;
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(2)->get($typesenseUrl);
            $typesense = $response->ok();
        } catch (\Exception $e) {
            $typesense = false;
        }

        // Check Mailpit status
        $mailpitUrl = 'http://localhost:8025/readyz';
        $mailpit = null;
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(2)->get($mailpitUrl);
            $mailpit = $response->ok();
        } catch (\Exception $e) {
            $mailpit = false;
        }

        return view('status', [
            'typesense' => $typesense,
            'mailpit' => $mailpit,
        ]);
    }
}
