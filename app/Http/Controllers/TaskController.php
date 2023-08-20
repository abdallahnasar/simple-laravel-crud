<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\User;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Flash;
use Response;

class TaskController extends Controller
{
    /** @var TaskRepository $taskRepository*/
    private $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->middleware('auth');
        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Task.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $tasks = $this->taskRepository->all();
        return view('tasks.index')
            ->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new Task.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::get()->pluck('name','id')->toArray();

        return view('tasks.create')
            ->with('users', $users);
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param CreateTaskRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskRequest $request)
    {
        $input = $request->all();

        $task = $this->taskRepository->create($input);

        Flash::success('Task saved successfully.');

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified Task.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        return view('tasks.show')->with('task', $task);
    }

    /**
     * Show the form for editing the specified Task.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $task = $this->taskRepository->find($id);
        $users = User::get()->pluck('name','id')->toArray();

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        return view('tasks.edit')->with('task', $task)->with('users', $users);
    }

    /**
     * Update the specified Task in storage.
     *
     * @param int $id
     * @param UpdateTaskRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskRequest $request)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        $task = $this->taskRepository->update($request->all(), $id);

        Flash::success('Task updated successfully.');

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified Task from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        $this->taskRepository->delete($id);

        Flash::success('Task deleted successfully.');

        return redirect(route('tasks.index'));
    }
}
