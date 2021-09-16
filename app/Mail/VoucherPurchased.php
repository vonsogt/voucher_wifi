<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherPurchased extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        dd($this->data->instructions);
        return $this->markdown('mails.vouchers.purchased', [
            'customer_email'        => $this->data->customer_email,
            'payment_name'          => $this->data->payment_name,
            'fee_customer'          => $this->data->fee_customer,
            'pay_code'              => $this->data->pay_code,
            'order_items'           => $this->data->order_items,
            'instructions'          => $this->data->instructions,
        ]);
    }
}
