<?php

namespace App\Http\Controllers\API;

use App\Company;
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
        $user = auth()->user();
        if ($user->company) {
            $user->companyName = $user->company->name;
        } else {
            $user->companyName = null;
        }
        return $user;
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

    public function enterCompany(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->users()->attach([
            auth()->id() => ['status' => WAITING]
        ]);

        return response()->json(['message' => "Enter $company->name !!!"]);

    }

    public function layOff()
    {
        $user = auth()->user();
        $user->company()->dissociate();
        $user->save();
        return response()->json(['message' => "Layoff !!!"]);
    }

    public function retract(Request $request)
    {
        $companies = auth()->user()->companies;
        $filter = $companies->filter(function ($value, $key) {
            return $value->pivot->status == WAITING;
        });
        $companyId = $filter->first()->id;
        $companyName = $filter->first()->name;
        auth()->user()->companies()->updateExistingPivot($companyId, ['status' => 2]);
        return response()->json(['message' => "Retract $companyName !!!"]);
    }


    public function checkInvitation()
    {
        $user = auth()->user();
        $filter = [];
        foreach ($user->companies as $company) {
            if ($company->pivot->status == 1) {
                $filter[] = $company;
            }
        }
        if (empty($filter)) {
            return null;
        }
        return response()->json($filter[0]->name);
    }

    public function getListCompanies()
    {
        $user = auth()->user();
        $companies = Company::all();
        foreach ($companies as $key => $company) {
            if ($company->users->contains($user)) {
                foreach ($company->users as $user) {
                    if ($user->id == auth()->id() && $user->pivot->status == WAITING) {
                        unset($companies[$key]);
                    }
                }
            }
        }

        return response()->json($companies);
    }
}
