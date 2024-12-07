<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {
        $data = ["id", "en"];
        $randomElement = Arr::random($data);

        $attempts = 0;
        $maxAttempts = 5;
        $quote = null;

        while (!$quote && $attempts < $maxAttempts) {
            $quote = Quote::with(['content', 'author'])
                ->inRandomOrder()
                ->take(1)
                ->get()
                ->map(function ($item) use ($randomElement) {
                    $data = null;

                    foreach ($item->content as $content) {
                        if ($content->language == $randomElement) {
                            $contentLength = strlen($content->content);

                            if ($contentLength < 150) {
                                $data = $content->content;
                            }
                        }
                    }

                    return $data ? [
                        'author' => $item->author->name,
                        'content' => $data
                    ] : null;
                })
                ->first();

            $attempts++;
        }

        if (!$quote) {
            $quote = [
                'author' => '',
                'content' => ''
            ];
        }

        return Inertia::render('Index', [
            'data' => $quote
        ]);
    }
}
