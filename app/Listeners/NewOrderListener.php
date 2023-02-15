<?php

namespace App\Listeners;

use App\Events\NewOrderEvent;
use App\Mail\OrderNew;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewOrderListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($data = [])
    {

        // dd($data);

        // Mail::to($request->user())->send(new OrderShipped($order));
        // Mail::mailer('yandex')->
        Mail::to($data['email'])
            // send(new OrderNew($data));
            ->queue(new OrderNew($data));
            // ->later(now()->addMinutes(10), new OrderNew($data));

        // Mail::send(
        //     // $data['email'],
        //     'emails.newOrder.confirm',
        //     ['kod' => rand()]
        // );

        file_get_contents('https://api.uralweb.info/telegram.php?' . http_build_query(
            array(
                's' => '1',
                // 'id' => $to, // id кому пишем
                // 'msg' => 'пример handle(RegUserEvent $event) '. ( $event->aa ?? 'x' ) // текст сообщения
                'msg' => '11 пример handle(RegUserEvent $event) ' . serialize($data) // текст сообщения
            )
        ));
    }
}
