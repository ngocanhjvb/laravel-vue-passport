<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//         $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return response()->json(User::with('job')->latest()->paginate(5));
        }
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
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'type' => 'required',
        ]);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request->type,
            'bio' => $request->bio,
            'photo' => 'profile.png',
            'password' => Hash::make($request['password']),
        ]);

        return $user;


    }


    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();


        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:6'
        ]);


        $currentPhoto = $user->photo;


        if ($request->photo != $currentPhoto) {
            $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/') . $name);
            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/') . $currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }

        }


        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }


        $user->update($request->all());
        return ['message' => "Success"];
    }


    public function profile()
    {
        return auth('api')->user();
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:6'
        ]);
        $user->update($request->only('name', 'email', 'bio', 'password', 'type'));
        return ['message' => 'Updated the user info'];
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

        $user = User::findOrFail($id);
        // delete the user

        $user->delete();

        return ['message' => 'User Deleted'];
    }

    public function search()
    {
        if ($search = \Request::get('query')) {
            $users = User::with('job')->whereLike(['name', 'job.code', 'job.name'], $search)->paginate(5);
        } else {
            $users = User::with('job')->latest()->paginate(5);
        }
        return response()->json($users);
    }

    public function getInfo()
    {
        $companies = auth()->user()->companies->filter(function ($value, $key) {
            return $value->status === WAITING;
        });
        return response()->json($companies);
    }

    public function getFreeUser($id)
    {
        $freeUser = User::with(['company', 'job'])->doesntHave('company')->get();
        $filter = $freeUser->filter(function ($value, $key) use ($id) {
            return !$value->companies->contains($id);
        });
        return response()->json($filter);
    }

    public function accept($id)
    {
        $user = auth()->user();
        $user->company()->associate($id);
        $user->save();
        $user->companies()->updateExistingPivot($id, ['status' => 2]);
        return response()->json(['message' => "Accept !!!"]);
    }

    public function refuse($id)
    {
        $user = auth()->user();
        $user->companies()->updateExistingPivot($id, ['status' => 0]);
        return response()->json(['message' => "Refuse !!!"]);
    }

    public function layOff()
    {
        $user = auth()->user();
        $user->company()->dissociate();
        $user->save();
        return response()->json(['message' => "Layoff !!!"]);
    }
}
