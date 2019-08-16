<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorUploadImgController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * 后台上传图片
     */
    public function upload(Request $request)
    {
        $img = $request->file('img');
        $date = date('Ym/d', time());
        $path = Storage::putFile('backend/images/' . $date, $img);
        return response()->json([
            'errno' => 0,
            'data' => [
                Storage::url($path)
            ]
        ]);
    }
}
