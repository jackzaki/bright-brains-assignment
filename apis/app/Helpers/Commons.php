<?php
  
namespace App\Helpers;


use DB;
use Log;
use DateTime;
use Validator;
use Paginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Visitors;
use Illuminate\Support\Facades\Mail;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\Response\QrCodeResponse;

use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as ppdf;
//use Barryvdh\DomPDF\Facade as PDF;

class Commons {

	public static function response($response) {

		if(is_array($response) && !array_key_exists('data', $response)) { $response['data'] = array(); }
		return response()->json($response, 200);
	}

	public static function success($success) {

		if($success === '') { $success = 'success'; }
		return response()->json([
			'status' => TRUE,
			'message' => $success], 200);
	}

	public static function failed($failed) {

		if($failed === '') { $failed = 'failed'; }
		return response()->json(['status' => FALSE, 'message' => $failed], 422);
	}

	public static function access_denied($failed, $user, $route) {

		if($failed === '') { $failed = 'failed'; }
		return response()->json(['msg' => $failed], 401 );
	}
	
	public static function dateformat($date) {

		if(is_null($date) || $date === '0000-00-00') { return ''; }
		else { return date('d-m-Y', strtotime($date)); }
	}
	public static function datetimeformat($date) {
		if(is_null($date) || $date === '0000-00-00') { return ''; }
		else { return date('d-m-Y H:i:s', strtotime($date)); }
	}
	public static function timeformat($time) {
		return gmdate("H:i:s",$time);
	}

	public static function utcToLocal($datetime,$timezone){
		$dt = new \DateTime($datetime, new \DateTimeZone('UTC'));
 		$dt->setTimezone(new \DateTimeZone($timezone));
 		return $dateString = $dt->format('d-m-Y H:i:s');
	}  
	

	public static function global_filter($filter) {

		if(is_array($filter) && count($filter) > 0) {

			$filters = $filter['filters'];
			foreach($filters as $filter) { if($filter['field'] === 'global') { return trim($filter['value']); }}
		}
	}

	public static function sorting($sort_column, $sort_order,$sort,$query) {

		if(is_array($sort) && count($sort) > 0) {				
			$sort_column = $sort[0]['field'];
			$sort_order = $sort[0]['dir'];
		}
		$query = $query->orderBy($sort_column, $sort_order);
		return $query;
	}
	public static function hourtomin($hour,$min) {
		return $hour*60+$min;
	}
	public static function mintohour($min) {
		if($min>=60){
			$hours =  date('h',mktime(0,$min));
		}else{ $hours = null;}
		
		$mins  =  date('i',mktime(0,$min));
		return ['hours'=>$hours,'mins'=>$mins];
	}
	
	public static function filtering($filter, $query, $display = '') {

		if(is_array($filter) && count($filter) > 0) {

			$filters = $filter['filters'];             
			if($filters[0]['field'] === 'creationdate' && $filters[1]['field'] === 'creationdate') {
				$col = Commons::map_param('creationdate', $display);
				$startdate  =   date('Y-m-d',strtotime($filters[0]['value']));  
				$enddate    =   date('Y-m-d',strtotime($filters[1]['value']));	
				Log::info('startdate ==>'.$startdate.'  enddate==>'.$startdate);							
                $query      =   $query->whereBetween($col, 
                                [str_replace('', '', $startdate).' 00:00:00', 
                                str_replace('', '', $enddate).' 23:59:59']);
			}elseif($filters[0]['field'] === 'campaign_schedule' && $filters[1]['field'] === 'campaign_schedule'){
				$col1 = Commons::map_param('campaign_schedule', $display);
				$startdate  =   date('Y-m-d',strtotime($filters[0]['value']));  
				$enddate    =   date('Y-m-d',strtotime($filters[1]['value']));	
				Log::info($col1.' startdate ==>'.$startdate.'  enddate==>'.$enddate);							
                $query      =   $query->whereBetween($col1, 
                                [$startdate.' 00:00:00',$enddate.' 23:59:59']);
			}
			foreach($filters as $filter) {

				Log::info('value ==>'.$filter['value'].'  field==>'.$filter['field']);
				Log::info('final==>'.self::map_val($filter['field'],$filter['value'], $display));
				if($filter['field'] === 'creationdate'){
				}elseif($filter['field'] === 'campaign_schedule'){
				}else{
					$query = $query->where(Commons::map_param($filter['field'], $display), 'LIKE', self::map_val($filter['field'],$filter['value'], $display).'%');
				}
				
			}
		}
		
		return $query;
	}
	public static function map_param($param, $display = '') {
		$response = $param;        
		if($param === 'creationdate' && $display === 'campaign_number_list') { $response = 'campaign_number.creationdate'; }
		if($param === 'creationdate' && $display === 'report_list_detail') { $response = 'verification_log.creationdate'; }
		if($param === 'creationdate' && $display === 'systemlog') { $response = 'system_log.creationdate'; }
		if($param === 'creationdate' && $display === 'message_log') { $response = 'message_log.creationdate'; }
		if($param === 'status' && $display === 'my_ads') { $response = 'ads.status'; }
		return $response;
	}
	public static function map_val($param,$val, $display = '') {
		$response = $val;        
		if($param === 'category') { $response = self::cleancategory($val); }
		if($param === 'portal') { 
			if($val=='CLASSIFIED ADS'){ $response='classified';
			}elseif($val == 'REAL ESTATE'){$response='real_estate';}
		 }
		return $response;
	}


	
	public static function uploadPath(){
		return __DIR__.'/../../public/files/';            
	}
	
