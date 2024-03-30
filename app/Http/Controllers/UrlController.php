<?php

namespace App\Http\Controllers;

use App\Models\UrlModel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str; // Import Str class for generating random strings
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{
    protected $client;
    public function __construct()
    {
        $this->client = new Client();
    }
    function index()
    {
        $generatedUrls = UrlModel::get();
        return Inertia::render('Main',[
            'generated_urls' => $generatedUrls,
            'success' => session('success') ?? '',
            'err' => session('error') ?? '',
        ]);
    }
    public function generate(Request $request)
{
    // Validate the URL input
    $validatedData = $request->validate([
        'url' => 'required|url',
    ]);

    // Check URL using Safe Browsing API
    $threatMatches = $this->checkUrl($validatedData['url']);

    if (!empty($threatMatches['matches'])) {
        // If the URL matches any threats, return an error
        return redirect()->back()->with('error', 'The provided URL is not safe.');
    }

    // Check if the URL already exists in the database
    $existingUrl = UrlModel::where('original_url', $validatedData['url'])->first();

    if ($existingUrl) {
        return redirect()->back()->with('error', 'URL already shortened.');
    }

    // Generate a short URL
    $shortUrl = config('app.url') . '/' . Str::random(6); // Generate a random 6-character string

    // Create a new URL model
    $url = new UrlModel();
    $url->original_url = $validatedData['url'];
    $url->short_url = $shortUrl;
    $url->save();

    return redirect()->back()->with('success', 'URL shortened successfully.');
}

    public function checkUrl($url)
    {
        $apiKey = 'AIzaSyBS5sTgTuezmXmL_YYPmldBKiBm0_oMXYA'; // Replace with your actual API key

        $response = $this->client->post('https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey, [
            'json' => [
                'threatInfo' => [
                    'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING', 'THREAT_TYPE_UNSPECIFIED'],
                    'platformTypes' => ['ANY_PLATFORM'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries' => [['url' => $url]],
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
    public function redirect($hash)
{
    // Find the original URL based on the hash
    $url = UrlModel::where('short_url', config('app.url') . '/' . $hash)->first();

    // If URL is found, redirect the user
    if ($url) {
        return redirect()->away($url->original_url);
    } else {
        // If URL is not found, you can handle it accordingly, e.g., redirect to a 404 page
        abort(404);
    }
}
}
