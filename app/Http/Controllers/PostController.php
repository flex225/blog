<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use Session;
use Illuminate\Support\Facades\Input;
use DB;
use Auth;
use App\Category;
use App\Subcategory;
use Redirect;
use File;
use PDO;
use App\Image;
use Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $treeView = Category::with(['subcategories'])->get();
        $posts = Post::orderby('created_at', 'desc')->paginate(10);
        $subcategories = DB::table('post_subcategory')->get();
        $post_and_category = DB::table('post_and_category')->select('*')->get();
        return view('posts.index', compact('treeView', 'posts', 'subcategories', 'post_and_category'));
    }

    public function updateFilter(Request $request)
    {
        $treeView = Category::with(['subcategories'])->get();
        $subcategories = Subcategory::all();
        $checkboxes = $request->checklist;
        DB::setFetchMode(PDO::FETCH_COLUMN);
        $post_id = DB::table('post_and_category')->select('post_id')->whereIn('subcategory_id', $checkboxes)->get();
        DB::setFetchMode(PDO::FETCH_CLASS);
        $posts = DB::table('posts')->select('*')->whereIn('id', $post_id)->paginate(10);
        $post_and_category = DB::table('post_and_category')->select('*')->get();
        return view('posts.index', compact('post_id', 'treeView', 'posts', 'subcategories', 'post_and_category'));
    }

    public function getMyPosts()
    {
        $id = Auth::user()->id;

        $treeView = Category::with(['subcategories'])->get();
        $posts = DB::table('posts')
            ->select("*")
            ->where('user_id', '=', $id)
            ->orderby('created_at', 'desc')
            ->paginate(10);
        $subcategories = DB::table('post_subcategory')->get();
        $post_and_category = DB::table('post_and_category')->select('*')->get();
        return view('posts.myposts', compact('treeView', 'posts', 'subcategories', 'post_and_category'));

        // $posts = DB::table('posts')->select('*')
        //     ->orderby('created_at', 'desc')->paginate(10);
        //
        // return view('posts.myposts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post_category = Category::all();
        $ages = DB::table('human_ages')->get();
        $statuses = DB::table('human_states')->get();

        return view('posts.create', compact('post_category', 'ages', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'post_type.required' => 'Գրառման տեսակը ընտրելը պարտադիր է։',
            'description.required' => 'Նկարագրությունը լրացնելը պարտադիր է։',
            'description.max' => 'Գաղտանաբառր պետք է լինի ամենաքիչը 6 նիշ',
            'contacts.required' => 'Ինչպես կապնվել տողը լրացնելը պարտադիր է։',
            'category.required' => 'Բաժին ընտրելը պարտադիր է։',
            'subcategory1.required' => 'Ենթաբաժին ընտրելը պարտադիր է։',
        ];
        $this->validate($request, array(
            'post_type' => 'required',
            'description' => 'required|max:1000',
            'contacts' => 'required',
            'image[]' => 'mimes:jpeg,bmp,png',
            'subcategory1' => 'required',
            'category' => 'required',
        ), $messages);

        $post = new Post;
        $user_id = Auth::user()->id;
        if ($request->age != -1) {
            $age = DB::table('human_ages')->select('id', 'age')->where('id', $request->age)->get();
            $post->age = $age[0]->age;
        }
        if ($request->status != -1) {
            $status = DB::table('human_states')->select('id', 'state')->where('id', $request->status)->get();
            $post->state = $status[0]->state;
        }
        $post->user_id = $user_id;
        $post->gender = $request->gender;
        $post->name = $request->name;
        $post->surname = $request->surname;
        $post->post_type = $request->post_type;
        $post->body = $request->description;
        $post->contacts = $request->contacts;
        $post->contacts = $request->contacts;
        $post->save();
        $post_id = $post->id;
        DB::table('post_and_category')->insert([
            ['subcategory_id' => $request->subcategory1, 'post_id' => $post_id]
        ]);
        if ($request->subcategory2 != -1 or empty($request->subcategory2)) {
            DB::table('post_and_category')->insert([
                ['subcategory_id' => $request->subcategory2, 'post_id' => $post_id]
            ]);
        }
        if (Input::hasFile('image')) {
            $files = Input::file('image');
            $username = Auth::user()->username;
            $post_dir = "post_pictures";
            $directory = $post_dir . "/" . $username;
            foreach ($files as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileRealName = str_replace(" ", "_", $fileRealName);
                $fileName = rand(11111, 99999) . '_' . $fileRealName;
                if (!file_exists($directory)) {
                    $dir = mkdir($directory, 0777, true);
                }
                $file->move($directory, $fileName);
                $img = new Image();
                $img->img_src = $fileName;
                $img->post_id = $post_id;
                $img->save();
                Log::info("image saved:id=" . $img->id);
            }
        }

        Log::info("post created:id=" . $post->id);


        Session::flash('success', 'Ձեր գրառում է պահպանված է');

        return redirect()->route('posts.show', $post->id);
    }

    public function getSubcategories()
    {
        $id = $_GET['id'];
        $subcategory = DB::table('post_subcategory')->select('*')->where('category_id', '=', $id)->get();
        $categories = "";
        foreach ($subcategory as $category) {
            $categories .= "<option value='";
            $categories .= $category->id . "'>";
            $categories .= $category->subcategory_name;
            $categories .= "</option>";
        }
        echo $categories;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = DB::table('posts')->select('posts.id', 'posts.name', 'posts.surname',
            'posts.gender', 'posts.post_type', 'posts.body',
            'posts.contacts', 'posts.created_at', 'posts.updated_at',
            'users.first_name', 'users.username', 'users.last_name', 'users.id as user_id', 'posts.age', 'posts.state')
            ->join('users', 'posts.user_id', '=', 'users.id')->where('posts.id', $id)->get();
        $photos = DB::table('images')->select('id', 'img_src')->where('post_id', $id)->get();
        return view('posts.show', compact('post', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $treeView = Category::with(['subcategories'])->get();
        $post_category = Category::all();
        $post_and_category = DB::table('post_and_category')->select('*')->where('post_id', '=', $id)->get();
        $ages = DB::table('human_ages')->get();
        $statuses = DB::table('human_states')->get();
        $post = DB::table('posts')->select('posts.id', 'posts.name', 'posts.surname',
            'posts.gender', 'posts.post_type', 'posts.body',
            'posts.contacts', 'posts.created_at', 'posts.updated_at',
            'users.first_name', 'users.last_name', 'users.id as user_id', 'posts.age', 'posts.state')
            ->join('users', 'posts.user_id', '=', 'users.id')->where('posts.id', $id)->get();
        $photos = DB::table('images')->select('id', 'img_src')->where('post_id', $id)->get();
        return view('posts.edit', compact('treeView', 'post_and_category', 'post_category', 'ages', 'statuses', 'post', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'post_type.required' => 'Գրառման տեսակը ընտրելը պարտադիր է։',
            'description.required' => 'Նկարագրությունը լրացնելը պարտադիր է։',
            'contacts.required' => 'Ինչպես կապնվել տողը լրացնելը պարտադիր է։',
            'category.required' => 'Բաժին ընտրելը պարտադիր է։',
            'subcategory1.required' => 'Ենթաբաժին ընտրելը պարտադիր է։',
        ];
        $this->validate($request, array(
            'post_type' => 'required',
            'contacts' => 'required',
            'image[]' => 'mimes:jpeg,bmp,png',
            'checklist' => 'required|max:2',
        ), $messages);

        $post = Post::find($id);
        $user_id = Auth::user()->id;
        if ($request->age == -1) {
            $age = DB::table('human_ages')->select('id', 'age')->where('id', $request->age)->get();
            $post->age = "";
        } else {
            $age = DB::table('human_ages')->select('id', 'age')->where('id', $request->age)->get();
            $post->age = $age[0]->age;
        }
        if ($request->status == -1) {
            $status = DB::table('human_states')->select('id', 'state')->where('id', $request->status)->get();
            $post->state = "";
        } else {
            $status = DB::table('human_states')->select('id', 'state')->where('id', $request->status)->get();
            $post->state = $status[0]->state;
        }
        $post->user_id = $user_id;
        $post->gender = $request->gender;
        $post->name = $request->name;
        $post->surname = $request->surname;
        $post->post_type = $request->post_type;
        $post->body = $request->description;
        $post->contacts = $request->contacts;
        $post->contacts = $request->contacts;
        $post->save();
        $post_id = $post->id;
        DB::table('post_and_category')->where('post_id', $post_id)
            ->update([
                'subcategory_id' => $request->checklist[0]
            ]);
        if (count($request->checklist) > 1) {
            if ($request->checklist[1] != null) {
                DB::table('post_and_category')->where('post_id', $post_id)
                    ->update([
                        'subcategory_id' => $request->checklist[1]
                    ]);
            }
        }
        
        if (Input::hasFile('image')) {
            $files = Input::file('image');
            $username = Auth::user()->username;
            $post_dir = "post_pictures";
            $directory = $post_dir . "/" . $username;
            foreach ($files as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileRealName = str_replace(" ", "_", $fileRealName);
                $fileName = rand(11111, 99999) . '_' . $fileRealName;
                if (!file_exists($directory)) {
                    $dir = mkdir($directory, 0777, true);
                }
                $file->move($directory, $fileName);
                $img = new Image();
                $img->img_src = $fileName;
                $img->post_id = $post_id;
                $img->save();
                Log::info("image saved:id=" . $img->id);
            }
        }

        Log::info("post updated:id=" . $post_id);

        Session::flash('success', 'Ձեր գրառում է պահպանված է');

        return redirect()->route('posts.show', $post->id);


        Session::flash('success', 'The blog post was successfully save!');

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return Redirect::to('/myposts');
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        $images = Image::where('post_id', '=', $id)->get();
        $username = Auth::user()->username;
        $post_dir = "post_pictures";
        $directory = $post_dir . "/" . $username;

        if (file_exists($directory)) {
            if ($folder = opendir($directory)) {
                foreach ($images as $image) {
                    while ($file = readdir($folder)) {
                        if (strcmp($image->src_img, $file) && $file != "." && $file != "..") {
                            if (unlink($directory . "/" . $file)) {
                                Log::info("deleted" . $file);
                            }
                        }
                    }
                }
            }
        }

        $post->delete();
        return Redirect::to('/myposts');
    }
}
