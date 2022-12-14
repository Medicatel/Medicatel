<?php

namespace MedicatelPixelPay\Sdk\Services;

use MedicatelPixelPay\Sdk\Base\Helpers;
use MedicatelPixelPay\Sdk\Base\Response;
use MedicatelPixelPay\Sdk\Base\ServiceBehaviour;
use MedicatelPixelPay\Sdk\Exceptions\InvalidTransactionTypeException;
use MedicatelPixelPay\Sdk\Requests\AuthTransaction;
use MedicatelPixelPay\Sdk\Requests\CaptureTransaction;
use MedicatelPixelPay\Sdk\Requests\PaymentTransaction;
use MedicatelPixelPay\Sdk\Requests\SaleTransaction;
use MedicatelPixelPay\Sdk\Requests\StatusTransaction;
use MedicatelPixelPay\Sdk\Requests\VoidTransaction;

class Transaction extends ServiceBehaviour
{
	/**
	 * Evaluate if transactions should be 3DS authentication
	 *
	 * @param PaymentTransaction $transaction
	 * @throws InvalidTransactionTypeException
	 */
	private function evalAuthenticationTransaction(PaymentTransaction $transaction)
	{
		if ($transaction->authentication_request) {
			throw new InvalidTransactionTypeException('This platform not support 3DS transactions');
		}
	}

	/**
	 * Send and proccesing SALE transaction
	 *
	 * @param SaleTransaction $transaction
	 * @return Response
	 * @throws InvalidCredentialsException
	 */
	public function doSale(SaleTransaction $transaction): Response
	{
		$this->evalAuthenticationTransaction($transaction);

		return $this->post('api/v2/transaction/sale', $transaction);
	}

	/**
	 * Send and proccesing AUTH transaction
	 *
	 * @param AuthTransaction $transaction
	 * @return Response
	 * @throws InvalidCredentialsException
	 */
	public function doAuth(AuthTransaction $transaction): Response
	{
		$this->evalAuthenticationTransaction($transaction);

		return $this->post('api/v2/transaction/auth', $transaction);
	}

	/**
	 * Send and proccesing CAPTURE transaction
	 *
	 * @param re(CaptureTransaction $transaction
	 * @return Response
	 * @throws InvalidCredentialsException
	 */
	public function doCapture(CaptureTransaction $transaction): Response
	{
		return $this->post('api/v2/transaction/capture', $transaction);
	}

	/**
	 * Send and proccesing VOID transaction
	 *
	 * @param VoidTransaction $transaction
	 * @return Response
	 * @throws InvalidCredentialsException
	 */
	public function doVoid(VoidTransaction $transaction): Response
	{
		return $this->post('api/v2/transaction/void', $transaction);
	}

	/**
	 * Verify transaction status
	 *
	 * @param StatusTransaction $transaction
	 * @return Response
	 * @throws InvalidCredentialsException
	 */
	public function getStatus(StatusTransaction $transaction): Response
	{
		return $this->post('api/v2/transaction/status', $transaction);
	}

	/**
	 * Verify a payment hash and returns true if payment response is not modified
	 *
	 * @param string $hash
	 * @param string $order_id
	 * @param string $secret
	 * @return boolean
	 */
	public function verifyPaymentHash(string $hash, string $order_id, string $secret): bool
	{
		return $hash == Helpers::hash('MD5', implode('|', [$order_id, $this->settings->auth_key, $secret]));
	}
}