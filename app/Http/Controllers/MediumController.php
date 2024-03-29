<?php

namespace App\Http\Controllers;

use App\Http\Resources\CastCollection;
use App\Http\Resources\MediumCollection;
use App\Http\Resources\MediumResource;
use App\Models\Medium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\MediumService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class MediumController extends BaseController
{
    private $mediumService;

    public function __construct(MediumService $mediumService)
    {
        $this->mediumService = $mediumService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/media",
     *      operationId="index",
     *      tags={"Media"},
     *      summary="Get 15 random media",
     *      description="Returns media data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index()
    {
        $media = Medium::all()->random(15);
        return $this->sendResponse(new MediumCollection($media), 'Medium retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/media/{id}",
     *      operationId="getMediumById",
     *      tags={"Media"},
     *      summary="Get medium information",
     *      description="Returns medium data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Medium id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id)
    {
        $medium = $this->mediumService->findById($id);
        $medium->append('avg_grade')->toArray();
        if ($medium instanceof Medium) {
            return $this->sendResponse(new MediumResource($medium), 'Medium retrieved successfully.');
        } else {
            return $this->sendError($medium);
        }
    }

    /**
     * @OA\Get(
     *      path="/media/top",
     *      operationId="getTopRated",
     *      tags={"Media"},
     *      summary="Get top rated films from last week",
     *      description="Returns media data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function getTopRated()
    {
        $date = Carbon::now()->subDays(7);
        $media = DB::table('media')->select('media.*', DB::raw('AVG(grades.rating) as avg_rating'))->leftJoin('grades', 'media.id', '=', 'grades.medium_id')->where('grades.created_at', '>=', $date)->havingRaw('AVG(grades.rating) is not null')->groupBy('media.id')->get();
        foreach ($media as $medium) {
            $medium->image_path = $medium->image_path ? Storage::disk('google')->url($medium->image_path) : $medium->image_path;
        }
        return $this->sendResponse($media, 'Media retrieved successfully.');
    }

    /**
     * @OA\Get(
     *      path="media/{id}/casts",
     *      operationId="getCasts",
     *      tags={"Media"},
     *      summary="Get casts of particular medium",
     *      description="Returns casts data",
     *     @OA\Parameter(
     *          name="id",
     *          description="Medium id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function getCasts($id)
    {
        $medium = $this->mediumService->findById($id);
        $casts = $medium->casts;
        return $this->sendResponse(new CastCollection($casts), 'Casts retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
