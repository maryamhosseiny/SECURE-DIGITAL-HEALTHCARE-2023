<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Files extends Model
{
    use HasFactory;

    function upload($file,$model_class,$model_id){
        $savePath = 'public/images/'.$model_id;
        $filenameWithExt = $file->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = $filename.'_'.rand(999,99999).time().'.'.$extension;
        $fileNameToStore = $filename;
        $path = $file->storeAs($savePath,$fileNameToStore);
        $model = new Files();
        $model->model_class = $model_class;
        $model->model_id = $model_id;
        $model->user_id = Auth::id();
        $model->path = $path;
        $model->file_name = $filename;
        $model->hash = md5(time().rand(1,1000000).$filename);
        $model->save();
        return $model;
    }
}
