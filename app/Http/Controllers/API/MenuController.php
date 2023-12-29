<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Discount\DiscountRequest;
use App\Http\Requests\API\Menu\CreateRequest;
use App\Http\Requests\API\Menu\UpdateRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuController extends Controller
{
    public function index()
    {
        return $this->jsonResponse([
            'data' => [
                'menus' => MenuResource::collection(Menu::with("discount")->get())
            ]
        ]);
    }

    public function store(CreateRequest $request)
    {
        $menuId = DB::transaction(function () use ($request){
            $menu = Menu::create($request->only('name'));
            $menu->discount()->create(['amount' => $request['discount_amount']]);
            return $menu->id;
        });
        return $this->jsonResponse([
            'data' => [
                'menu_id' => $menuId
            ]
        ],201);
    }

    public function show(Menu $menu)
    {
        $menu->load("discount");
        if (request()->query("all_details",false)){
            $menu->load(["categories" => fn(HasMany $q) => $q
                ->with(["discount","menu.discount","subCategories.subCategories.subCategories.subCategories","parentCategory",])]);
        }

        return $this->jsonResponse([
            'data' => [
                'menu' => new MenuResource($menu)
            ]
        ]);
    }

    public function update(UpdateRequest $request, Menu $menu)
    {
        DB::transaction(function () use ($menu,$request){
            $menu->update($request->only('name'));
            $menu->discount()->update(['amount' => $request['discount_amount']]);
        });
        return $this->jsonResponse(statusCode: 204);
    }

    public function destroy(Menu $menu)
    {
        DB::transaction(function () use ($menu){
            $menu->discount()->delete();
            $menu->delete();
        });

        return $this->jsonResponse(statusCode: 204);
    }

    public function discount(Menu $menu,DiscountRequest $request)
    {
        $menu->discount()->update(['amount' => $request['amount']]);
        return $this->jsonResponse(statusCode: 204);
    }

}
