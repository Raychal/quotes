<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequest;
use App\Http\Requests\QuotesRequest;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\QuotesResource;
use App\Models\Quote;
use App\Traits\BaseResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class QuoteController extends Controller
{
    use BaseResponse;

    /**
     * @response QuotesResource
     */
    public function index(QuotesRequest $request)
    {
        $language = $request->input('lang') ?? 'en';
        $paginate = $request->input('paginate') ?? '0';
        $limit = $request->input('limit') ?? 10;

        $quotes = Quote::with(['content', 'author'])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($item) use ($language) {
                foreach ($item->content as $content) {
                    if ($content->language == $language) {
                        $data = $content->content;
                    }
                }
                return [
                    'id' => $item->id,
                    'author' => $item->author->name,
                    'content' => $data,
                    'category' => json_decode($item->category),
                ];
            });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $quotes->slice(($currentPage - 1) * $limit, $limit)->all();
        $paginatedItems = new LengthAwarePaginator($currentItems, $quotes->count(), $limit, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $result = $paginate === '1' ? QuotesResource::collection($paginatedItems) : QuotesResource::collection($quotes);

        return $this->success('ok', $result, $paginate);
    }

    /**
     * @response QuoteResource
     */
    public function show(QuoteRequest $request, $id)
    {
        $language = $request->input('lang') ?? 'en';

        $quote = Quote::whereId($id)->with(['content', 'author'])
            ->take(1)
            ->get()
            ->map(function ($item) use ($language) {
                foreach ($item->content as $content) {
                    if ($content->language == $language) {
                        $data = $content->content;
                    }
                }
                return [
                    'id' => $item->id,
                    'author' => $item->author->name,
                    'content' => $data,
                    'category' => json_decode($item->category),
                ];
            });

        $result = QuoteResource::collection($quote);

        return $this->success('ok', Arr::first($result));
    }

    /**
     * @response QuoteResource
     */
    public function random(QuoteRequest $request)
    {
        $data = ["id", "en"];
        $randomElement = Arr::random($data);
        $language = $request->input('lang') ?? $randomElement;

        $quote = Quote::with(['content', 'author'])
            ->inRandomOrder()
            ->take(1)
            ->get()
            ->map(function ($item) use ($language) {
                foreach ($item->content as $content) {
                    if ($content->language == $language) {
                        $data = $content->content;
                    }
                }
                return [
                    'id' => $item->id,
                    'author' => $item->author->name,
                    'content' => $data,
                    'category' => json_decode($item->category),
                ];
            });

        $result = QuoteResource::collection($quote);

        return $this->success('ok', Arr::first($result));
    }
}
