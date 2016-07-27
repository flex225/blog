<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use \Date;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *098960755
     * @var string
     */
    protected $redirectTo = '/myposts';
    protected $username = 'username';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data) {
      $rules = [
            'username' => 'required|max:20|unique:users',
            'email' => 'email|max:255|',
            'password' => 'required|min:6|confirmed',
            'agree' => 'required',
      ];
      $messages = [
      'username.required'    => 'Մուտքանուն լրացնելը պարտադիր է։',
      'username.unique' => 'Մուտքանունն արդեն զբաղված է:',
      'username.max'    => 'Մուտքանուն պետք է լինի 20 տառից ոչ ավել',
      'password.required'    => 'Գաղտնաբառ լրացնելը պարտադիր է։',
      'email.email'    => 'Էլեկտրոնային հասցեն վավեր չէ։',
      'password.min'    => 'Գաղտանաբառր պետք է լինի ամենաքիչը 6 նիշ',
      'password.confirmed'    => 'Գաղտանաբառերը չեն համընկնում',
      'agree.required' => 'ՊԵտք է համաձայն լինել կայքի կանոնակարգին',
      ];
      return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        Log::info("date :".$data['birth_date']);
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birth_date' => date($data['birth_date']),
            'address' => $data['address'],
            'telephone' => $data['telephone'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
