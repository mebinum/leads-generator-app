<?php

namespace LeadBrowser\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewInvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  \LeadBrowser\Customer\Contracts\Invoice  $invoice
     * @return void
     */
    public function __construct(public $invoice)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->invoice->order;

        return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
                    ->to($order->customer_email, $order->customer_full_name)
                    ->subject(trans('shop::app.mail.invoice.subject', ['order_id' => $order->increment_id]))
                    ->view('shop::emails.sales.new-invoice');
    }
}
