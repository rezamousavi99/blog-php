<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalApiController extends Controller
{
    public function getFormattedData()
    {
        // Fetch the data from the API
        $response = Http::get('https://api.sokanacademy.com/api/announcements/blog-index-header');

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json(); // Convert response to an associative array

            // Use collect() to transform the data
            $formatted_data = collect($data['data'])
                ->map(function ($item) {
                    // Extract relevant data
                    $article = $item['all'];
                    return [
                        'category_name' => $article['category_name'],
                        'title' => $article['title'],
                        'views_count' => $article['views_count'],
                    ];
                })
                ->groupBy('category_name') // Group by category_name
                ->map(function ($articles) {
                    // Format each article into the desired structure (title => views_count)
                    return $articles->map(function ($article) {
                        return [$article['title'] => $article['views_count']];
                    });
                });

            // Return the formatted data as a JSON response
            return response()->json($formatted_data, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // In case of failure, return an error message
        return response()->json(['error' => 'Failed to fetch data'], 500);
    }
}
