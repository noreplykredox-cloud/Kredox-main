<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
        $this->middleware('registration.status')->except('registrationNotAllowed');
    }

    public function showRegistrationForm()
    {
        $reference = @$_GET['reference'] ?: @$_GET['node'];
        if ($reference) {
            if (strpos($reference, 'NODE_') === 0) {
                $hex = substr($reference, 5);
                if (preg_match('/^[0-9a-fA-F]+$/', $hex)) {
                    $decoded = @hex2bin($hex);
                    if ($decoded) {
                        $reference = $decoded;
                    }
                }
            }
            session()->put('reference', $reference);
        }
        
        $pageTitle = "Register";
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.auth.register', compact('pageTitle','mobileCode','countries'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $general = gs();
        $passwordValidation = Password::min(6);
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        $agree = 'nullable';
        if ($general->agree) {
            $agree = 'required';
        }
        $countryData = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes = implode(',',array_column($countryData, 'dial_code'));
        $countries = implode(',',array_column($countryData, 'country'));
        $validate = Validator::make($data, [
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|regex:/^([0-9]*)$/',
            'password' => ['required','confirmed',$passwordValidation],
            'username' => 'required|unique:users|min:6',
            'captcha' => 'sometimes|required',
            'agree' => $agree
        ]);
        return $validate;

    }
public function register(Request $request)
{
    $this->validator($request->all())->validate();

    // Username validation
    if(preg_match("/[^a-z0-9_]/", trim($request->username))) {
        if ($request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Username can contain only small letters, numbers and underscore.'], 422);
        }
        $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
        $notify[] = ['error', 'No special character, space or capital letters in username.'];
        return back()->withNotify($notify)->withInput($request->all());
    }

    // Captcha validation
    if(!verifyCaptcha()) {
        if ($request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid captcha provided'], 422);
        }
        $notify[] = ['error','Invalid captcha provided'];
        return back()->withNotify($notify);
    }

    // Mobile number check
    $exist = User::where('mobile', $request->mobile_code.$request->mobile)->first();
    if ($exist) {
        if ($request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'The mobile number already exists'], 422);
        }
        $notify[] = ['error', 'The mobile number already exists'];
        return back()->withNotify($notify)->withInput();
    }

    event(new Registered($user = $this->create($request->all())));

    $this->guard()->login($user);

    return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
}

protected function create(array $data)
{
    $general = gs();

    $referBy = session()->get('reference');
    $referUser = $referBy ? User::where('username', $referBy)->first() : null;

    //User Create
    $user = new User();
    $user->email = strtolower(trim($data['email']));
    $user->firstname = trim($data['firstname']);
    $user->lastname = trim($data['lastname']);
    $user->password = Hash::make($data['password']);
    $user->username = trim($data['username']);
    $user->ref_by = $referUser ? $referUser->id : 0;
    $user->country_code = $data['country_code'];
    $user->mobile = $data['mobile_code'].$data['mobile'];
    
    $user->address = [
        'address' => $data['address'] ?? '',
        'state' => $data['state'] ?? '',
        'zip' => $data['zip'] ?? '',
        'country' => $data['country'] ?? null,
        'city' => $data['city'] ?? ''
    ];
    
    $user->kv = $general->kv ? Status::NO : Status::YES;
    $user->ev = $general->ev ? Status::NO : Status::YES;
    $user->sv = $general->sv ? Status::NO : Status::YES;
    $user->ts = 0;
    $user->tv = 1;
    $user->profile_complete = 1;
    $user->save();

    $adminNotification = new AdminNotification();
    $adminNotification->user_id = $user->id;
    $adminNotification->title = 'New member registered';
    $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
    $adminNotification->save();

    // Login Log
    $ip = getRealIP();
    $exist = UserLogin::where('user_ip', $ip)->first();
    $userLogin = new UserLogin();

    if ($exist) {
        $userLogin->longitude = $exist->longitude;
        $userLogin->latitude = $exist->latitude;
        $userLogin->city = $exist->city;
        $userLogin->country_code = $exist->country_code;
        $userLogin->country = $exist->country;
    } else {
        $info = json_decode(json_encode(getIpInfo()), true);
        $userLogin->longitude = @implode(',', $info['long']);
        $userLogin->latitude = @implode(',', $info['lat']);
        $userLogin->city = @implode(',', $info['city']);
        $userLogin->country_code = @implode(',', $info['code']);
        $userLogin->country = @implode(',', $info['country']);
    }

    $userAgent = osBrowser();
    $userLogin->user_id = $user->id;
    $userLogin->user_ip = $ip;
    $userLogin->browser = @$userAgent['browser'];
    $userLogin->os = @$userAgent['os_platform'];
    $userLogin->save();

    return $user;
}

    public function checkUser(Request $request){
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email',$request->email)->exists();
            $exist['type'] = 'email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile',$request->mobile)->exists();
            $exist['type'] = 'mobile';
        }
        if ($request->username) {
            $exist['data'] = User::where('username',$request->username)->exists();
            $exist['type'] = 'username';
        }
        return response($exist);
    }

    public function registered()
    {
        return to_route('user.home');
    }

}
