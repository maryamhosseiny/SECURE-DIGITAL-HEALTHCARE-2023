<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Patient extends Model
{
    use HasFactory;

    function createOrUpdateItem($params,$id=null){
        //prevent xss
        $params = array_map('strip_tags', $params);
        if($id)
        {
            $model = self::find($id);
            if(!$model)
                return false;
        }
        else
        {
            $model = new Patient();
        }
        $model->first_name = $params['first_name'];
        $model->last_name = $params['last_name'];
        $model->email = $params['email'];
        $model->phone = $params['phone'];
        $model->address = $params['address'];
        $model->gender = $params['gender'];
        $model->password = Hash::make($params['password']);
        $model->birthdate = $params['birthdate'];
        $model->save();
        return $model;
    }

    function getAllItems(){
        return self::query()->get();
    }

    function search($name){
        return self::query()
            ->where('first_name','like','%'.$name.'%')
            ->orWhere('last_name','like','%'.$name.'%')
            ->get();
    }
}
