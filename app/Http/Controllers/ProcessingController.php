<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\Processing;
use App\Models\UserProgram;
use App\Models\Status;
use App\Models\Basket;
use App\Facades\Balance;
use App\Facades\Hierarchy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Mail\ProcessingEmail;
use Illuminate\Support\Facades\Mail;

class ProcessingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if(isset($request->status)){
            if(isset($request->date_from) and isset($request->date_to)){
                $list = Processing::orderBy('created_at','desc')->whereStatus($request->status)
                    ->whereBetween('created_at', [Carbon::parse(Carbon::parse($request->date_from)), Carbon::parse(Carbon::parse($request->date_to))])
                    ->paginate(30);
            }
            else
            $list = Processing::orderBy('created_at','desc')->whereStatus($request->status)->paginate(30);
        }
        else
        {
            if(isset($request->date_from) and isset($request->date_to)){
                $list = Processing::orderBy('created_at','desc')
                    ->whereBetween('created_at', [Carbon::parse(Carbon::parse($request->date_from)), Carbon::parse(Carbon::parse($request->date_to))])
                    ->paginate(30);
            }
            else

                $list = Processing::orderBy('created_at','desc')->paginate(30);
        }


        if(isset($request->date_from) and isset($request->date_to)){

            session()->flashInput($request->input());


            $invite = Balance::getBalanceOutAllUserNew(['invite_bonus', 'admin_add'], Carbon::parse($request->date_from), Carbon::parse($request->date_to));
            $other = Balance::getBalanceOutAllUserNew(['turnover_bonus','matching_bonus'], Carbon::parse($request->date_from), Carbon::parse($request->date_to));


        }
        else{
            $invite = Balance::getBalanceOutAllUserNew(['invite_bonus', 'admin_add']);
            $other = Balance::getBalanceOutAllUserNew(['turnover_bonus','matching_bonus']);
        }



        return view('processing.index', compact('list', 'invite', 'other'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('admin_processing_create')) {
            abort('401');
        }
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
        //dd("Вывод средств недоступен!");
        $request->validate([
            'sum' => 'required', 'integer',/* ,'min:1000',*/
            'card' => 'required', 'integer'/* ,'min:1000',*/
        ]);

        $balance = Balance::getBalance(Auth::user()->id);
        $sum = $request->sum/385;

        if($balance < $sum) return redirect()->back()->with('status', 'У вас недостаточно средств!');
        if(!Hierarchy::activationCheck()) return redirect()->back()->with('status', 'У вас нет Активации!');

        $user_program = UserProgram::where('user_id',Auth::user()->id)->first();
        $user_status = Status::find($user_program->status_id);

        $data = Processing::create([
            'status' => 'request',
            'sum' => $request->sum/385,
            'in_user' => 0,
            'user_id' => Auth::user()->id,
            'program_id' => Auth::user()->program_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'status_id' => $user_status->id,
            'package_id' => Auth::user()->package_id,
            'card_number' => $request->card
        ]);



        try {
            $soapClient = new \SoapClient('http://92.46.190.49:62669/healthyfood/healthyfood.wsdl');
            $params = array(
                'itemkey' => $data->id,
                'cardnumber' => $request->card,
                'sum' => $request->sum,
            );


            $result = $soapClient->transfer($params);
            if($result->ResponseInfo->ResponseCode == 0){

                Processing::where('id',$data->id)->update([
                    'status' => 'out',
                ]);

                return redirect()->back()->with('status', 'Деньги успешно списаны!');
            }
            else{
                return redirect()->back()->with('status', $result->ResponseInfo->ResponseText);
            }


        } catch (Exception $e) {
            dd('Выброшено исключение: ',  $e->getMessage());
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Gate::allows('admin_processing_view')) {
            abort('401');
        }
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
        if(!Gate::allows('admin_processing_edit')) {
            abort('401');
        }
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
        if(!Gate::allows('admin_processing_status_update')) {
            abort('401');
        }
        Processing::where('id',$id)->update([
            'status' => $request->status
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Gate::allows('admin_processing_destroy')) {
            abort('401');
        }
        //
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'sum'               => 'required', 'integer', 'min:500',
            'transfer_user_id'  => 'required', 'integer', 'exists:users,id',
        ]);

        if(Balance::getBalance(Auth::user()->id) < 0) return redirect()->back()->with('status', 'У вас недостаточно средств!');

        if($request->transfer_user_id == Auth::user()->id) return redirect()->back();

        Processing::insert([
            'status' => 'transfer',
            'sum' => $request->sum,
            'in_user' => $request->transfer_user_id,
            'user_id' => Auth::user()->id,
            'program_id' => Auth::user()->program_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $result = Processing::whereStatus('transfer')->where('in_user',$request->transfer_user_id)->where('user_id',Auth::user()->id)->whereSum($request->sum)->orderBy('created_at','desc')->first();

        $data = [];

        $data['sum'] = $request->sum;
        $user = User::find($request->transfer_user_id);
        $data['name'] = $user->name;
        $data['accept_link'] = 'http://en-rise.com/transfer/1/'.$result->id;
        $data['cancel_link'] = 'http://en-rise.com/transfer/0/'.$result->id;

        //$user->email
        Mail::to(Auth::user()->email)->send(new ProcessingEmail($data));
        return redirect()->back()->with('status', 'Запрос успешно отправлен. Проверьте почту!');
    }

    public function transferAnswer(Request $request, $status, $processing_id)
    {
        if(Processing::where('id',$processing_id)->where('status','transfer')->count() > 0){

            if($status == 1){
                Processing::where('id',$processing_id)->update([
                    'status' => 'transfered'
                ]);

                $result = Processing::where('id',$processing_id)->first();

                Processing::insert([
                    'status' => 'transfer_in',
                    'sum' => $result->sum,
                    'in_user' => $result->user_id,
                    'user_id' => $result->in_user,
                    'program_id' => $result->program_id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

            }
            else{
                Processing::destroy($processing_id);
            }
        }

        return redirect('/')->with('status', 'Успешно обработан!');

    }

    public function overview()
    {
        if(!Gate::allows('admin_overview_access')) {
            abort('401');
        }

        $register = Processing::where('status', 'register')->sum('sum');
        $upgrade = Processing::where('status', 'upgrade')->sum('sum');
        $commission = Balance::getBalanceAllUsers();
        $out = Balance::getBalanceOutAllUsers();
        $shop = Processing::where('status', 'shop')->sum('sum');
        $cashback = Processing::where('status', 'cashback')->sum('sum');

        return view('processing.overview',compact('register','commission','out','shop', 'upgrade','cashback'));
    }

    public function status()
    {
        return view('processing.status');
    }

    public function request(Request $request)
    {
        $request->validate([
            'sum' => ['required', 'numeric', 'min:0'],
            'login' => 'required',
            'program_id' => 'required',
            'withdrawal_method' => 'required',
        ]);



         if(count(Processing::where('user_id', Auth::user()->id)->where('status','request')->get()) > 0){
             return redirect()->back()->with('status', 'У вас есть не обработанный  запрос , не можете отправить повторную заявку пока текущий запрос не обработается ');
         }



        if(Balance::getBalance(Auth::user()->id) < $request->sum) return redirect()->back()->with('status', 'У вас недостаточно средств!');
        $sum = $request->sum;
        $pv = $request->sum;


        Balance::changeBalance(Auth::user()->id,$request->sum,'request',Auth::user()->id,$request->program_id,Auth::user()->package_id,0,$pv,$sum,0,$request->login,'',$request->withdrawal_method, $request->type, $request->iin);


        return redirect()->back()->with('status', 'Запрос успешно отправлен админу!');
    }

    public function statusCounts()
    {
        return view('processing.counts');
    }
}
