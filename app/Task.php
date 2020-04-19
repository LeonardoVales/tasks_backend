<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table    = 'tasks';
    protected $fillable = ['desc', 'estimateAt', 'doneAt', 'userId'];

    public function updateTaskDoneAt(Task $task, $doneAt)
    {
        
        if ($task) {

            try {

                $task->update(['doneAt' => $doneAt]);
                
               return response()->noContent();
    
            } catch (\Exception $e) {
                return response()->json(['Error' => $e->getMessage()], 400);
            }

        }

    }
}
