<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supply;
use App\Payment;
use Yabacon;
// use App\customClasses\customCurl AS custCurl;

class PayController extends Controller
{
    private $paystackKey;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->paystackKey = config('constants.paystackTestKey');
    }

    public function showPay($supplyId)
    {
        // Get banks list
        $paystack_object = new Yabacon\Paystack($this->paystackKey);
        
        try
        {
            $tranx = $paystack_object->bank->getList();
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }

        $banks = $tranx->data;
        
        $supplyDetail = Supply::find($supplyId);
        return view('pay/pay', ['supply' => $supplyDetail, 'banks' => $banks]);
    }

    public function addPay (Request $request){
        // "source": "balance", "reason": "Calm down", "amount":3794800, "recipient": "RCP_gx2wn530m0i3w3m"
        $this->validate($request, [
            'supply' => 'required',
            'source' => 'required',
            'amount' => 'required',
            'recipient' => 'required'
            ]);
        $paystack_object = new Yabacon\Paystack($this->paystackKey);

        
        try
        {
            $tranx = $paystack_object->transferrecipient([
                "source"=>"balance",
                "reason"=>"Pay Supplier - ".$request['supplier'],
                "amount"=>$request['amount'],
                "recipient"=>$request['recipient_code'],
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }
        
        $transfer_code = $tranx->data->transfer_code;

        // Update Supply table reference number and recipient_code
        $supply = App\Supply::find($request['supply']);
        $supply->reference = $tranx->data->reference;
        $supply->supplier->paystack_recepient_code = $request['recipient_code'];
        $supply->save();


        // Point to View
        if ($tranx->data->status == "otp"){
            return view("otp",["transfer_code"=>$tranx->data->transfer_code]);
        } elseif ($tranx->data->status == "pending"){
            return view("finalize_pay",["transfer_code"=>$tranx->data->transfer_code]);
        }
    }

    public function showOTP ($transfer_code){
        return view("otp",["transfer_code"=>$transfer_code]);
    }

    public function processOTP (Request $request){
        $this->validate($request, [
            'otp' => 'required',
            'transfer_code' => 'required'
        ]);
    
        $paystack_object = new Yabacon\Paystack($this->paystackKey);
        
        try
        {
            $tranx = $paystack_object->transfer->finalize_transfer([
                "otp"=>$request['otp'],
                "transfer_code"=>$request['transfer_code'],
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }
        
        $reference = $tranx->data->reference;

        if ($tranx->data->status == "success"){
            // Update supply to "paid"
            $supply = App\Supply::where('reference', $tranx->data->reference)->first();
            $supply->status = 'paid';
            $supply->save();
            
            // Send mails

            // Show sucess message
            return view("pay/finalize");
        } else {
            die("We could not verify this Transfer. We will report back to you with additional information");
        }
        // redirect to finalizePay
    }

    public function verifyPay ($reference) {
        if(!$reference){
            die('No reference supplied');
        }

    
        // initiate the Library's Paystack Object
        $paystack_object = new Yabacon\Paystack($this->paystackKey);
        
        try
        {
            $tranx = $paystack_object->transfer->verify($reference);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }
        
        if ($tranx->data->status == "success"){
            
            // Update supply to "paid"
            $supply = App\Supply::where('reference', $tranx->data->reference)->first();
            $supply->status = 'paid';
            $supply->save();

            // Insert Payment record
            $payment = new Payment;
            $payment->reference = $tranx->data->reference;
            $payment->amount = $tranx->data->amount;
            $payment->save();


            
            // Send mails

            // Show sucess message
            return view("pay/finalize");
        } else {
            die("The Transfer couldn't be Confirmed");
        }
        
        // // only a post with paystack signature header gets our attention
        // if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) ) 
        //     exit();

        // // Retrieve the request's body
        // $input = @file_get_contents("php://input");

        // // validate event do all at once to avoid timing attack
        // if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $this->paystackKey))
        //     exit();

        // http_response_code(200);

        // // parse event (which is json string) as object
        // // Do something - that will not take long - with $event
        // $event = json_decode($input, true);


        // if ($event['event'] == "transfer.success"){
        //     update_db ($link, $event['data']['transfer_code']); // Update payment based on Transfer Code
        // }

    }
}
