<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Tag;

class QuoteController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Integration Swagger in Laravel with Passport Auth Documentation",
     *      description="Implementation of Swagger with in Laravel",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     * )
     *
     *
     */
    private int $quotesOnPage = 10;

    /**
     * @OA\Get(
     *      path="/api/quotes",
     *      operationId="getQuotesOnPage",
     *      tags={"Quotes"},
     *      summary="Get list of projects",
     *      description="Returns page of quotes",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns page of quotes
     */
    public function index($page = 1) {
        $count = Quote::count();
        $maxPage = ceil($count / $this->quotesOnPage);
        if((int)$page < 1){
            $page = 1;
        }
        if($page > $maxPage){
            $page = $maxPage;
        }
        $quotes = Quote::orderBy('created_at', 'desc')->skip(($page - 1) * $this->quotesOnPage)->take($this->quotesOnPage)->with(['tags' => function($query) {
            $query->select('name');
        }])->get();
        return [
            'quotes' => $quotes->toArray(),
            'maxpage' => $maxPage,
        ];
    }

    public function show($id) {
        return Quote::where('id', $id)->with('tags')->firstOrFail()->toArray();
    }

    public function create(Request $request) {
        if(!$request->tags || !$request->quote || !$request->author){
            abort(400, 'valid-required');
        }
        foreach($request->tags as $tag){
            Tag::findOrFail($tag);
        }
        $quote = new Quote;

        $quote->quote = $request->quote;
        $quote->author = $request->author;

        $quote->save();
        $quote->tags()->attach($request->tags);
        return $quote;
    }
}
