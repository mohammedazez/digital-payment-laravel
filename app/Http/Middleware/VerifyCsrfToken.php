<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/payments/coinpayments/deposit/ipn',
        '/sms-gateway/export',
        '/sms-gateway/catch-report',
        '/callback',
        '/payments/*',
        '/webhook/*'
    ];
}
