<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(isset($request->s)){

            $users = User::whereNotNull('program_id')->where('name','like','%'.$request->s.'%')
                ->orWhere('id','like','%'.$request->s.'%')
                ->orWhere('email','like','%'.$request->s.'%')
                ->orWhere('id_number','like','%'.$request->s.'%')
                ->orderBy('id','desc')
                ->select('users.*')
                ->paginate(30);
        }
        elseif(isset($request->status_id)){
            $users = User::join('user_programs','users.id','=','user_programs.user_id')
                ->where('user_programs.status_id',$request->status_id)
                ->select('users.*')
                ->paginate(30);
        }
        else{
            $users = User::where('users.status',1)
                ->orderBy('id','desc')
                ->paginate(30);
        }




        return view('delivery.index', compact('users'));
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
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::where('id',$id)
            ->orderBy('id','desc')
            ->take(1)
            ->get();

        $couriers = User::whereStatus(1)->get();

        $order =  Order::firstOrCreate(
            [
                'type' => 'register',
                'user_id' => $id,
            ]
        );


        return view('delivery.edit', compact('order','users','couriers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        Order::whereId($request->order_id)
            ->where('type', 'register')
            ->update([
                'delivery_status' => $request->delivery_status,
                'trucking' => $request->trucking,
                'courier_id' => $request->courier_id
            ]);

        return redirect('/delivery');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
