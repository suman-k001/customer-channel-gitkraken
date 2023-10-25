<?php namespace VaahCms\Themes\CustomerTheme\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use VaahCms\Themes\CustomerTheme\Notifications\ActivationLinkNotification;
use WebReinvent\VaahCms\Entities\Registration;
use WebReinvent\VaahCms\Entities\User;

class CustomerThemeRegistration extends Registration
{

	//---------------------------------------------
    public static function postCreate($request)
    {

        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }


        $user = User::where('email', $request->email)->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Email already registered';
            return $response;
        }

        $item = self::where('email', $request->email)->first();

        if(!$item)
        {
            $item = new self();
        }
        if($item->status == null){
            $item->status = 'email-verification-pending';
        }

        $item->fill($request->all());
        $item->activation_code = Str::uuid()->toString();
        $item->activation_code_sent_at = \Carbon::now();
        $item->save();

        try{
            $item->notify(new ActivationLinkNotification($item));
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Make sure environment variables for MAIL are set and correct in the active .env file';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

        $response['status'] = 'success';
        $response['data'][] = '';
        $response['messages'][] = 'An activation email has been sent.';

        return $response;

    }

	//---------------------------------------------
	public static function activateRegistration($request)
    {

        $signup = self::where('activation_code', $request->activation_code)
            ->first();

        if(!$signup)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Invalid activation code';
            return $response;
        }

        $signup = $signup->makeVisible(['password']);

        $user_request = new Request($signup->toArray());
            $user_request['status'] =  'active';
        // Create User
        $user = CustomerThemeUser::createUser($user_request);

        if($user)
        {
            $signup->vh_user_id = $user->id;
            $signup->status='email-verified';
            $signup->activation_code=null;
            $signup->save();
        }

        $response['status'] = 'success';
        $response['data']['redirect_url'] = route('vh.frontend.customertheme.signin');
        $response['messages'][] = 'Account successfully activated';

        return $response;
    }
	//---------------------------------------------
	//---------------------------------------------
	//---------------------------------------------

}
