<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClassifyController extends Controller{

public function CheckRequest(){
#
}    
public static function HTTPPost($url, $data) {
    //$data_string = json_encode($data);
    
                                                                                       
    $content= $data ;
    $curl = curl_init($url);
    //
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    $json_response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //print_r($status);
    curl_close($curl);
    $response = json_decode($json_response, true);    
    return ['status'=>$status,'response'=>$response,'json_response'=>$json_response,'content'=>$content];//,'json_response'=>$json_response,'status'=>$status]);
                            
}



public function classify(Request $request){
    if($request->ajax()){
        #the process will be here , check the user's account an get the limited number 
        #if thi snumber is more then zero , send the request 
        #if not return with error   
        # also create the middleware , just to ckeck out  

            $subscription = DB::table('limitations')->where([
                ['user_id', '=', Auth::user()->id],
            ])->first();
        
        $limit = $subscription->limit;
        if($limit != 0){
            
            #must store thiss url somewhere in the DB 
            $url="https://language.googleapis.com/v1beta2/documents:annotateText?key=AIzaSyDActRxdx5VFlcSTd9Vl84ciKm3UFCUa7w";
            $response=$this->httpPost($url,$request['dataJ']);
            # decrement limit
            $limit=$limit-1;
            DB::table('limitations')
            ->where('user_id', Auth::user()->id)
            ->update(['limit' => $limit]);
            return response()->json(['code'=>1,'response' =>$response['response']]);
        }else{
            return response()->json(['code' =>0]);    
        }

    }
}

}
