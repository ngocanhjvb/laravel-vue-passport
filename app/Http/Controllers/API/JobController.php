<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return response()->json(Job::latest()->paginate(5));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'area' => 'required|string',
            'code' => 'required|string|unique:jobs',
        ]);
        $job = Job::create([
            'name' => $request['name'],
            'area' => $request['area'],
            'code' => $request['code'],
        ]);
        return $job;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'area' => 'required|string',
            'code' => 'required|string|unique:users,email,' . $job->id,
        ]);
        $job->update($request->only('name', 'area', 'code'));
        return ['message' => 'Updated the job info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $job = Job::findOrFail($id);
        // delete the job

        $job->delete();

        return ['message' => 'Job Deleted'];
    }
}
