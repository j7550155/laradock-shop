<?php

namespace App\Http\Controllers;

use App\Notifications\PostsNotify;
use App\Order;
use App\Post;
use Validator;
use App\Product;
use App\User;
use Exception;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
// use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function uploadFiles($fName, $files, $count = null)
    {
        # code...    
        $filesArray = [];
        ($count != null) ? $count = $count : $count = 1;
        foreach ($files as $file) {
            // $filename = $file->getClientOriginalName(); //檔案原名稱
            $extension = $file->getClientOriginalExtension(); //副檔名
            $fileName = 'product_' .  $fName . '-' . $count . '.' . $extension; //新檔名
            // $path = '../public/prod_photo/' . $fileName; //存放路徑
            $path = $file->storeAs('public/products', $fileName); //進行存放
            $path = Storage::url($path);
            array_push($filesArray, $path);
            $count++;
        }

        return $filesArray;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Products = Product::all();
        $Posts=Post::all();
        // $Orders=Order::all();
        $data = [
            'products' => $Products,
            'posts'=>$Posts,
        ];
        return view('admin.index', $data);
    }
    public function addProduct(Request $request)
    {
        //
        $Product = $request->all();
        $rules = [
            'products' => [
                'required',
            ],
            'price' => [
                'required',
                'integer',
            ],
            'count' => [
                'required',
                'integer',
            ],
            'descr' => [
                'required',
            ],
            'photo' => [
                'required',
                'max:5120',
            ]
        ];
        $validator = Validator::make($Product, $rules);
        if ($validator->fails()) {
            return redirect('/admin')->withInput()->withErrors($validator);
        }
        $files = $request->file('photo');
        if ($request->hasFile('photo')) {
            $fileArray = $this->uploadFiles($Product['products'], $files);
            // $data['photo']=implode(';', $fileArray) . ';';
        }
        $data = [
            'products' => $request['products'],
            'price' => $request['price'],
            'count' => $request['count'],
            'descr' => $request['descr'],
            'Tags' => $request['tags'],
            'photo' => implode(';', $fileArray) . ';',
        ];
        $Product = Product::create($data);
        return redirect('/admin');
        // dd($data);
    }

    public function editProduct(Request $request)
    {
        //
        $data = $request->all();

        try {
            $Products = Product::find($data['id']);
            $Products->products = $data['products'];
            $Products->price = $data['price'];
            $Products->count = $data['count'];
            $Products->descr = $data['descr'];
            $Products->Tags = $data['tags'];
            $Products->status = $data['status'];

            $Products->save();

            $msg = [
                'msg' => '修改完成',
            ];
            return redirect()->back()->withErrors($msg);
        } catch (Exception $exception) {

            $msg = [
                'msg' => '修改失敗',
            ];
            dd($exception);
            return redirect()->back()->withErrors($msg);
        }
    }

    public function orderSearch(Request $request)
    {
        # code...
        $data = $request->all();
        $content = $data['content'];  // pid or email
        $sw = $data['switch'];
        if ($sw == 'email') {
            $User = User::where('email', $content)->firstOrFail();
            $Order = $User->orders()->get(); //訂單資料 (商品簡化)
            foreach ($Order  as $order) { //商品詳細化
                $product = json_decode($order['products'], true); //訂單中的商品 id / buyCount
                $products = []; //暫存商品資料數組
                foreach ($product as $pid => $buyCount) { //用商品id找出商品名
                    $Product = Product::find($pid);
                    $item = [
                        'product' => $Product->products,
                        'buyCount' => $buyCount,
                    ];
                    $products[] = $item;  //加入暫存商品數組
                }
                $order->products = $products; //替換 訂單中商品簡化->詳細化
            }
            return $Order;
        } else {
            $Order = Order::find($content);
            $product = json_decode($Order['products'], true);
            $products = []; //暫存商品資料數組
            foreach ($product as $pid => $buyCount) { //用商品id找出商品名
                $Product = Product::find($pid);
                $item = [
                    'product' => $Product->products,
                    'buyCount' => $buyCount,
                ];
                $products[] = $item;  //加入暫存商品數組
            }
            $Order->products = $products; //替換 訂單中商品簡化->詳細化

            return [$Order]; //回傳陣列 前端比較好解
        }
    }

    public function posts(Request $request)
    {
        //
        $admin = Auth::user();
        $data = $request->all();
        $rules = [
            'title' => [
                'required',
                'max:15'
            ],
            'tags' => [
                'required',
            ],
            'content' => [
                'required',
                'max:150',
            ],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect('/admin')->withInput()->withErrors($validator);
        }
        
        $Post=[
            'uid'=>$admin['id'],
            'title'=>$data['title'],
            'Tags'=>$data['tags'],
            'content'=>$data['content']
        ];
        $Post=Post::create($Post);
        $Users=User::all();
        Notification::send($Users,new PostsNotify($Post)); //多組適用
        // $Users->notify(new PostsNotify($Post));
        // dd($Post);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
