<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Services\Database\UserClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $userClass;

    //
    public function __construct( UserClass $userClass )
    {
        $this->userClass = $userClass;
    }

    public function viewLogin () {
        return view('auth.login');
    }

    public function viewRegister () {
        $types = User::TYPE_LIST;
        return view('auth.register', compact('types') );
    }

    public function login ( LoginRequest $request ) {
        $user = $this->userClass->findUserByEmailMobile( $request->input('email') );
        if( !is_null( $user ) ){

            if( Hash::check( $request->input('password' ), $user->getAuthPassword() ) ){
                if( $user->isActive() ){
                    if( $user->isEmailVerified() ){
                        auth()->login( $user );
                        \Helper::setDefaultCompanySessionTeam();
                        return redirect()->to('/dashboard');
                    }else{
                        return redirect()->back()
                                        ->withInput()
                                        ->with('error-message', 'Email verification pending.')
                                        ->with('resend-verify', route('verify', ['email' => $user->email]) );
                    }
                }else{
                    return redirect()->back()->withInput()->with('error-message', 'User is in-active.');

                }
            }else{
                return redirect()->back()->withInput()->with('error-message', 'Invalid credentials!');

            }
        }else{
            return redirect()->back()->withInput()->with('error-message', 'No user exists.');
        }
    }

    public function register ( UserRegistrationRequest $request ) {

        DB::beginTransaction();
        try{
            $this->userClass->register( $request );
            DB::commit();
            return redirect()->back()->with('success-message', 'Success! You have successfully registered. Please verify email and login.' );
        }catch( Exception $e ){
            DB::rollBack();
            return redirect()->back()->with('error-message', $e->getMessage() );
        }
    }

    public function verifyEmail ( Request $request ) {
        $email = $request->input('email');
        $user = $this->userClass->findUserByEmail( $email );
        if( !is_null( $user ) && is_null( $user->email_verified_at) ){
            $this->userClass->setEmailVerify( $user );

            return redirect()->route('login')->with('success-message', 'Success! Email verified successfully.');
        }
        return redirect()->route('login')->with('error-message', 'Error! Invalid request.');
    }


    public function viewForgotPassword () {
        return view('auth.forgot-password' );
    }

    public function sendResetPasswordLink ( ForgotPasswordRequest $request ) {
        $user = $this->userClass->findUserByEmail( $request->input('email') );
        if( !is_null( $user ) ){
            if( $user->isActive() ){
                if( $user->isEmailVerified() ){
                    if( $this->userClass->sendResetPasswordLink( $user ) ){

                        return redirect()->back()
                                        ->with('success-message', 'Reset password link has ben sent on your mail. Please check your mailbox.');
                    }else{
                        return redirect()->back()
                                        ->with('error-message', 'Something went wrong. Ple try again.');

                    }

                }else{
                    return redirect()->back()
                                    ->withInput()
                                    ->with('error-message', 'Email verification pending.')
                                    ->with('resend-verify', route('verify', ['email' => $user->email]) );
                }
            }else{
                return redirect()->back()->withInput()->with('error-message', 'User is in-active.');

            }
        }else{
            return redirect()->back()->withInput()->with('error-message', 'Given email address is not exists.');

        }
    }


    public function viewResetPassword ( $token ) {
        return view('auth.reset-password', compact('token') );
    }

    public function resetPassword ( ResetPasswordRequest $request ) {
        if( $this->userClass->resetPassword( $request ) ){

            return redirect()->route('login')->with('success-message', 'Your password reset successfully.');
        }else{

            return redirect()->back()->withInput()->with('error-message', 'Token is expired or may email is incorrect.');
        }
    }

    public function logout ( Request $request ) {
        $request->session()->flush();
        session()->flush();
        auth()->logout();
        return redirect()->route('login');
    }

    public function updateProfile ( ProfileUpdateRequest $request ){
        $response = [];
        $code = 500;
        try{

            $user = $this->userClass->updateProfile( auth()->user(), $request );
            $response = [
                'message' => 'Success! Profile updated successfully.',
                'data' => $user->getDataForVueApp()
            ];
            $code = 200;
        }catch( Exception $e ){
            $response = [
                'message' => $e->getMessage()
            ];

        }

        return response()->json( $response, $code );
    }

    public function updatePassword ( UpdatePasswordRequest $request ){
        $response = [];
        $code = 500;
        try{
            $user = auth()->user();
            if( Hash::check( $request->input('password' ), $user->getAuthPassword() ) ){

                $user = $this->userClass->updatePassword( $user, $request );

                $response = [
                    'message' => 'Success! Password has been changed successfully.',
                    'data' => $user->getDataForVueApp()
                ];
                $code = 200;

            }else{
                $response = [
                    'message' => 'Error! Current password is invalid.'
                ];

            }
        }catch( Exception $e ){
            $response = [
                'message' => $e->getMessage()
            ];

        }

        return response()->json( $response, $code );
    }
}
