<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    function view($hash){
        $file = Files::where('hash',$hash)->first();
        if($file) {
            $img = Storage::path($file->path);
            header('Content-Type: image/jpeg');
            echo file_get_contents($img);
        }
    }
}
