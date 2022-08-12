<?php

namespace App\Http\Controllers;

use App\Models\RoomTemplate;
use Illuminate\Http\Request;
use Validator;

class RoomTemplateController extends Controller
{
    /**
     * Display  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //get all data ...
            $data = RoomTemplate::where('is_active', 1)->get();
            return response()->json(['data' => $data], 200);

        } catch (\Illuminate\Database\QueryException $ex) {
            //query error ...
            return response()->json($ex, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //get request data ...
            // $requestData = json_decode($request->getContent());
            $requestData = $request->all();
            $arrData = [
                'room_price' => isset($requestData['room_price']) ? $requestData['room_price'] : "",
                'room_description' => isset($requestData['room_description']) ? $requestData['room_description'] : "",
                'is_active' => 1,
            ];

            //validate ...
            $validator = Validator::make($arrData, [
                'room_price' => 'required|integer',
                'room_description' => 'required|string',
                'is_active' => 'required|integer',
            ]);

            //validation ...
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }

            //create ...
            $roomTemplate = RoomTemplate::create($arrData);
            $response = ['data' => $roomTemplate, 'message' => 'Successfully saved.'];
            return response()->json($response, 200);

        } catch(\Illuminate\Database\QueryException $ex) { 
            //query error ...
            return response()->json($ex, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomTemplate $room
     * @return \Illuminate\Http\Response
     */
    public function show(RoomTemplate $room)
    {
        return response()->json(['data' => $room], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\RoomTemplate $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomTemplate $room) {

        // return $request->getContent();

        try {
            //get request data ...
            // $requestData = json_decode($request->getContent());
            $requestData = $request->all();
            $arrData = [
                'room_price' => isset($requestData['room_price']) ? $requestData['room_price'] : "",
                'room_description' => isset($requestData['room_description']) ? $requestData['room_description'] : "",
                'is_active' => 1,
            ];

            //validate ...
            $validator = Validator::make($arrData, [
                'room_price' => 'required|integer',
                'room_description' => 'required|string',
                'is_active' => 'required|integer',
            ]);

            //validation ...
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }
      
            //update ...
            $room->update($arrData);
            return response()->json(['message' => 'Successfully updated.'], 200);

        } catch(\Illuminate\Database\QueryException $ex) { 
            //query error ...
            return response()->json($ex, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomTemplate $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomTemplate $room)
    {
        try {
            //update status to inactive | active ...
            $room->where('id', $room->id)->update(['is_active' => $room->is_active == 0 ? 1 : 0]);
            return response()->json(['message' => "Successfully deleted."], 200);

        } catch(\Illuminate\Database\QueryException $ex) { 
            //query error ...
            return response()->json($ex, 500);
        }
    }
}
