<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Standings\StandingResource;
use App\Models\Standing;
use App\Services\StandingServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    protected StandingServices $standingServices;

    public function __construct(StandingServices $standingServices)
    {
        return $this->standingServices = $standingServices;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $standings = $this->standingServices->getStanding($request);
        } catch (\Exception $error) {
            return response([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
        return response()->json([
            'statusCode' => 200,
            'message'    => "OK",
            'data'       => StandingResource::collection($standings),
        ], 200);
    }

    public function changePool(Request $request, $id): JsonResponse
    {
        try {
            $standing = $this->standingServices->changePool($request, $id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Standings not found.'
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
            'message'    => "OK",
            'data'       => new StandingResource($standing)
        ], 200);
    }
}
