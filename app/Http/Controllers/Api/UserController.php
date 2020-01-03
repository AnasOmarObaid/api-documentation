<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('edit')->only('index');
    // }

    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->responseTrait(UserResource::collection(User::latest()->paginate(10)));
    } //-- end index function


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name'  => ['required', 'max:20', 'min:2', 'string'],
            'email' => ['required', 'unique:users'],
            'password'  => ['required', 'min:9', 'max:20']
        ];

        $msg = [
            'name.required'  => 'You Must Enter Name',
            'email.required' => 'We Need Your Email',
            'password.required'  => 'You Should Enter Password'
        ];

        $requestVal = $this->requestValidate($request);
        $validate = Validator::make($requestVal, $rule, $msg);

        if ($validate->fails()) {
            return $this->responseTrait(null, false, $validate->errors(), 422);
        } //-- end if fails

        $user = User::create($requestVal);

        return  $user != null ? $this->responseTrait(new UserResource($user), true, null, 201) : $this->responseTrait(null, false, 'General server error', 500);
    } //-- end store user

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        return $user != null ? $this->responseTrait(new UserResource($user)) : $this->notFountResponse();
    } //-- end show function


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (!$user)
            return $this->notFountResponse();

        $rule = [
            'name'  => ['required', 'max:20', 'min:2', 'string'],
            'email' => ['required', Rule::unique('users')->ignore($id)],
            'password'  => ['required', 'min:9', 'max:20']
        ];

        $msg = [
            'name.required'  => 'You Must Enter Name',
            'email.required' => 'We Need Your Email',
            'password.required'  => 'You Should Enter Password'
        ];

        $requestVal = $this->requestValidate($request);
        $validate = Validator::make($requestVal, $rule, $msg);

        if ($validate->fails()) {
            return $this->responseTrait(null, false, $validate->errors(), 422);
        } //-- end fails error user

        $userUpdate = $user->update($requestVal);

        return  $userUpdate != null ? $this->responseTrait(new UserResource($user)) : $this->responseTrait(null, false, 'General server error', 500);
    } //-- end update function

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return $this->notFountResponse();
        } //-- end not found user

        $user = $user->delete();

        return   $user != null ? $this->responseTrait('delete successfully ', true, null) : $this->responseTrait(null, false, 'General server error', 500);
    } //-- end delete function
}//-- end user controller
