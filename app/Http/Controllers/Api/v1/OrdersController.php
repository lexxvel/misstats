<?php

namespace App\Http\Controllers\Api\v1;
use App\Models\orders;
use App\Models\baskets;
use App\Models\items;
use App\Models\Paytype;
use App\Models\statuses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function getOrdersListByUserID(Request $request) {
        $userid = $request->input('User_id');
        if ($userid !== null || $userid !== '') {
            $query = orders::join('statuses', 'orders.Status_id', '=', 'statuses.Status_id')
            ->join('Paytypes', 'orders.Paytype_id', '=', 'Paytypes.Paytype_id')
            ->select('orders.*', 'statuses.Status_Name', 'Paytypes.Paytype_Name', 'Paytypes.Paytype_Info')
            ->where('orders.User_id', $userid)
            ->get();
            return $query;
            
            /*
            $query = orders::join('baskets', 'orders.Order_id', '=', 'baskets.Order_id')
            ->join('items', 'baskets.Item_id', '=', 'items.id')
            ->select('orders.Order_id', 'orders.Order_TCost' ,'baskets.Basket_id', 'baskets.Item_id', 'items.Item_Name')
            ->where('orders.User_id', $userid)
            ->get();
            return $query;
            */
        }
    }

    public function getOrderByID(Request $request){
        $orderid = $request->input('Order_id');
        if ($orderid !== null || $orderid !== '') {
            $query = baskets::join('items', 'baskets.Item_id', '=', 'items.id')
            ->select('baskets.Basket_id', 'baskets.Item_id', 'items.Item_Name', 'baskets.Item_Count')
            ->where('baskets.Order_id', $orderid)
            ->get();
            return $query;
        }
    }   

    public function makeOrder(Request $request) {
        $userid = $request->input('User_id'); //получение user id
        $paytype = $request->input("Paytype_id"); //получение Paytype_id
        if ($userid !== '' && $userid !== null) {
            
            //проверка наличия товаров для заказа
            $itemsinbasket = $this->countItemsinBasket($userid);
            
            if ($itemsinbasket < 1) {
                return [
                    "status" => false,
                    "message" => 'В корзине пусто!'
                ];
            } else {
                $ordersum = $this->getOrderSum($userid);
                
                $date = Carbon::now(); //дата время
                
                if ($ordersum === null || $ordersum === '') {
                    return [
                        "status" => false,
                        "message" => 'Ошибка рассчёта итоговой стоимости заказа!'
                    ];
                } else {
                    orders::insert([
                        'User_id' => $userid,
                        'Order_DT' => $date,
                        'Order_TCost' => $ordersum,
                        'Status_id' => 1,
                        'Paytype_id' => $paytype,
                    ]);

                    $orderidNew = $this->getCreatedOrderId();

                    baskets::where('User_id', $userid)
                    ->where('Basket_Status', NULL)->where('Order_id', NULL)
                    ->update(['Basket_Status' => 1, 'Order_id' => $orderidNew]);

                    return [
                        "status" => true,
                        "message" => 'Заказ создан!',
                        "sum" => $ordersum,
                        "date" => $date, 
                        "newOrderId" => $orderidNew
                    ];
                }
            }
        } else { 
            return [
                "status" => false,
                "message" => 'Отсутствует обязательный идентификатор id пользователя!'
            ];
        }
    }

    public function countItemsinBasket($userid) {
        return baskets::where('User_id', $userid) 
            ->where('Basket_Status', NULL)
            ->where('Order_id', NULL)
            ->count();
    }

    public function getOrderSum($userid) {
        return baskets::where('User_id', $userid) //получение итоговой стоимости заказа по сумме стоимости товаров в корзине
                ->where('Order_id', NULL)->where('Basket_Status', NULL)
                ->sum('Item_TC');
    }

    public function getAllOrders() {
        $query = orders::join('statuses', 'orders.Status_id', '=', 'statuses.Status_id')
        ->join('Paytypes', 'orders.Paytype_id', '=', 'Paytypes.Paytype_id')
        ->join('users', 'users.id', '=', 'Orders.User_id')
        ->select('orders.*', 'statuses.Status_Name', 'Paytypes.Paytype_Name', 'Paytypes.Paytype_Info', 'users.User_Name', 'users.User_Secname', 'users.User_Surname', 'users.User_Email')
        ->get();
        return $query;
    }

    //получение id созданного заказа
    private function getCreatedOrderId() {
        return orders::orderBy('Order_id', 'DESC')->first()->Order_id;
    }
}
