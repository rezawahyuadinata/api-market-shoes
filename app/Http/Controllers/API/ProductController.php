<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request){
      
        $id = $request->input('id');
        $limit  = $request->input('limit');
        $name  = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');

        $price_from = $request->inpit('price_from');
        $price_to = $request->inpit('price_to');

        if($id){
            $product = Product::with(['category', 'galleries'])->find($id);

            if($product === null){
                return ResponseFormatter::error(
                    null,
                    'Data product yang di cari tidak ada',
                    404
                );

            }else{
                return ResponseFormatter::success(
                    $product,
                    'Data product berhasil di tampilkan',
                );
            }
        }

        $product = Product::with(['category', 'galleries'])->find($id);

        if($name){
            $product->where('name', 'like', '%' . $name . '%');
        }
        if($description){
            $product->where('description', 'like', '%' .$description. '%');
        }
        if($tags){
            $product->where('tags', 'like', '%' .$tags. '%');
        }
        if($price_from){
            $product->where('price', '>=', $price_from);
        }
        if($price_to){
            $product->where('price', '<=', $price_from);
        }
        if($categories){
            $product->where('categories', $categories);
        }

        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data Product berhasil di ambil'
        );
    }
}
