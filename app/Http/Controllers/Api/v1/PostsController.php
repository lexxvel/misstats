<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\posts;

class PostsController extends Controller
{
    public function getAllPosts() {
        return posts::all();
    }

    public function getPostById(Request $request) {
        $id = $request->input('Post_id');
        return posts::where('Post_id', $id)->first();
    }
}