	public static function getSixDigitCode(){
        $six_digit_random_number =  mt_rand(100000, 999999);
		$user = Visitors::where('passcode', $six_digit_random_number)->first();

        if ($user) {
        	Commons::getSixDigitCode();
		}
		
		return $six_digit_random_number;
	}

	public static function sendMail($template,$data, $to, $subject){	
		$htmlContent	= 	file_get_contents(Commons::moneyexpressURL()."email-template/".$template.'.html');
		
		$htmlContent1	=	str_replace("#name#",$data['name'],$htmlContent);
		$htmlContent2	=	str_replace("#url#",$data['url'],$htmlContent1);
		// $htmlContent3	=	str_replace("#password#",$password,$htmlContent2);
		
		$email = new \SendGrid\Mail\Mail(); 
		$email->setFrom("tp.jigar@gmail.com", "JIGAR PATEL");
		$email->setSubject($subject);
		$email->addTo($to, $data['name']);
		$email->addContent("text/plain", $htmlContent2);
		$email->addContent("text/html", $htmlContent2);

		$sendgrid = new \SendGrid(env('sendGrid_API'));
		try {
			$response = $sendgrid->send($email);
			// echo "<pre>";
			// print $response->statusCode() . "\n";
			// print_r($response->headers());
			// print $response->body() . "\n";
			// exit;
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
		}
	}

    public static function sendQRcodeMail($template, $to, $subject, $id){
        $htmlContent	= 	file_get_contents(Commons::moneyexpressURL()."email-template/".$template.'.html');
        //$generate = Commons::generatePDF($id);

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("tp.jigar@gmail.com", "JIGAR PATEL");
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent("text/plain", $htmlContent);
        $email->addContent("text/html", $htmlContent);
//        $email->addAttachment(
//            $file_encoded,
//            "application/pdf",
//            "my_file.txt",
//            "attachment"
//        );

        $file_encoded = file_get_contents(Commons::uploadPath().'pdf/'.$id.'.pdf');
        $email->addAttachment(
            $file_encoded,
            "application/pdf",
            "qrcode.pdf",
            "attachment"
        );

        $sendgrid = new \SendGrid(env('sendGrid_API'));
        //'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'
        try {
            $response = $sendgrid->send($email);
            // echo "<pre>";
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
            // exit;
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    public static function generatePDF($id)
    {
        $html = '<html><head><body style="text-align: center;"><div><h1>MoneyExpressMX</h1><h2>Accepted Here</h2></div>
        <img src="'.Commons::uploadPath().$id.'.png"></body></head></html>';
        ppdf::loadHtml($html)->save(Commons::uploadPath().'pdf/'.$id.'.pdf');
        return 'success';
    }

	public static function moneyexpressURL(){	
		//return	"https://moneyexpressmx.com/backend/apis/public/";
		return	"http://13.126.110.181/ci_demo/apis/public/";
	}

	public static function sendSMS($to,$body){	
		$SMS = file_get_contents(env('SMS_URL').'?to='.base64_encode($to).'&body='.base64_encode($body));
		$smsResponse = json_decode($SMS);
		return $smsResponse;
	}

	public static function sendHSPSMS($to,$body){
		$SMS = file_get_contents(env('HSP_SMS_URL').'?to='.base64_encode($to).'&body='.base64_encode($body));
		$smsResponse = json_decode($SMS);
		return $smsResponse;
	}

	//======Upload profile======//
    public static function fileUpload($file){
        //if($request->hasFile('file')) {
            $ext = strtolower($file->getClientOriginalExtension());

			if($ext =='png' || $ext =='jpg'||$ext =='jpeg' ||$ext =='jpeg' ||$ext =='csv'){
				// $file->getClientOriginalName();
				$localpath  =  $file->getpathName();

				$filename   =  md5(rand(11111,99999).date('Ymdhis')).".".$file->getClientOriginalExtension();

				$target_file = Commons::uploadPath().$filename;

				$success = move_uploaded_file($localpath,$target_file);
				if($success){
					//$response['data'][] = [ "file"     => $filename];
					return $filename;
				}
			} else {   return 'error'; }
	//	}
	}

	public static function getUserEmail($id){
		if($id !== ""){
			$query	=	DB::table('users')->where('uniquecode', $id);
			$data	=	$query->get();
			
			foreach($data as $rec){	
				$response=[			
					'email'        =>   $rec->email
				];
			}

			return @$response;	
		}
	}

    public static function qrcode($code) {
        // Create a basic QR code
        $qrCode = new QrCode($code);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        //$qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        //$qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->setForegroundColor(['r' => 0, 'g' => 51, 'b' => 153, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 133, 'g' => 187, 'b' => 101, 'a' => 0]);
        //$qrCode->setLabel('Scan the code', 16, __DIR__.'/../assets/fonts/noto_sans.otf', LabelAlignment::CENTER());
        //$qrCode->setLogoPath(Commons::uploadPath().'logo.png');
        //$qrCode->setLogoSize(100, 100);
        $qrCode->setValidateResult(false);

        // Round block sizes to improve readability and make the blocks sharper in pixel based outputs (like png).
        // There are three approaches:
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary

        // Set additional writer options (SvgWriter example)
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);

        // Directly output the QR code
        header('Content-Type: '.$qrCode->getContentType());
        //echo $qrCode->writeString();

        // Save it to a file
        $qrCode->writeFile(Commons::uploadPath().$code.'.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        //$dataUri = $qrCode->writeDataUri();

        // generate pdf
        $pdf = Commons::generatePDF($code);
        return 'success';
    }
	


}