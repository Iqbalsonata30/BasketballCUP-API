<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Players\StorePlayerRequest;
use App\Http\Requests\Players\UpdatePlayerRequest;
use App\Http\Resources\Players\PlayerResource;
use App\Http\Resources\Teams\TeamResource;
use App\Services\PlayerServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected PlayerServices $playerServices;

    public function __construct(PlayerServices $playerServices)
    {
        return $this->playerServices = $playerServices;
    }
    public function index()
    {
        return response()->json([
            'statusCode' => 404,
            'message'    => 'NOT FOUND',
            'error'      => 'Players not found.'
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlayerRequest $request): JsonResponse
    {

        try {
            $this->playerServices->createPlayer($request);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 422,
                'message'    => 'UNPROCESSABLE',
                'error'      => $error->getMessage()
            ], 422);
        }
        return response()->json([
            'statusCode' => 201,
            'message'    => 'CREATED',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug): JsonResponse
    {
        try {
            $players  = $this->playerServices->getPlayer($request, $slug);
            if (!$players->isEmpty()) {
                return response()->json([
                    'statusCode' => 200,
                    'message'    => 'OK',
                    'data'       => TeamResource::collection($players),
                ], 200);
            }
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Players not found.'
            ], 404);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayerRequest $request, $id): JsonResponse
    {
        try {
            $player = $this->playerServices->updatePlayer($request, $id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Players not found.'
            ], 404);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 422,
                'message'    => 'UNPROCESSABLE',
                'error'      => $error->getMessage()
            ], 422);
        }
        return response()->json([
            'statusCode' => 200,
            'message'    => 'OK',
            'data'       => new PlayerResource($player)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->playerServices->deletePlayer($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Players not found.'
            ], 404);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
        return response()->json([
            'statusCode' => 200,
            'message'    => 'OK'
        ], 200);
    }
}
