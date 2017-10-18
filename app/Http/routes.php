<?php

use App\Item;
use Illuminate\Http\Request;

/*)
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    $items = Item::orderBy('created_at', 'desc')->get();

    return view('home', [
        'title' => 'Kardi Online Shop',
        'items' => $items,
    ]);
});

Route::get('/admin', function () {
    return view('admin', [
        'title' => 'Kardi Online Shop - Admin'
    ]);
});

Route::post('/login', function (Request $request) {
    if ($request->username == "kardi" && $request->password == "hunter2") {
        $request->session()->put('login', true);
    }

    return redirect('/admin');
});

Route::get('/logout', function (Request $request) {
    $request->session()->forget('login');
    $request->session()->flush();

    return redirect('/admin');
});

Route::post('/item', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'item_name' => 'required|max:255',
        'item_description' => 'required',
        'item_price' => 'required|numeric',
        'item_image' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect('/admin')
            ->withInput()
            ->withErrors($validator);
    }

    // Store items
    $item = new Item;
    $item->name = $request->item_name;
    $item->description = $request->item_description;
    $item->price = $request->item_price;
    $item->image = time() . '.' . $request->item_image->getClientOriginalExtension();
    $request->item_image->move(public_path('items'), $item->image);
    $item->save();

    $item->publishToFacebook($request);
    $item->publishToLine($request);
    $item->publishToTelegram($request);

    return redirect('/admin');
});

Route::get('/item.delete/{id}', function (Request $request, $id) {
    if ($request->session()->has('login')) {
        Item::findOrFail($id)->delete();
    }

    return redirect('/');
});

Route::post('/telegram', "TelegramController@webHook");
Route::post('/line', "LineController@webHook");