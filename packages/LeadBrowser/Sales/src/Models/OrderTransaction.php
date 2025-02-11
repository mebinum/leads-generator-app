<?php

namespace LeadBrowser\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Sales\Contracts\OrderTransaction as OrderTransactionContract;

class OrderTransaction extends Model implements OrderTransactionContract
{
    protected $table = 'order_transactions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}