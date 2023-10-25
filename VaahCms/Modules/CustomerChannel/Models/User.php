<?php namespace VaahCms\Modules\CustomerChannel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\User as UserBase;

class User extends UserBase
{
    public array $matchingProductIds = [];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class, 'vh_user_products',
            'user_id', 'product_id')
            ->withPivot('is_active',
                'created_by',
                'created_at',
                'updated_by',
                'updated_at');
    }

    public function activeProducts(): BelongsToMany
    {
        return $this->products()->wherePivot('is_active', 1);
    }

    public static function getList($request, $excluded_columns = []): array
    {
        if (isset($request['recount']) && $request['recount'] == true) {
            Product::syncProductsWithUsers();
        }

        $list = self::getSorted($request->filter);
        $list->isActiveFilter($request->filter);
        $list->trashedFilter($request->filter);
        $list->searchFilter($request->filter);

        if (isset($request['from']) && isset($request['to'])) {
            $list->betweenDates($request['from'], $request['to']);
        }

        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }

        $list->withCount(['activeProducts']);

        $list = $list->paginate($rows);
        $countProduct = Product::all()->count();

        $response['success'] = true;
        $response['totalProduct'] = $countProduct;
        $response['data'] = $list;

        return $response;
    }

    public static function changeProductStatus($request): array
    {

        $inputs = $request->all();

        $role = Product::find($inputs['inputs']['product_id']);

        if ($inputs['inputs']['id'] == 1 && $role->slug == 'richest'
            && $inputs['data']['is_active'] == 0) {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.first_user_super_administrator');
            return $response;
        }

        $item = self::find($inputs['inputs']['id']);


        $data = [
            'is_active' => $inputs['data']['is_active'],
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ];


        if ($inputs['inputs']['product_id']) {
            $pivot = $item->products->find($inputs['inputs']['product_id'])->pivot;

            if ($pivot->is_active === null || !$pivot->created_by) {
                $data['created_by'] = Auth::user()->id;
                $data['created_at'] = Carbon::now();
            }

            $item->products()->updateExistingPivot(
                $inputs['inputs']['product_id'],
                $data
            );
        } else {
            $item->products()
                ->newPivotStatement()
                ->where('user_id', '=', $item->id)
                ->update($data);
        }
        $response['success'] = true;
        $response['data'] = [];

        return $response;


    }

    //------------------Bulk change----

    public static function bulkChangeProductStatus($request): array
    {

        $inputs = $request->get('inputs');
        $data = $request->get('data');
        $response = ['success' => true, 'data' => []];

        if (isset($inputs['id'])) {
            $item = self::find($inputs['id']);
            $productIds = $inputs['product_id'];

            foreach ($productIds as $productId) {
                $pivot = $item->products->find($productId)->pivot;
                $updateData = [
                    'is_active' => $data['is_active'],
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now(),
                ];

                if ($pivot->is_active === null || !$pivot->created_by) {
                    $updateData['created_by'] = Auth::user()->id;
                    $updateData['created_at'] = Carbon::now();
                }

                $item->products()->updateExistingPivot($productId, $updateData);
            }
        }

        return $response;

    }


}
