<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedules\StoreScheduleRequest;
use App\Http\Resources\Schedules\ScheduleResource;
use App\Http\Resources\Teams\TeamResource;
use App\Models\Schedule;
use App\Models\Team;
use App\Services\ScheduleServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected ScheduleServices $scheduleServices;

    public function __construct(ScheduleServices $scheduleServices)
    {
        return $this->scheduleServices  = $scheduleServices;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $schedules = $this->scheduleServices->getSchedules($request);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
        return response()->json([
            'statusCode' => 200,
            'message'    => 'OK',
            'data'       => ScheduleResource::collection($schedules)
        ], 200);
    }

    public function store(StoreScheduleRequest $request): JsonResponse
    {
        try {
            $this->scheduleServices->createSchedule($request);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 422,
                'message'    => 'UNPROCESSABLE',
                'error'      => $error->getMessage()
            ], 422);
        }
        return response()->json([
            'statusCode' => 201,
            'message'    => 'CREATED'
        ], 201);
    }

    public function show(Request $request, $slug): JsonResponse
    {
        try {
            $schedules = $this->scheduleServices->getSpecificSchedule($request, $slug);
            if ($schedules->isNotEmpty()) {
                return response()->json([
                    'statusCode' => 200,
                    'message'    => 'OK',
                    'data'       => TeamResource::collection($schedules),
                ], 200);
            }
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Team not found.'
            ], 404);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->scheduleServices->deleteSchedule($id);
            return response()->json([
                'statusCode' => 200,
                'message'    => 'OK'
            ], 200);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Teams not found.'
            ], 404);
        } catch (\Exception $error) {
            return response()->json([
                'statusCode' => 500,
                'message'    => 'INTERNAL SERVER ERROR',
                'error'      => $error->getMessage()
            ], 500);
        }
    }
}
