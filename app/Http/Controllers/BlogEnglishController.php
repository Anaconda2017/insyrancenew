<?php

namespace App\Http\Controllers;

use App\BlogEnglish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogEnglishController extends Controller
{
    private function make_slug($string, $separator = '-') {
        $string = trim($string);
        $string = mb_strtolower($string, 'UTF-8');

        $string = preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);

        $string = preg_replace("/[\s\-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = BlogEnglish::latest()
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Blogs Fetched Successfully',
            'data' => $blogs
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'en_blog_title' => 'required|string|max:255',
            'en_blog_text' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'blog_date' => 'nullable|date',
            'en_meta_title' => 'nullable|string|max:255',
            'en_meta_text' => 'nullable|string|max:255',
            'en_first_script_text' => 'nullable|string|max:255',
            'en_second_script_text' => 'nullable|string|max:255',
            'active_status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Generate slug from title
        $requestArray = $request->all();

        $requestArray['en_slug'] = Str::slug($requestArray['en_blog_title']);
        
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Create directories if they don't exist
            if (!file_exists(public_path('uploads/blog'))) {
                mkdir(public_path('uploads/blog'), 0777, true);
            }
            
            // Process image
            $image = Image::make($file->getRealPath());
            $image->encode('webp', 80)->save(public_path('uploads/blog/' . $fileName));

            $requestArray['main_image'] = 'uploads/blog/' . $fileName;
        }
        
        // Ensure slug uniqueness
        $count = 1;
        while (BlogEnglish::where('en_slug', $requestArray['en_slug'])->exists()) {
            $requestArray['en_slug'] = Str::slug($requestArray['en_blog_title']) . '-' . $count;
            $count++;
        }

        $blog = BlogEnglish::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Blog Added Successfully',
            'data' => $blog
        ], 200);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = BlogEnglish::findorFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Blog Fetched Successfully',
            'data' => $row
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            
            $row = BlogEnglish::findorFail($id);


            return response()->json([
                'blog' => $row,
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'No Blog Found'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $blog = BlogEnglish::findorFail($id);
        $validator = Validator::make($request->all(), [
            'en_blog_title' => 'required|string|max:255',
            'en_blog_text' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'blog_date' => 'nullable|date',
            'en_meta_title' => 'nullable|string|max:255',
            'en_meta_text' => 'nullable|string|max:255',
            'en_first_script_text' => 'nullable|string|max:255',
            'en_second_script_text' => 'nullable|string|max:255',
            'active_status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $fileName = time() . Str::random(10) . '.webp';

            // Delete old image if exists
            if ($blog->main_image) {
                $oldImage = public_path('uploads/blog/' . $blog->main_image);
                if (file_exists($oldImage)) unlink($oldImage);
            }

            // Process image
            $image = Image::make($file->getRealPath()); 
            $image->encode('webp', 80)->save(public_path('uploads/blog/' . $fileName));

            $requestArray['main_image'] = 'uploads/blog/' . $fileName;
        }

        $blog->update($requestArray);
        return response()->json([
            'success' => true,
            'message' => 'Blog Updated Successfully',
            'data' => $blog
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = BlogEnglish::findorFail($id);
        $blog->update(['active_status' => 0]);
       
        return response()->json([
            'success' => true,
            'message' => 'Blog Deleted Successfully',
            'data' => $blog
        ], 200);
    }

    public function recover($id)
    {
        $blog = BlogEnglish::findorFail($id);

        $blog->update([
            'active_status' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blog Recovered Successfully',
            'data' => $blog
        ], 200);
    }
}
