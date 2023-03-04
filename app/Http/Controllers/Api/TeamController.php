<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Http\Resources\Teams\TeamCollection;
use App\Http\Resources\Teams\TeamResource;
use App\Services\TeamServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    protected TeamServices $teamServices;

    public function __construct(TeamServices $teamServices)
    {
        return $this->teamServices = $teamServices;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $teams = $this->teamServices->getTeams($request);
        } catch (\Exception $error) {
            return response([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
        return response()->json([
            'statusCode' => 200,
            'message'    => 'OK',
            'data'       => new TeamCollection($teams)
        ], 200);
    }

    public function show(): JsonResponse
    {
        return response()->json([
            'statusCode' => 404,
            'message'    => 'NOT FOUND',
            'error'      => 'Teams not found.'
        ], 404);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        try {
            $this->teamServices->createTeam($request);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, $id): JsonResponse
    {
        try {
            $team = $this->teamServices->updateTeam($request, $id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Teams not found.'
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
            'data'       => new TeamResource($team)
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
            $this->teamServices->deleteTeam($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Teams not found.'
            ], 404);
        }catch (\Exception $error) {
            return response()->json([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
        return response()->json([
            'statusCode' => 200,
            'message'    => 'OK'
        ]);
    }
}
