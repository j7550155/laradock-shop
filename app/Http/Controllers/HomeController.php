<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailOrder as mailOrder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('member.home');
    }
    public function markRead(Request $request)
    {
        # code...
        $data='';
        $data = $request->all();
        // test 


        Auth::user()->unreadNotifications()->where('id', $data['id'])->first()->markAsRead();
        $unread = count(Auth::user()->unreadNotifications()->get());
        // dd($unread);
        $data=[
            'read_id'=>$data['id'] . 'is read',
            'count_unread'=>$unread,
        ];
        return $data;
    }
    public function cartList(Request $request)
    {
        if ($request->session()->get('cart') != null) {
            $cart = $request->session()->get('cart');
            $cart = json_decode($cart, true);
            $list = [];
            foreach ($cart as $pid => $item) {
                $Product = Product::find($pid);
                $Product->cartId = $pid;
                $Product->buyCount = $item;
                $list[] = $Product;
            }
            $data = ['cart' => $list];
            return view('member.cart', $data);
        }
        $data = ['cart' => ''];
        return view('member.cart', $data);
        // dd($list);
    }
    public function addCart(Request $request)
    {
        //
        $arr = [];

        if ($request->session()->get('cart') != null) { //如果 session 有資料 撈出來 把json字串轉陣列
            $arr = json_decode($request->session()->get('cart'), true);
        }

        $data = $request->all();
        $data = json_decode($data['cart'], true); //把前端json字串轉陣列
        $arr[$data['pid']] = $data['count']; //陣列組合
        // $request->session()->put('countCart', $arr);
        $request->session()->put('cart', json_encode($arr)); //把陣列組成json字串 存到session
        // // dd(json_decode($data['cart'])) ;
        $cart = $request->session()->get('cart');
        return  $cart;
        // dd($data);
    }

    public function delCart(Request $request, $cartId)
    {
        $cart = $request->session()->get('cart');
        $cart = json_decode($cart, true);
        unset($cart[$cartId]);
        // array_slice($cart,$cartId,1,true);
        $request->session()->put('cart', json_encode($cart));
        // dd($cart);

        // dd($list);

        return Redirect('/cart');
    }

    public function buy(Request $request)
    {
        $User = Auth::user();
        $cart = $request->session()->get('cart');
        $cart = json_decode($cart, true);
        $total_prcie = 0;
        try {
            DB::beginTransaction();

            $list = [];
            foreach ($cart as $pid => $item) {

                $Product = Product::find($pid);
                // 結算金額 
                $remain_count = $Product->count - $item;
                if ($remain_count < 0) { // count < 0 拋出錯誤
                    throw new Exception('商品數量不足');
                }
                $Product->count = $remain_count; // 更新數量
                $Product->save();
                $total_prcie += $Product['price'] * $item; //清算總金額
            }

            $data = [ //訂單資料
                'uid' => $User['id'],
                'products' => json_encode($cart),
                'total_price' => $total_prcie,
                'status' => 'N'
            ];

            $order = Order::create($data);

            Mail::to($User['email'])
                ->queue(new mailOrder($order));

            DB::commit();
            $msg = [
                'msg' => '購買成功'
            ];
            $request->session()->forget('cart');
            return Redirect('/cart')->withErrors($msg);
        } catch (Exception $exception) {
            DB::rollBack();
            $msg = [
                'msg' => [
                    $exception->getMessage(),
                ]
            ];
            return redirect()->back()->withErrors($msg);
        }
        // array_slice($cart,$cartId,1,true);
        // $request->session()->put('cart',json_encode($cart));
        // dd($cart);

        // dd($list);

    }
}
