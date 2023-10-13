<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\Mail\UserForgetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
    //for reset 
    public function forgetPassword(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->email;
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $generatedToken = User::generatePasswordToken();

            //check if the account activeted
            // if($user->status != 1){
            //     return $this->showMessage('Your account not activated yet, please check your emailbox.', 422);
            // }
           DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->delete();
            $token = DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $generatedToken,
                'created_at' => Carbon::now()
            ]);
            if($token){
                    $userMessage = new UserForgetPasswordMail($user,$generatedToken);
                    Mail::to($email)->send($userMessage);

                    return response()->json(['message' => 'password reset email sent'],200);

                    
            }
            return response()->json(['message' => 'Something Error', 'code'=>422]);

        } else {
            return response()->json(['message' => 'Something Error', 'code'=>422]);

        }
    }
    public function resetPassword(ResetPasswordRequest $request){
      $data = $request->only('email','verify_token','password');
      
      $email = $data['email'];
      $token = $data['verify_token'];
      $password = Hash::make($data['password']);
      $user = User::where('email', $request->email)->firstOrFail();
      $password_request = DB::table('password_reset_tokens')
                            ->select('email', 'token','created_at')
                            ->where('email',$email)
                            ->where('token',$token)
                            ->limit(1)
                            ->get();
      if ($user && sizeof($password_request) > 0) {
              $user->password = $password;
              if($user->save()){
                  DB::table('password_reset_tokens')
                  ->where('email', '=', $user->email)
                  ->delete();//old rowin pssword reset
                return  response()->json(['message' => 'password reset success', 'code'=>200]);

              }
      } else {
              return response()->json(['message' => 'Something Error', 'code'=>422]);

      }
    }

    public function changePassword(Request $request){
        $request->validate( [
            'old_password' => 'required',
            'password' => 'required|confirmed|different:old_password',       
        ]);
        $user = Auth::user();
        if(Hash::check($request->old_password, $user->password)){
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['message' =>'Password Has Changed'],200);
        }
        else {
               return  response()->json([ 'Wrong Passoword',401]);
        }
       
    }

    
}
