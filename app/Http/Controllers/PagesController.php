<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use User;

class PagesController extends Controller {

		public function getIndex() {
			return view('pages.welcome');
		}

		public function getAbout() {
			$first = 'Artur';
			$last = 'Akhnoyan';

			$fullname = $first . " " . $last;
			$email = 'aakhnoyan@gmail.com';
			$data = [];
			$data ['email'] = $email;
			$data ['fullname'] = $fullname;
			return view('pages.about')->withData($data);
		}

		public function getContact() {
			return view('pages.agreement');
		}

		public function getAdmin() {
			return view('pages.admin.admin');
		}
		public function getUserInfo($id){
			$user = DB::table('users')->where('id', '=', $id)->get();
			$feedbacks = DB::table('feedbacks')->select('*')->where('to_user', '=', $id)->paginate(5);
			return view('pages.user.profile', compact('feedbacks', 'user'));
		}
		public function leaveFeedback(Request $request) {
			$messages = [
					'feedback.required'    => 'Կարծիքը լրացնելը պարտադիր է։',
			];
			$this->validate($request, array(
				'feedback' => 'required',
			), $messages);
			$to_user = $request->to_user;
			$from_user = Auth::user()->id;
			$feedback = $request->feedback;
			DB::table('feedbacks')->insert([
				['from_user' => $from_user, 'to_user' => $to_user, 'feedback' => $feedback]
			]);
			return redirect()->route('getUserInfo', $to_user);
		}


}
