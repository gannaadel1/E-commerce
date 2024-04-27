<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\traits\GeneralTrait;
use App\Models\Models\category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use GeneralTrait;
    public function index(){
    //     $categories=category::select('id','name_'.app()->getLocale().'as name')->get();
    $categories=category::selection()->get();
        return response()->json($categories);
    }

    public function getCategory(Request $request){
       
        $category=category::find($request->id);
        if(!$category){
            return $this->ReturnError('wrong data');
        }
            return $this->ReturnData('category',$category,'done');
        }

        public function changeStatus(Request $request){
           
           category::where('id',$request->id)->update(['status'=>$request->status]);
           return $this->ReturnSuccess('updated successfully');
            }
}
