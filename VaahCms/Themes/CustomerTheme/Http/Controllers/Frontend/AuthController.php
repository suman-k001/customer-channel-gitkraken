<?php namespace VaahCms\Themes\CustomerTheme\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Themes\CustomerTheme\Models\CustomerThemeUser;
use VaahCms\Themes\CustomerTheme\Models\CustomerThemeRegistration;


class AuthController extends Controller
{

    //----------------------------------------------------------
    public function login(): \Illuminate\Http\RedirectResponse
    {
      return redirect()->route('vh.frontend.customertheme.signin');
    }
    //----------------------------------------------------------
    public function signOutUser()
    {
      \Auth::logout();
    }
    //----------------------------------------------------------
    public function signout(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $this->signOutUser();
        return redirect('/');
    }
    //----------------------------------------------------------
    public function signin(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
      $this->signOutUser();
      return view('customertheme::frontend.auth.signin');
    }
    //----------------------------------------------------------
    public function signinPost(Request $request): JsonResponse
    {

        if($request->type == 'password')
        {
            $response = CustomerThemeUser::login($request);
        } else if($request->type == 'otp')
        {
            if(is_array($request->login_otp))
            {
                $inputs = [
                    'login_otp' => implode("", $request->login_otp)
                ];

                $request->merge($inputs);
            }
            $response = CustomerThemeUser::loginViaOtp($request);
        }

        if((isset($response['status']) && $response['status'] == 'success')
          || (isset($response['success']) && $response['success'] == true))
        {
            $response['data']['redirect_url'] = url("/home");
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function sendOtp(Request $request): JsonResponse
    {
        $response = CustomerThemeUser::sendLoginOtp($request);

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function sendResetCode(Request $request): JsonResponse
    {
        $response = CustomerThemeUser::sendResetPasswordEmail($request);

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function passwordResetAndSignin(Request $request): JsonResponse
    {
        $response = CustomerThemeUser::passwordResetAndSignin($request);

        if($response['status'] == 'success')
        {
            $response['data']['redirect_url'] = url('/');
        }
        return response()->json($response);

    }
    //----------------------------------------------------------
    public function signup(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $this->signOutUser();
        return view('customertheme::frontend.auth.signup');
    }

    //---------------------------------------------------------
    public function signupPost(Request $request): JsonResponse
    {
        $response = CustomerThemeRegistration::postCreate($request);
        return response()->json($response);
    }
    //---------------------------------------------------------
    public function activate(Request $request, $code): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $this->signOutUser();
        return view('customertheme::frontend.auth.activate')
            ->with([ 'activation_code'=> $code ]);
    }
    //----------------------------------------------------------
    public function activatePost(Request $request, $code): JsonResponse
    {
        $request->merge(['activation_code' => $code]);
        $response = CustomerThemeRegistration::activateRegistration($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
