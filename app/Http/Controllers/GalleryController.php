<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();

            $basename = uniqid() . time();
            $smallFilename  = "small_{$basename}.{$extension}";
            $mediumFilename  = "medium_{$basename}.{$extension}";
            $largeFilename  = "large_{$basename}.{$extension}";

            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);

            $request->file('picture')->storeAs("posts_image", $smallFilename);
            $request->file('picture')->storeAs("posts_image", $mediumFilename);
            $request->file('picture')->storeAs("posts_image", $largeFilename);

            // small
            $smallThumbnailPath = storage_path("app/public/posts_image/{$smallFilename}");
            $this->createThumbnail($smallThumbnailPath, 150, 93);
            //medium
            $mediumThumbnailPath = storage_path("app/public/posts_image/{$mediumFilename}");
            $this->createThumbnail($mediumThumbnailPath, 300, 185);
            //large
            $largeThumbnailPath = storage_path("app/public/posts_image/{$largeFilename}");
            $this->createThumbnail($largeThumbnailPath, 550, 340);
        } else {
            $filenameSimpan = 'noimage.png';
        }

        // dd($request->input());
        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = array(
            'gallery' => Post::find($id)
        );
        return view('gallery.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'description' => 'nullable',
            'picture' => 'image|required|max:1999'
        ]);

        $post = Post::find($id);

        if ($request->hasFile('picture')) {
            File::delete(public_path() . '/storage/posts_image/' . $post->picture);
            File::delete(public_path() . '/storage/posts_image/large_' . $post->picture);
            File::delete(public_path() . '/storage/posts_image/medium_' . $post->picture);
            File::delete(public_path() . '/storage/posts_image/small_' . $post->picture);

            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();

            $basename = uniqid() . time();
            $smallFilename  = "small_{$basename}.{$extension}";
            $mediumFilename  = "medium_{$basename}.{$extension}";
            $largeFilename  = "large_{$basename}.{$extension}";

            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);

            $request->file('picture')->storeAs("posts_image", $smallFilename);
            $request->file('picture')->storeAs("posts_image", $mediumFilename);
            $request->file('picture')->storeAs("posts_image", $largeFilename);

            // small
            $smallThumbnailPath = storage_path("app/public/posts_image/{$smallFilename}");
            $this->createThumbnail($smallThumbnailPath, 150, 93);
            //medium
            $mediumThumbnailPath = storage_path("app/public/posts_image/{$mediumFilename}");
            $this->createThumbnail($mediumThumbnailPath, 300, 185);
            //large
            $largeThumbnailPath = storage_path("app/public/posts_image/{$largeFilename}");
            $this->createThumbnail($largeThumbnailPath, 550, 340);
        } else {
            $filenameSimpan = 'noimage.png';
        }

        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->update();

        return redirect('gallery')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        // dd(public_path() . '/storage/posts_image/' . $post->picture);
        File::delete(public_path() . '/storage/posts_image/' . $post->picture);
        File::delete(public_path() . '/storage/posts_image/large_' . $post->picture);
        File::delete(public_path() . '/storage/posts_image/medium_' . $post->picture);
        File::delete(public_path() . '/storage/posts_image/small_' . $post->picture);
        $post->delete();
        return redirect('gallery')->with('success', 'Berhasil hapus data');
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/gallery",
     *     tags={"gallery"},
     *     summary="Returns a Sample API gallery response",
     *     description="A sample gallery to test out the API",
     *     operationId="galler",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function api()
    {
        $data = array(
            'galleries' => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->get()
        );
        return response()->json($data);
    }
}
