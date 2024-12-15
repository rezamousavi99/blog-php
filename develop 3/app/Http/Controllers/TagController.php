<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function createTagApi(Request $request){
        $tagId = DB::table('tags')->insertGetId(['caption' => $request->input('caption'),]);
        return response()->json(['message' => 'Tag created successfully', 'tag-id' => $tagId]);

    }

    public function showAllTagsApi(){
        $tags = DB::table('tags')->get();

        return response()->json(['message' => 'All tags retrieved successfully', 'tags' => $tags]);

    }
}
