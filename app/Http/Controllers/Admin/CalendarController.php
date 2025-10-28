<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $users = User::role('mechanic')->get();
        return view('calendar.index', compact('users'));
    }

    public function events(Request $request) : JsonResponse
    {
        $params = $request->all();
        $start = Carbon::parse($params['start']);
        $end = Carbon::parse($params['end']);
        $events = Calendar::whereBetween('start', [$start, $end])->get();

        return response()->json($events);
    }

    public function store(Request $request) : JsonResponse
    {
        $params = $request->all();
        
        $model = Calendar::create([
            'type' => Calendar::TYPE_NORMAL,
            'title' => $params['title'],
            'start' => $params['start'],
            'end' => $params['end'],
            'note' => $params['note'],
            'user_id' => $params['userId']
        ]);

        return response()->json(['id' => $model->id]);
    }

    public function update(Request $request)
    {
        $params = $request->all();
        if(isset($params['id'])){  
            $model = Calendar::find($params['id']);
            $model->title = $params['title'] ?? $model->title;
            $model->start = $params['start'] ?? $model->start;
            $model->end = $params['end'] ?? $model->end;
            $model->note = $params['note'] ?? $model->note;
            if($model->save()){
                return response()->json(['id' => $model->id]);
            }
        }
    }

    public function delete(Request $request)
    {
        $params = $request->all();
        dd($params);
    }
}
