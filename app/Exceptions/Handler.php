<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if( $request->is('api/*') )
        {
            if( $exception instanceof HttpException )
            {
                $httpCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
                
                switch($httpCode)
                {
                    case 404:
                        return response()->json(['success' => false, 'message' => 'Requested resource could not be found. Please check the link'], $httpCode);
                        break;
                        
                    case 405:
                        return response()->json(['success' => false, 'message' => 'Request method is not allowed'], $httpCode);
                        break;
                        
                    default:
                        break;
                }
            }
        }
        
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
               return redirect()->back()->with('alert-error', 'Token Mismatch atau anda men-submit berulang-ulang silahkan refresh halaman.');
        }
        
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if( $request->expectsJson() ) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect('/login');
    }
}
