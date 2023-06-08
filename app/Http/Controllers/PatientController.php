<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientCreateRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    function index(Request $request){
        $items = (new Patient())->getAllItems();
        return PatientResource::collection($items);
    }

    function create(PatientCreateRequest $request){
        $params = $request->all();
        $model = new Patient();
        $model->createOrUpdateItem($params,null);
        $items = (new Patient())->getAllItems();
        return PatientResource::collection($items);
    }

    function update(PatientCreateRequest $request,$id){
        $params = $request->all();
        $model = $this->findById($id);
        $model->createOrUpdateItem($params,$id);
        $items = (new Patient())->getAllItems();
        return PatientResource::collection($items);
    }

    function delete(Request $request,$id){
        $model = $this->findById($id);
        if($model)
            $model->delete();
        $items = (new Patient())->getAllItems();
        return PatientResource::collection($items);
    }

    function search(Request $request){
        $name = $request->get('name');
        $items = (new Patient())->search($name);
        return PatientResource::collection($items);
    }

    function findById($id){
        return Patient::find($id);
    }
}
