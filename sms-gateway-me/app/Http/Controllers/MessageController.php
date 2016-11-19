<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\ValidationRequest;
use App\Message;

class MessageController extends Controller
{
    /**
     * Show all messages.
     */
    public function index()
    {
        $messages = Message::orderBy('created_at', 'DESC')
            ->paginate();

        $types = [
            'outbox' => 'success',
            'draft'  => 'warning',
            'inbox'  => 'info',
        ];

        return view('contents.messages.index', compact('messages', 'types'))
            ->withTitle('Messages');
    }

    /**
     * Show form for send messae
     */
    public function form()
    {
        return view('contents.messages.form');
    }

    /**
     * @param ValidationRequest $request
     */
    public function send(ValidationRequest $request)
    {
        abort_if(!function_exists('curl_init'), 400, 'CURL is not installed.');

        $curl = curl_init('http://smsgateway.me/api/v3/messages/send');

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

        if ($response->success === true) {
            if (!empty($response->result->fails)) {
                \Log::debug($response->result->fails);
            } else {
                foreach ($response->result->success as $success) {
                    $messages[] = [
                        'type'           => 'outbox',
                        'contact_id'     => $success->contact->id,
                        'contact_name'   => $success->contact->name,
                        'contact_number' => $success->contact->number,
                        'device_id'      => $success->device_id,
                        'message'        => $success->message,
                        'expired_at'     => \Carbon\Carbon::now()->timestamp($success->expires_at),
                        'created_at'     => \Carbon\Carbon::now(),
                        'updated_at'     => \Carbon\Carbon::now(),
                    ];
                }

                Message::insert($messages);

                return redirect()
                    ->route('message.form')
                    ->withSuccess('Message has been sent successfully.');
            }
        } else {
            \Log::debug(json_encode($response->errors));
        }

        return redirect()
            ->back()
            ->withError('Failed to send message.');
    }

    /**
     * @param Message $message
     */
    public function destroy(Message $message)
    {
        if ($message->delete() === true) {
            return redirect()
                ->route('message.index')
                ->withSuccess('Message has been deleted.');
        }

        // come for no reason
        return redirect()->back();
    }
}
