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
     *      title="Quotes",
     *      description="Quote List Application",
     *      @OA\Contact(
     *          email="khristoforov.vadim@yandex.ru"
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
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="1",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *              type="object",
     *              @OA\Property(type="integer", property="id", description="Quote id"),
     *              @OA\Property(type="string", property="quote", description="Quote text"),
     *              @OA\Property(property="author", type="string", description="Author"),
     *              @OA\Property(type="string", property="created_at", format="date-time", description="Created At", example="2019-02-25 12:59:20"),
     *              @OA\Property(type="string", property="updated_at", format="date-time", description="Updated At", example="2019-02-25 12:59:20"),
     *              @OA\Property(
     *                  property="tags",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(type="integer", property="id", description="Tag id"),
     *                      @OA\Property(type="string", property="name", description="Tag name"),
     *                      @OA\Property(
        *                      property="pivot",
        *                      type="object",
        *                      @OA\Property(type="integer", property="quote_id", description="Quote id"),
        *                      @OA\Property(type="integer", property="tag_id", description="Tag id"),
     *                      )
     *                  ),
     *              )
     *                  )
     *              )
     *            )
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

    /**
     * @OA\Get(
     *      path="/api/quote/:id",
     *      operationId="getQuooteById",
     *      tags={"Quotes"},
     *      summary="Get quote by id",
     *      description="Return one quote",
     *      @OA\Response(
     *          response=200,
     *          description="Return one quote",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(type="integer", property="id", description="Quote id"),
     *              @OA\Property(type="string", property="quote", description="Quote text"),
     *              @OA\Property(property="author", type="string", description="Author"),
     *              @OA\Property(type="string", property="created_at", format="date-time", description="Created At", example="2019-02-25 12:59:20"),
     *              @OA\Property(type="string", property="updated_at", format="date-time", description="Updated At", example="2019-02-25 12:59:20"),
     *              @OA\Property(
     *                  property="tags",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(type="integer", property="id", description="Tag id"),
     *                      @OA\Property(type="string", property="name", description="Tag name"),
     *                      @OA\Property(
        *                      property="pivot",
        *                      type="object",
        *                      @OA\Property(type="integer", property="quote_id", description="Quote id"),
        *                      @OA\Property(type="integer", property="tag_id", description="Tag id"),
     *                      )
     *                  ),
     *              )
     *          )
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns Quote by id
     */
    public function show($id) {
        return Quote::where('id', $id)->with('tags')->firstOrFail()->toArray();
    }

    /**
     * @OA\Post(
     *      path="/api/quote",
     *      operationId="CreateQuote",
     *      tags={"Quotes"},
     *      summary="Create Quote",
     *      description="create Quote",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"quory","author","tags"},
     *              @OA\Property(property="quory", type="string"),
     *              @OA\Property(property="author", type="string"),
     *              @OA\Property(property="tags", type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(type="integer", property="id", description="Tag id"),
     *                  ) 
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Create Quote",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(type="integer", property="id", description="Quote id"),
     *              @OA\Property(property="author", type="string"),
     *              @OA\Property(type="string", property="quote", description="Quote text"),
     *              @OA\Property(type="string", property="created_at", format="date-time", description="Created At", example="2019-02-25 12:59:20"),
     *              @OA\Property(type="string", property="updated_at", format="date-time", description="Updated At", example="2019-02-25 12:59:20"),
     *          )
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns create quote
     */
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
