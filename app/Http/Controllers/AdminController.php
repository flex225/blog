<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use App\Category;
use App\Subcategory;

class AdminController extends Controller
{
    public function createPostType(Request $request) {
      $category = $request->category;
      $this->validate($request, array(
          'category' => 'required',
      ));

      $post_category = new Category();
      $post_category->category_name = $category;
      $post_category->save();
      return redirect()->back();
    }

    public function createPostSubType(Request $request) {
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

    public function deletePostSubtype(Request $request) {

      $id = $request->deleteSubcategory;
      $category = SubCategory::find($id);
      $category->delete();

      return redirect()->back();
    }

    public function deletePostType(Request $request) {

      $id = $request->deleteCategory;
      $category = category::find($id);
      $category->delete();

      return redirect()->back();
    }

    public function adminSingin(Request $request) {
      $this->validate($request, [
        'username' => 'required',
        'password' => 'required'
      ]);

      if(Auth::attempt(['username' => $request['username'],
    'password' => $request['password']])) {
      return redirect()->route('controlpage');
    }
    return redirect()->route('admin');

    }

    public function getAllPosts() {
      $posts = DB::table('posts')->get();

      return view('pages.admin.adminPosts', compact('posts'));
    }

    public function getAllUsers() {
      $users = DB::table('users')->get();

      return view('pages.admin.adminUsers', compact('users'));
    }

    public function getAdminPage() {
      $treeView = Category::with(['subcategories'])->get();
      $post_subtype = DB::table('post_category')
      ->select('post_subcategory.id as id', 'category_name','subcategory_name')
      ->join('post_subcategory', 'post_category.id', '=', 'category_id')
      ->get();

      $post_type = DB::table('post_category')
      ->select('id', 'category_name')
      ->orderby('id')->get();
      return view('pages.admin.controlpage', compact('post_type', 'treeView','post_subtype'));
    }

    public function getLogout() {
      Auth::logout();
      return redirect()->route('admin');
    }

}
