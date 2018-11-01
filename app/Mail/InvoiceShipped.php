<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InvoiceShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info('Invoice Send Email : By | ' . session('member_name') . ' | InvoiceNO | ' . $this->invoice->inv_no . ' | PDF | ' . env('BASE_PATH') . env('INVOICE_PATH') . $this->invoice->inv_no . '.pdf');
        return $this->from('postmaster@mds.songserm.com', 'Daily Sale Invoice')
            ->view('invoice.mail')
            ->subject('Songserm : Invoice #' . $this->invoice->inv_no)
            ->attach(env('BASE_PATH') . env('INVOICE_PATH') . $this->invoice->inv_no . '.pdf');
    }
}