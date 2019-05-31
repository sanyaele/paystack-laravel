<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yabacon;

class AjaxController extends Controller
{
    //
    private $paystackKey;

    public function __construct (){
        $this->paystackKey = config('constants.paystackTestKey');
    }
    
    public function getAccount ($accountNumber, $bankCode){
        $paystack_object = new Yabacon\Paystack($this->paystackKey);

        try
        {
            $tranx = $paystack_object->bank->resolve(['account_number'=>$accountNumber,'bank_code'=>$bankCode]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }
        
        return $tranx->data->account_name;
    }


    public function TaddRecipient (Request $request){

        return "Error!";

    }

    public function addRecipient (Request $request){
        //'name':accname, 'description':supplier, 'account_number':accnum , 'bank_code':bank_code
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'account_number' => 'required',
            'bank_code' => 'required'
            ]);
        $paystack_object = new Yabacon\Paystack($this->paystackKey);

        
        try
        {
            $tranx = $paystack_object->transferrecipient->create([
                "type"=>"nuban",
                "name"=>$request['name'],
                "description"=>$request['description'],
                "account_number"=>$request['account_number'],
                "bank_code"=>$request['bank_code'],
                "currency"=>"NGN"
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }
        
        return $tranx->data->recipient_code;
    }
}
