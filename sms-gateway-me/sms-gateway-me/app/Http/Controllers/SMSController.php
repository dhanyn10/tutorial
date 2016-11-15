<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 * @link http://www.laravel.web.id
 * @copyright Laravel.web.id - 2016
 */
class SMSController extends Controller
{
    /**
     * Show send SMS form
     *
     * @return \Response
     */
    public function form()
    {
        return view('sms.form');
    }

    /**
     * @param Request $request
     */
    public function send(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'number'  => 'required|max:20',
            'name'    => 'required|max:50',
            'message' => 'required',
        ]);

        // validate data based on setting above
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }

        // check if php-curl is installed
        abort_if(!function_exists('curl_init'), 500, 'CURL is not installed on your system.');

        // send sms to SMSgateway.me server
        $curl = curl_init('http://smsgateway.me/api/v3/contacts/create');

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'email'    => config('smsgateway.email'),
            'password' => config('smsgateway.password'),
            'device'   => config('smsgateway.device'),
            'number'   => $request->number,
            'name'     => $request->name,
            'message'  => $request->message,
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        // save to log
        $message = new Message;

        $message->status = $response->success;
        $message->status_message = $response->success ? 'Message sent' : 'Failed to send.';

        $message->contact_id = $response->result->user_id;
        $message->contact_number = $response->result->number;
        $message->contact_name = $response->result->name;

        $message->message = $request->message;
        $message->sent_at = \Carbon\Carbon::now();

        $message->save();

        // if failed
        if ($response->success === false) {
            return redirect()
                ->back()
                ->withError('Failed to send message.');
        }

        // if succed
        return redirect()
            ->back()
            ->withSuccess('Message has bent sent.');
    }
}
