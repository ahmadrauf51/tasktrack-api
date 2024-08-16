<?php
namespace App\Http\Controllers;
use App\Models\Task;
use  Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TaskController extends Controller
{
    public $baseClass;
    public function __construct( )
    {
        $this->baseClass = new BaseController();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('subtasks')->where('user_id',auth()->id())->latest()->get();
        return $this->baseClass->success('Task list.',$tasks, 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'parent_task_id' => 'nullable|integer|exists:tasks,id',
        ]);
        if ($validator->fails()) {
            return $this->baseClass->error([
                'errors' => $validator->errors()->all(),
            ], 422);
        }
        try{
            DB::beginTransaction();
            $task = Task::create($validator->validate());
            DB::commit();
            return $this->baseClass->success('This new task is created.',$task, 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->baseClass->error($e->getMessage(), 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if($task){
            return $this->baseClass->success('This task is found',$task, 200);
        }
        return $this->baseClass->error('Task not found!',null,404);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if($task){
            return $this->baseClass->success($task,null,200);
        }
        return $this->baseClass->error('Task not found!',null,404);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'parent_task_id' => 'nullable|integer|exists:tasks,id',
        ]);
        if ($validator->fails()) {
            return $this->baseClass->error([
                'errors' => $validator->errors()->all(),
            ], 422);
        }
        try {
            DB::beginTransaction();
            if($task){
                $task->update($validator->validate());
                DB::commit();
                return $this->baseClass->success($task,null,202);
            }
            return $this->baseClass->error('Task not found!',null,404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->baseClass->error($e->getMessage(), 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if($task){
            $task->delete();
            return $this->baseClass->success('Task deleted successfully!',null,204);
        }
        return $this->baseClass->error('Task not found!',404);
    }
}