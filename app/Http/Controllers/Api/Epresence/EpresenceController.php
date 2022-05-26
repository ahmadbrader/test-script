<?php

namespace App\Http\Controllers\Api\Epresence;

use App\Http\Controllers\Controller;
use App\Http\Resources\EpresenceCollection;
use App\Http\Resources\EpresenceResource;
use App\Models\Epresences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use League\Fractal;


class EpresenceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'waktu' => 'required',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }
        $request->type = strtoupper($request->type);
    
        $check = Epresences::where('id_user', auth()->user()->id)->where('type', $request->type)
                ->whereDate('waktu', date('d-m-Y', strtotime($request->waktu)))
                ->exists();
        if ($check)
        {
            return response()->json([
                'error' => true,
                'message' => 'duplicate'
            ], 400);
        }

        try {
            $insert = Epresences::create([
                'id_user' => auth()->user()->id,
                'type' => $request->type,
                'waktu' => $request->waktu
            ]);
            return response()->json([
                'error' => false,
                'message' => 'successfully save data',
                'data' => new EpresenceResource($insert)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'failed to save data'
            ], 400);
        }
    }

    public function responseEpresence(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'is_approve' => 'required',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }
        $data = Epresences::find($request->id);
        $data->is_approve = $request->is_approve;
        $data->save();
        return response()->json([
            'error' => false,
            'message' => 'success',
            'data' => new EpresenceResource($data)
        ],200);
    }

    public function myData()
    {
        $data = Epresences::where('id_user', auth()->user()->id)->where('type', 'IN')->get();
        $result = new EpresenceCollection($data);
        return response()->json([
            'error' => false,
            'message' => 'success get data',
            'data' => $result
        ]);
    }
}
