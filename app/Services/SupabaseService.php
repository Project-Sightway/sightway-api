<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

const SECONDS_IN_DAY = 86400;

class SupabaseService
{
    private $supabaseUrl;
    private $apiKey;
    private $bucketName;

    public function __construct($bucketName)
    {
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->apiKey = env('SUPABASE_API_KEY');
        $this->bucketName = $bucketName;
    }

    public function uploadImage($file)
    {
        Log::info("uploading file to supabase: {$file}");
        $filepath = $file->getClientOriginalName();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])
            ->attach('file', $file->get(), $file->getClientOriginalName())
            ->post(
                "{$this->supabaseUrl}/storage/v1/object/{$this->bucketName}/{$filepath}"
            );

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to upload image to Supabase: ' . $response->body());
        }
    }

    public function getSignedUrl($file)
    {
        $filepath = $file->getClientOriginalName();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])
            ->post("{$this->supabaseUrl}/storage/v1/object/sign/{$this->bucketName}/{$filepath}", [
                "expiresIn" => 1 * SECONDS_IN_DAY,
            ]);


        if ($response->successful()) {
            return $this->supabaseUrl . "/storage/v1" . $response->json()['signedURL'];
        } else {
            throw new \Exception('Failed to retrieve signed URL from Supabase: ' . $response->body());
        }
    }
}
