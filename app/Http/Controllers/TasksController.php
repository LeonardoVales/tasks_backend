<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Carbon\Carbon;

class TasksController extends Controller
{

    protected $taskModel;

    public function __construct()
    {
        $this->taskModel = new Task;
    }

    // 2020-04-18 23:59:59
    //Esse seria o método getTasks
    public function index($date = null)
    {
        
        $user = \Auth::user();
        
        if (is_null($date)) {

            $startDay = Carbon::now()->startOfDay();
            $date     = $startDay->copy()->endOfDay();

            $tasks = Task::where('userId', $user->id)
                    ->where('estimateAt', '<=', $date->format('Y-m-d H:i:s'))
                    ->get();
            
        } else {

            $tasks = Task::where('userId', $user->id)
                    ->where('estimateAt', '<=', $date)
                    ->get();
            
        }

        
        return response()->json($tasks);
    
    }

    public function create(Request $request)
    {
        $dados = [
            'desc'       => $request['desc'],
            'estimateAt' => date_create($request['estimateAt'])->format('Y-m-d H:i:s'),
            // 'doneAt'     => date_create($request['doenAt'])->format('Y-m-d H:i:s'),
            'userId'     => \Auth::user()->id
        ];
        
        try {

            $task = Task::create($dados);
            return response()->noContent();
            
        } catch(\Exception $e) {

            return response()->json(['Error' => $e->getMessage()], 400);

        }
    }

    public function delete($id)
    {
        $task = Task::where('id', $id)->where('userId', \Auth::user()->id)->first();

        if ($task) {

            try {

                $task->delete();
                return response()->noContent();
    
            } catch (\Exception $e) {
                return response()->json(['Error' => $e->getMessage()], 400);
            }

        }

    }

    public function toggleTask($id)
    {
        $task = Task::where('id', $id)->where('userId', \Auth::user()->id)->first();
        
        if ($task) {

            $doneAt = (!is_null($task->doneAt) ? null : Carbon::now()->format('Y-m-d H:i:s'));
            
            $this->taskModel->updateTaskDoneAt($task, $doneAt);

        } else {
            return response()->json(['Error' => 'Task não encontrada'], 400);
        }
    }
}
