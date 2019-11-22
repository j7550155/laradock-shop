<?php

namespace App\Mail;

use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order ;
class MailOrder extends Mailable
{
    use Queueable, SerializesModels;
    protected $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->order;
        $products = json_decode($data['products'], true);
        $productsList=[];
        foreach($products as $pid => $count){
            $Products=Product::find($pid);
            $Products->buyCount=$count;
            $Products->total_price=$Products->price * $count;
            $productsList[]=$Products;
        }

        $content=[
            'products'=>$productsList,
            'total_price'=>$data['total_price'],
            'created_at'=>$data['created_at'],
        ];

        return $this->view('email.order')->with($content);
    }
}
