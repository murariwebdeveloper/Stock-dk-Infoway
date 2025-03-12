<?php

namespace App\Http\Controllers\API;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\StockEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockEntryController extends Controller
{
    /**
     * @var array
     */
    private $responses;
    /**
     * @var StockEntry
     */
    private $entry;

    public function __construct(StockEntry $entry){
        $this->responses = [];
        $this->entry = $entry;
    }

    public function index(Request $request){

    }

    public function list(Request $request){

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $sortColumn = $request->input('sortField', 'id');
        $sortDirection = $request->input('sortOrder', 'desc');

        /*$sortColumn = $request->input('sort[0][field]', 'id');
        $sortDirection = $request->input('sort[0][dir]', 'desc');*/

        $query = $this->entry->orderBy($sortColumn, $sortDirection);

        $entries = $query->paginate($size, ['*'], 'page', $page);

        return response()->json([
            "last_page" => $entries->lastPage(), // Total pages
            "data" => $entries->items(), // Paginated data
        ]);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(),[
            'store_id' => 'required',
            'item_code' => 'required',
            'item_name' => 'required',
            'quantity' => 'required',
            'location' => 'required',
        ]);
        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first(), 200);
        }

        $stock_no =  intval($this->entry->max('id') ?? 0 ) + 1000001;
        $record = $this->entry;
        $record->stock_no = $stock_no;
        $record->store_id = $request->store_id;
        $record->item_code = $request->item_code;
        $record->item_name = $request->item_name;
        $record->quantity = $request->quantity;
        $record->location = $request->location;

        $record->in_stock_date = date('y-m-d');

        if(isset($request->status) && $request->status != ""){
            $record->status = $request->status;
        }

        if($record->save()){
            $message = 'Stock Entry saved successfully!';
            return CommonHelper::response($this->responses, SUCCESS, $message);
        }
        $this->responses['message'] = "Stock Entry unsaved";
        return CommonHelper::response($this->responses, ERROR);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'store_id' => 'required',
            'item_code' => 'required',
            'item_name' => 'required',
            'quantity' => 'required',
            'location' => 'required',
        ]);
        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first(), 200);
        }
        $id = $request->id;

        $record = $this->entry->find($id);

        $record->store_id = $request->store_id;
        $record->item_code = $request->item_code;
        $record->item_name = $request->item_name;
        $record->quantity = $request->quantity;
        $record->location = $request->location;

        if(isset($request->status) && $request->status != ""){
            $record->status = $request->status;
        }

        if($record->save()){
            $message = 'Stock Entry updated successfully!';
            return CommonHelper::response($this->responses, SUCCESS, $message);
        }
        $this->responses['message'] = "Stock unsaved";
        return CommonHelper::response($this->responses, ERROR);
    }

    public function delete(Request $request){
        $record = $this->entry->find($request->id);

        if (!$record) {
            return CommonHelper::responseError("Stock Entry record not found!");
        }
        if ($record->delete()) {
            return CommonHelper::responseSuccess("Stock Entry deleted successfully!");
        }
        return CommonHelper::responseError("Failed to delete the Stock Entry!");
    }


}
