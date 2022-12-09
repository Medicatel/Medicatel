<?php

namespace MedicatelPixelPay\Sdk\Requests;

use MedicatelPixelPay\Sdk\Base\RequestBehaviour;

class StatusTransaction extends RequestBehaviour
{
	/**
	 * Payment UUID
	 *
	 * @var string
	 */
	public $payment_uuid;
}