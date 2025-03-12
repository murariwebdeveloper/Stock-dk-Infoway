<?php

namespace App\Http\Controllers\API;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    /**
     * @var array
     */
    private $responses;
    /**
     * @var Store
     */
    private $store;

    public function __construct(Store $store){
        $this->responses = [];
        $this->store = $store;
    }

    public function index(Request $request){
        $stores = $this->store->get();
        $message = 'Get all store successfully!';
        return CommonHelper::responseSuccessWithData($stores, $message);
    }

    public function list(Request $request){

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $sortColumn = $request->input('sortField', 'id');
        $sortDirection = $request->input('sortOrder', 'desc');

        $query = $this->store->orderBy($sortColumn, $sortDirection);

        $stores = $query->paginate($size, ['*'], 'page', $page);

        return response()->json([
            "last_page" => $stores->lastPage(), // Total pages
            "data" => $stores->items(), // Paginated data
        ]);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:stores,name',
        ]);
        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first(), 200);
        }
        $record = $this->store;
        $record->name = $request->name;

        if($record->save()){
            $message = 'Store saved successfully!';
            return CommonHelper::response($this->responses, SUCCESS, $message);
        }
        $this->responses['message'] = "Store unsaved";
        return CommonHelper::response($this->responses, ERROR);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:stores,name,'.$request->id,
        ]);
        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first(), 200);
        }
        $id = $request->id;

        $record = $this->store->find($id);
        $record->name = $request->name;

        if($record->save()){
            $message = 'Store updated successfully!';
            return CommonHelper::response($this->responses, SUCCESS, $message);
        }
        $this->responses['message'] = "Store unsaved";
        return CommonHelper::response($this->responses, ERROR);
    }

    public function delete(Request $request){
        $record = $this->store->find($request->id);

        if (!$record) {
            return CommonHelper::responseError("Store record not found!");
        }
        if ($record->delete()) {
            return CommonHelper::responseSuccess("Store deleted successfully!");
        }
        return CommonHelper::responseError("Failed to delete the Store!");
    }

}
