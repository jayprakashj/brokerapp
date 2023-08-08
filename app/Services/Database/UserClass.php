<?php

namespace App\Services\Database;

use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\UserRegisterMail;
use App\Models\Company;
use App\Models\CompanyMember;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserClass {

    private $companyClass;
    private $memberClass;

    public function __construct( )
    {
        $this->companyClass = new CompanyClass();
        $this->memberClass = new MemberClass();
    }

    public function register ( $request ) {

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->password = $request->input('password');
        $user->status = User::$STATUS_ACTIVE;
        $user->type = $request->input('type');
        $user->save();

        $user->setDefaultRole();

        $companyReqData = [
            'status' => Company::$STATUS_ACTIVE
        ];
        if( !$user->isTypeCompany() ){
            $companyReqData['company_name'] = $user->name;

        }
        $request->merge( $companyReqData );

        $company = $this->companyClass->update( $user, (new Company), $request, true );

        $companyMember = $this->memberClass->createWithUserRegistration( $company, $user, CompanyMember::FLAG_IS_DEFAULT_YES, CompanyMember::INVITE_STATUS_ACCEPT  );

        $user->setRelation('ownedCompany', $company );

        setPermissionsTeamId( $companyMember->company_id );
        $user->assignRole( $companyMember->role_id );

        // Mail::to( $user->email )->send( new UserRegisterMail( $user ) );

        return $user;
    }

    public function findUserByEmail ( $email = null ){
        if( !is_null( $email ) ){
            return User::where('email', $email)->first();
        }
        return null;
    }

    public function findUserByMobile ( $mobile = null ){
        if( !is_null( $mobile ) ){
            return User::where('mobile', $mobile)->first();
        }
        return null;
    }

    public function findUserByEmailMobile ( $str = null ){
        if( !empty( $str ) ){
            if( filter_var( $str, FILTER_VALIDATE_EMAIL ) ){
                return $this->findUserByEmail( $str );
            }else{

                return $this->findUserByMobile( $str );
            }
        }
        return null;
    }

    public function setEmailVerify ( User $user ){
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    public function sendResetPasswordLink ( User $user ){
        $status = Password::sendResetLink(['email'=>$user->email]);

        return $status === Password::RESET_LINK_SENT;
    }

    public function resetPassword ( $request ){
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET;
    }

}
