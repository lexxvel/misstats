<?php

namespace App\Http\Controllers\Api\v1;
use App\Models\baskets;
use App\Models\items;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function getUserBasket(Request $request){
        $id = $request->input('User_id');
        $items = baskets::join('items', 'baskets.Item_id', '=', 'items.id')
            ->select('baskets.Item_id','baskets.Item_Count', 'items.Item_Name','items.Item_About', 'items.Item_Price', 'items.Item_ImageLink')
            ->where('User_id', $id)->where('baskets.Order_id', NULL)->where('baskets.Basket_Status', NULL)
            ->get();
        if (count($items) === 0) {
            return[
                "status" => false,
                "message" => "В корзине нет товаров!"
            ];
        } else {
            return $items;
        }   
    }

    public function addToBasket(Request $request){
        $userid = $request->input('User_id');
        $itemid = $request->input('Item_id');
        if ($userid !== null && $userid !== '' && $itemid !== null && $itemid !== '') {
            //получение стоимости текущего товара
            $itemcost = items::select('Item_Price')
                    ->where('id', $itemid)
                    ->first();        
            $query = baskets::where('User_id', $userid)
                ->where('Item_id', $itemid)->where('Order_id', NULL)->where('Basket_Status', NULL)
                ->count();
            if($query === 0 || $query === '') {
                baskets::insert([
                    'User_id' => $userid,
                    'Item_id' => $itemid,
                    'Item_Count' => 1,
                    'Item_TC' => $itemcost->Item_Price
                ]);
                return [
                    "status" => true,
                    "message" => "Товар добавлен в корзину!",
                    "price" => $itemcost->Item_Price
                ];
            } else {
                $querytwo = baskets::where('User_id', $userid)
                ->where('Item_id', $itemid)->where('Order_id', NULL)->where('Basket_Status', NULL)
                ->first();
                $querytwo->Item_Count += 1;
                $querytwo->Item_TC += $itemcost->Item_Price;
                $querytwo->save();
                return [
                    "status" => true,
                    "message" => "Данный товар уже есть в корзине. Количество увеличено!"
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => "Во время выполнения метода произошла ошибка"
            ];
        }
    }

    public function controlBasketItems(Request $request) {
        $method = $request->input('method');
        $userid = $request->input('User_id');
        $itemid = $request->input('Item_id');
        $itemcost = items::select('Item_Price')
                    ->where('id', $itemid)
                    ->first(); 
        if ($method !== null || $userid !== null || $itemid !== null){
            if ($method === 'decrease-count'){
                $queryone = baskets::where('User_id', $userid)
                ->where('Item_id', $itemid)->where('Order_id', NULL)->where('Basket_Status', NULL)
                ->first();
                if ($queryone->Item_Count > 1){
                    $queryone->Item_TC -= $itemcost->Item_Price;
                    $queryone->Item_Count -= 1;
                    $queryone->save();
                    return [
                        "status" => true,
                        "message" => "Количество товара в корзине уменьшено успешно!"
                    ];
                } else {
                    $querytwo = baskets::where('User_id', $userid)
                    ->where('Item_id', $itemid)->where('Order_id', NULL)->where('Basket_Status', NULL)
                    ->delete();
                    return [
                        "status" => true,
                        "message" => "Товар удалён из корзины!"
                    ];
                }
            } else if ($method === 'increase-count') {
                $query = baskets::where('User_id', $userid)
                ->where('Item_id', $itemid)->where('Order_id', NULL)->where('Basket_Status', NULL)
                ->first();
                if ($query === null) {
                    return [
                        "status" => false,
                        "message" => "Товара нет в корзине! Не удалось увеличить его количество!"
                    ];
                } else {
                    $query->Item_Count += 1;
                    $query->Item_TC += $itemcost->Item_Price;
                    $query->save();
                    return [
                        "status" => true,
                        "message" => "Данный товар уже есть в корзине. Количество увеличено!"
                    ];
                }

            } else {
                return [
                    "status" => false,
                    "message" => "Метод не найден!"
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => "Во время выполнения метода произошла ошибка"
            ];
        }
    }
    
}
