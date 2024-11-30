<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Item::all();

        if($items->count() > 0) {
            return response()->json([
                'status' => true,
                'items' => $items
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        //
        $validator = Validator::make($request->all(), []);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->message()
            ], 422);
        } else {
            $name = '';
            if( $request->photo != '' ) {
                $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(public_path('img/upload/').$name);
                $request->merge(['photo' => $name]);
            }
           
            $item = Item::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'status' => $request->status,
                'photo' => $name
            ]);

            if($item) {
                return response()->json([
                    'status' => 200,
                    'message' => "Item Created successfully!",
                    'item' => $item
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong!",
                ], 500);
            }
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $item = Item::find($id);
        if($item) {
            return response()->json([
                'status' => 200,
                'item' => $item
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No such item found!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, Item $item)
    {
        //
        $validator = Validator::make($request->all(), []);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->message()
            ], 422);
        } else {
            $item = Item::find($request->id);
            $name = '';
            $currentPhoto = $item->photo;
            if( $request->photo != $currentPhoto ) {
                $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(public_path('img/upload/').$name);
                $itemPhoto = public_path('img/upload/').$currentPhoto;

                if(file_exists($itemPhoto)) {
                    @unlink($itemPhoto);
                }
            }
             
            if($item) {
                $item->title = $request->title;
                $item->description = $request->description;
                $item->category = $request->category;
                $item->price = $request->price;
                $item->photo = $name;
                $item->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Item Updated successfully!",
                    'item' => $item
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No such item found!",
                ], 404);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $item = Item::find($id);
        $item->delete();

        return response()->json([
            'status' => true,
            'message' => "Item Deleted successfully!"
        ], 200);
    }
}
