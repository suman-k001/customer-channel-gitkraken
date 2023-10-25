<?php namespace VaahCms\Modules\CustomerChannel\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use VaahCms\Modules\CustomerChannel\Models\Product;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\Taxonomy;
use VaahCms\Modules\CustomerChannel\Models\User;

class UsersController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        /*if (!Auth::user()->hasPermission('has-access-of-users-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        } */

        try {
            $data = [];

            $data['permission'] = [];
            $data['rows'] = config('vaahcms.per_page');

            $data['fillable']['except'] = [
                'uuid',
                'created_by',
                'updated_by',
                'deleted_by',
            ];

            $model = new User();
            $fillable = $model->getFillable();
            $data['fillable']['columns'] = array_diff(
                $fillable, $data['fillable']['except']
            );

            foreach ($fillable as $column) {
                $data['empty_item'][$column] = null;
            }

            $custom_fields = Setting::query()->where('category', 'user_setting')
                ->where('label', 'custom_fields')->first();

            $data['empty_item']['meta']['custom_fields'] = [];

            if (isset($custom_fields)) {
                foreach ($custom_fields['value'] as $custom_field) {
                    $data['empty_item']['meta']['custom_fields'][$custom_field->slug] = null;
                }
            }

            $data['actions'] = [];
            $data['name_titles'] = vh_name_titles();
            $data['countries'] = vh_get_country_list();
            $data['timezones'] = vh_get_timezones();
            $data['custom_fields'] = $custom_fields;
            $data['fields'] = User::getUserSettings();
            $data['country_code'] = vh_get_country_list();
            $data['registration_statuses'] = Taxonomy::getTaxonomyByType('registrations');
            $data['upload_url'] = route('vh.backend.media.upload');
            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {

        try {
            $response = User::getList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return response()->json($response);
    }

    //----------------------------------------------------------
    public function updateList(Request $request): JsonResponse
    {

        try {
            $response = User::updateList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function listAction(Request $request, $type): JsonResponse
    {

        try {
            $response = User::listAction($request, $type);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function deleteList(Request $request): JsonResponse
    {
        try {
            $response = User::deleteList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function createItem(Request $request): JsonResponse
    {

        try {
            $response = User::createItem($request);
            Product::syncProductsWithUsers();
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItem(Request $request, $id): JsonResponse
    {

        try {
            $response = User::getItem($id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function updateItem(Request $request, $id): JsonResponse
    {

        try {
            $item = User::query()->where('id', $id)->first();

            if (!$item) {
                $response['success'] = false;
                $response['errors'] = 'Registration not found.';
                return response()->json($response);
            }

            $request['id'] = $item->id;
            $response = User::updateItem($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function deleteItem(Request $request, $id): JsonResponse
    {

        try {
            $response = User::deleteItem($request, $id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function itemAction(Request $request, $id, $action): JsonResponse
    {

        try {
            $response = User::itemAction($request, $id, $action);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //---------------------------------------------------------
    public function getItemProducts(Request $request, $id): JsonResponse
    {

        try {
            $item = User::withTrashed()->where('id', $id)->first();

            $response['data']['item'] = $item;

            if ($request->has("q")) {
                $matchingUserIds = $item->users()
                    ->where(function ($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%' . $request->q . '%')
                            ->orWhere('middle_name', 'LIKE', '%' . $request->q . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $request->q . '%')
                            ->orWhere('display_name', 'LIKE', '%' . $request->q . '%')
                            ->orWhere('email', 'LIKE', '%' . $request->q . '%');
                    })
                    ->pluck('id')
                    ->toArray();
            } else {
                $matchingUserIds = $item->users()
                    ->pluck('id')
                    ->toArray();
            }

            $rows = config('vaahcms.per_page');

            if ($request->rows) {
                $rows = $request->rows;
            }

            $list = $item->users()
                ->whereIn('id', $matchingUserIds)
                ->orderBy('pivot_is_active', 'desc')
                ->paginate($rows);

            foreach ($list as $user) {
                $data = User::getPivotData($user->pivot);

                $user['json'] = $data;
                $user['json_length'] = count($data);
            }

            $response['data']['list'] = $list;
            $response['data']['matchingUserIds'] = $matchingUserIds;
            $response['success'] = true;

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }

    //----------------------------------------------------------
    public function postActions(Request $request, $action): JsonResponse
    {
        try {
            $rules = array(
                'inputs' => 'required',
            );

            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {

                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = [];

            $request->merge(['action' => $action]);

            switch ($action) {
                //------------------------------------
                case 'bulk-change-status':


                    $response = User::bulkStatusChange($request);

                    break;
                //------------------------------------
                case 'bulk-trash':


                    $response = User::bulkTrash($request);

                    break;
                //------------------------------------
                case 'bulk-restore':


                    $response = User::bulkRestore($request);

                    break;
                //------------------------------------
                case 'bulk-delete':

                    $response = User::bulkDelete($request);

                    break;
                //------------------------------------
                case 'toggle-product-active-status':

                    $response = User::changeProductStatus($request);

                    break;
                //------------------------------------
                case 'toggle-all-product-active-status':

                    $response = User::bulkChangeProductStatus($request);

                    break;
                //------------------------------------
            }
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getProfile(Request $request): JsonResponse
    {
        try {
            $data['profile'] = User::query()->find(Auth::user()->id);
            $data['mfa_methods'] = config('settings.global.mfa_methods');
            $data['mfa_status'] = config('settings.global.mfa_status');

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function storeAvatar(Request $request): JsonResponse
    {

        try {
            $rules = array(
                'user_id' => 'required',
            );

            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {

                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = User::storeAvatar($request, $request->user_id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function removeAvatar(Request $request)
    {

        try {
            $rules = array(
                'user_id' => 'required',
            );

            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = User::removeAvatar($request->user_id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['messages'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function storeProfile(Request $request): JsonResponse
    {
        try {
            $response = User::storeProfile($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function storeProfilePassword(Request $request): JsonResponse
    {
        try {
            $response = User::storePassword($request);

            if ($response['success'] === true) {
                Auth::logout();

                $response['data']['redirect_url'] = route('vh.backend');
            }
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function storeProfileAvatar(Request $request): JsonResponse
    {
        try {
            $response = User::storeAvatar($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function removeProfileAvatar(Request $request): JsonResponse
    {
        try {
            $response = User::removeAvatar();
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------

}
