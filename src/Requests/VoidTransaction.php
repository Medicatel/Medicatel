<?php

namespace MedicatelPixelPay\Sdk\Requests;

use MedicatelPixelPay\Sdk\Base\RequestBehaviour;

class VoidTransaction extends RequestBehaviour
{
	/**
	 * Payment UUID
	 *
	 * @var string
	 */
	public $payment_uuid;

	/**
	 * Reason for void the order
	 *
	 * @var string
	 */
	public $void_reason;
}