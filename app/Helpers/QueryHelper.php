<?php

namespace App\Helpers;

use App\Models\Store;

use App\Models\Category;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\Slider;
use App\Models\StatusList;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Variant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use function Symfony\Component\HttpKernel\Log\record;

class QueryHelper
{
    public static function fetchAllStores($columns = '*'){

        $query = Store::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }


    public static function fetchCategoriesHasProduct( $limit = 0 ){
        $sortColumn = request('sort', 'id');
        $sortDirection = request('order', 'desc');

        $query = Category::query();
        $query->whereHas('products')->withCount('products');
        $query->orderBy($sortColumn, $sortDirection);
        if($limit != 0){
            $query->take($limit);
        }
        return $query->get();
    }

    public static function fetchBrandsHasProduct( $limit = 0 ){
        $sortColumn = request('sort', 'id');
        $sortDirection = request('order', 'desc');

        $query = Brand::query();
        $query->whereHas('products')->withCount('products');
        $query->orderBy($sortColumn, $sortDirection);
        if($limit != 0){
            $query->take($limit);
        }
        return $query->get();
    }





    public static function fetchCountry($country_id){

        $query = Country::query();
        $query->where('id', $country_id);
        return $query->first();
    }


    public static function fetchAllStatusList($columns = '*'){

        $query = StatusList::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }

    public static function fetchAllCategories($columns = '*'){

        $query = Category::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }

    public static function fetchCategories(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Category::with(['parent']);

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('subtitle', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'categories' => $results ];
    }

    public static function fetchAllBrands($columns = '*'){
        $query = Brand::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }

    public static function fetchBrands(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Brand::query();

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'brands' => $results ];
    }

    public static function fetchAllSliders($columns = '*'){
        $query = Slider::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }

    public static function fetchSliders(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Slider::query();

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('subtitle', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'sliders' => $results ];
    }

    public static function fetchAllSizes($columns = '*'){
        $query = Size::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }

    public static function fetchSizes(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Size::query();

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'sizes' => $results ];
    }

    public static function fetchAllColors($columns = '*'){
        $query = Color::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }

    public static function fetchColors(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Color::query();

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'colors' => $results ];
    }

    public static function fetchAllProducts($columns = '*'){
        $query = Product::query();
        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }
        return $query->get();
    }
    /* 'mysql' => [
           'strict' => false,
        ]*/
    public static function fetchProducts_old(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Product::with([
            'category:id,name,image,status',
            'brand:id,name,image,status',
            'country:id,name',
            'variants',
            'variants.images'
        ]);

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')

                    ->orWhere('tags', 'like', '%'.$search.'%')
                    ->orWhere('short_description', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')

                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'products' => $results ];
    }

    public static function fetchProducts(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $columns = ['*'];

        $query = Product::withCount(['variants'])->with([
            'category:id,name,image,status',
            'brand:id,name,image,status',
            'country:id,name',
            'variants',
            'variants.color',
            'variants.size',
            'variants.images'
        ]);

        if(is_array($columns)){
            array_push($columns,
                DB::raw("(select id from variants where variants.product_id = products.id limit 1) as variant_id"),
                DB::raw("(select MIN(price) from variants where variants.product_id = products.id) as price"),
                DB::raw("(select MIN(discounted_price) from variants where variants.product_id = products.id) as discounted_price")
            );
            $query->select($columns);
        }else{
            $columns .= ",
            (select id from variants where variants.product_id = products.id limit 1) as variant_id,
            (select MIN(price) from variants where variants.product_id = products.id) as price,
            (select MIN(discounted_price) from variants where variants.product_id = products.id) as discounted_price";
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('tags', 'like', '%'.$search.'%')
                    ->orWhere('short_description', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        /*$sql = Variant::select('*')
            ->leftJoin('products', 'products.id' , '=', 'variants.product_id')
            ->groupBy('variants.product_id');
        $data = $sql->skip($offset)->take($limit)->get();
        dd($results->toArray(), $data->toArray());*/

        return ['total' => $total, 'products' => $results ];
    }

    // #[ArrayShape(['total' => "mixed", 'orders' => "mixed"])]

    public static function fetchOrders(Request $request, $columns = '*' )
    {
        $limit = request('limit', 10);
        $offset = request('offset',0);

        $columns = ['*'];

        $query = Order::withCount(['items'])->with([
            'user',
            'items',
            'current_status'
        ]);

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('current_status_id', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('mobile', 'like', '%'.$search.'%')
                    ->orWhere('order_note', 'like', '%'.$search.'%')
                    ->orWhere('address', 'like', '%'.$search.'%')
                    ->orWhere('payment_mode', 'like', '%'.$search.'%')
                    ->orWhere('payment_method', 'like', '%'.$search.'%')
                    ->orWhere('payment_status', 'like', '%'.$search.'%')
                    ->orWhere('total', 'like', '%'.$search.'%')
                    ->orWhere('delivery_charge', 'like', '%'.$search.'%')
                    ->orWhere('final_total', 'like', '%'.$search.'%')
                    ->orWhere('otp', 'like', '%'.$search.'%')
                    ->orWhere('current_status_id', 'like', '%'.$search.'%')
                    ->orWhere('custom_order_id', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'orders' => $results ];
    }



    public static function fetchFaqs(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Faq::query();

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('question', 'like', '%'.$search.'%')
                    ->orWhere('answer', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'faqs' => $results ];
    }

    public static function fetchSubscribers(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = Subscriber::query();

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('email', 'like', '%'.$search.'%')
                    ->orWhere('mobile', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'subscribers' => $results ];
    }

    public static function fetchCustomers(Request $request, $columns = '*' ){

        $limit = request('limit', 10);
        $offset = request('offset',0);

        $query = User::where('role_id', 0);

        if(is_array($columns)){
            $query->select($columns);
        }else{
            $query->selectRaw($columns);
        }

        if(isset($request->status) && $request->status != ""){
            $query->where('status', request('status'));
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search', null);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('mobile', 'like', '%'.$search.'%')
                    ->orWhere('referral_code', 'like', '%'.$search.'%')
                    ->orWhere('friends_code', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortColumn = request('sort', 'id');
            $sortDirection = request('order', 'desc');
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Get the total count for pagination
        $total = $query->count();

        if ($limit <= 0) {
            $limit = $total;
        }

        if (!$request->has('limit')) {
            $limit = $total;
        }

        $results = $query->skip($offset)->take($limit)->get();

        return ['total' => $total, 'customers' => $results ];
    }








}
?>
