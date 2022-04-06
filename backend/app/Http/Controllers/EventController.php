<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EventController extends Controller
{

    /**
     * Create a new EventController instance.
     *
     * @return void
     */



    public function __construct()
    {
        $this->max_win = 3;
        $this->middleware('auth:api',[]);
    }

      /**
     * Register a User.
     *
     */
    public function index(){

        return Event::get();
    }

      /**
     * Register a User.
     *
     */
    public function findRange(Request $request){
        $latitude_range_lower_bound = $request->lat + 0.1;
        $latitude_range_upper_bound = $request->lat - 0.1;
        $longitude_range_lower_bound = $request->long + 0.1;
        $longitude_range_upper_bound = $request->long - 0.1;

        return Event::whereBetween("lat",[$latitude_range_lower_bound,$latitude_range_upper_bound])
        ->whereBetween("long",[$longitude_range_lower_bound,$longitude_range_upper_bound])->get();
    }

      /**
     * Register a Event.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:2,100',
            'description' => 'required|string|min:6',
            'lat' => 'required|string|min:6',
            'long' => 'required|string|min:6',
        ]);

        if($validator->fails()){
             return response()->json($validator->errors(), 400);
        }

        $event = Event::create(array_merge(
                    $validator->validated()
                ));
        return response()->json([
            'message' => 'Event successfully Created',
            'event' => $event,
        ], 201);
    }

      /**
     * Register a Event.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if(!$row = $this->findEventById($request->id)){
            return response()->json(['error' => 'Can not find record.'], 401);
        }
        $row->delete();
    }

	/**
	 * @param $od
	 * @return \App\Models\Event
	 */
	private function findEventById($id)
	{
		return Event::where('id', $id)->firstOrFail();
	}

}