<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use App\Category;
use App\Subcategory;
use App\Post;
use Log;

class AdminController extends Controller
{
    public function createPostType(Request $request)
    {
        $category = $request->category;
        $this->validate($request, array(
            'category' => 'required',
        ));

        $post_category = new Category();
        $post_category->category_name = $category;
        $post_category->save();
        return redirect()->back();
    }

    public function createPostSubType(Request $request)
    {
        $id = $request->category_chooser;
        $subcategory = $request->subcategory;
        $this->validate($request, array(
            'category_chooser' => 'required',
            'subcategory' => 'required',
        ));
        $post_subcategory = new Subcategory();
        $post_subcategory->subcategory_name = $subcategory;
        $post_subcategory->category_id = $id;
        $post_subcategory->save();

        return redirect()->back();
    }

    public function deletePostSubtype(Request $request)
    {

        $id = $request->deleteSubcategory;
        $category = SubCategory::find($id);
        $posts_ids = DB::table('post_and_category')
            ->select('post_id')
            ->where('subcategory_id', "=", $id)->get();
        if ($category->delete()) {
            foreach ($posts_ids as $post) {
                DB::table('posts')->where('id', '=', $post->post_id)->delete();
                Log::info('posts deleted');
            }
        }
        Log::info('subcategory deleted');
        return redirect()->back();
    }

    public function deletePostType(Request $request)
    {

        $id = $request->deleteCategory;
        $category = category::find($id);
        $category->delete();

        return redirect()->back();
    }

    public function adminSingin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $request['username'],
            'password' => $request['password']])
        ) {
            return redirect()->route('controlpage');
        } else {
            $error = "Username and Password didn't match!";
            return view('pages.admin.admin')->with('error', $error);
        }

    }

    public function getAllPosts()
    {
        $treeView = Category::with(['subcategories'])->get();
        $posts = Post::orderby('created_at', 'desc')->paginate(10);
        $subcategories = DB::table('post_subcategory')->get();
        $post_and_category = DB::table('post_and_category')->select('*')->get();
        return view('pages.admin.adminPosts', compact('treeView', 'posts', 'subcategories', 'post_and_category'));
    }

    public function getAllUsers()
    {
        $users = DB::table('users')->paginate(10);

        return view('pages.admin.adminUsers', compact('users'));
    }

    public function getAdminPage()
    {
        $treeView = Category::with(['subcategories'])->orderby('id')->get();
        $post_subtype = DB::table('post_category')
            ->select('post_subcategory.id as id', 'category_name', 'subcategory_name')
            ->join('post_subcategory', 'post_category.id', '=', 'category_id')
            ->get();

        $post_type = DB::table('post_category')
            ->select('id', 'category_name')
            ->orderby('id')->get();
        $ages = DB::table('human_ages')->orderBy('age')->get();
        $states = DB::table('human_states')->orderBy('state')->get();
        return view('pages.admin.controlpage', compact('post_type', 'treeView', 'post_subtype', 'ages', 'states'));
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->activated = false;
        $user->save();
        return redirect()->route('getusers');
    }

    public function recoverUser($id)
    {
        $user = User::find($id);
        $user->activated = true;
        $user->save();
        return redirect()->route('getusers');
    }

    public function addAge(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $age = $from . "-" . $to;
        DB::table('human_ages')->insert([
            ['age' => $age]
        ]);
        return redirect()->route('controlpage');
    }

    public function removeAge(Request $request)
    {
        $id = $request->age;
        DB::table('human_ages')->where('id', '=', $id)->delete();
        return redirect()->route('controlpage');
    }

    public function addState(Request $request)
    {
        $state = $request->state;
        DB::table('human_states')->insert([
            ['state' => $state]
        ]);
        return redirect()->route('controlpage');
    }

    public function removeState(Request $request)
    {
        $id = $request->state;
        DB::table('human_states')->where('id', '=', $id)->delete();
        return redirect()->route('controlpage');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

}
