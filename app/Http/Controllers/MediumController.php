<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediumResource;
use App\Models\Medium;
use Illuminate\Http\Request;
use App\Services\MediumService;


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
    public function index()
    {
        //
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
