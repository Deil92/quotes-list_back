<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class tagController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/tags",
     *      operationId="getAllTags",
     *      tags={"Tags"},
     *      summary="Get list of tags",
     *      description="Returns tags",
     *      @OA\Response(
     *          response=200,
     *          description="Return all tags",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="1",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(type="integer", property="id", description="Tag id"),
     *                      @OA\Property(type="string", property="name", description="Tag name"),
     *                  )
     *              )
     *            )
     *          )
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns page of quotes
     */
    public function index() {
        return Tag::all();
    }
}
