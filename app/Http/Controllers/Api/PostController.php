<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    public function __construct()
    {
        // $this->middleware('key');
        $this->middleware('basic.auth')->only('store');
    } //-- end of construct

    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //-- first method to paginate the posts
        // $offset = request()->has('offset') ? request()->get('offset') : 0;

        // $posts = PostResource::collection(Post::offset($offset)->limit(10)->get());

        //-- second method to paginate the posts
        $posts = PostResource::collection(Post::latest()->paginate(15));

        return $this->responseTrait($posts);
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
            'title' => ['required', 'max:18', 'min:3', 'string', 'unique:posts'],
            'body'  => ['required', 'max:300', 'min:3', 'string'],
        ];

        $msg =  [
            'title.required' => 'this title required and must write it',
            'body.required' => 'this body required and must write it',
        ];

        $validate = Validator::make($request->all(), $rule, $msg);

        if ($validate->fails()) {
            return $this->responseTrait('null', false, $validate->errors(), 422); //-- error validate
        } //-- end error

        $request = $request->except(['method', 'csrf_token']);

        $request['user_id'] = auth()->user()->id;

        $post = Post::create($request);

        return $this->responseTrait(new PostResource($post), true, null, 201); //-- success create
    } //-- end store function

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id', $id)->first();

        return  $post == null ?  $this->notFountResponse() : $this->responseTrait(new PostResource($post));
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

        $rule = [
            'title' => ['required', 'max:18', 'min:3', 'string',  Rule::unique('posts')->ignore($id)],
            'body'  => ['required', 'max:300', 'min:3', 'string'],
        ];

        $msg =  [
            'title.required' => 'this title required and must write it',
            'body.required' => 'this body required and must write it',
        ];

        $validate = Validator::make($request->all(), $rule, $msg);

        if ($validate->fails()) {
            return $this->responseTrait(null, false, $validate->errors(), 422); //-- 422 error validate
        } //-- end error fails

        $post = Post::where('id', $id)->first();

        if ($post) {
            $request = $request->except(['method', 'csrf_token']);

            $post->update($request);
            return  $this->responseTrait(new PostResource($post), true, null, 201);
        } //-- end of update post

        return $this->notFountResponse();
    } //-- end update function

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();

        if ($post) {
            $post->delete();
            return $this->responseTrait('delete successfully', true, null);
        } //-- end if

        return $this->notFountResponse();
    } //-- end destroy function
} //-- end post controller
