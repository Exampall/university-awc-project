<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $defaultExceptionsMessages = [
        400 => 'Bad request exception',
        409 => 'Conflict request exception'
    ];

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     * @throws Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // if(app()->environment('dev'))
        //     return parent::render($request, $e);
        
        $statusCode = $e instanceof HttpException ? $e->getStatusCode() : 500;
        $errorMessage = $e->getMessage();
        $errorMessage = $errorMessage ? 
            $errorMessage : (
            isset($this->defaultExceptionsMessages[$statusCode]) ? $this->defaultExceptionsMessages[$statusCode] :  'Internal Server Error'
        );    

        return response()->json(
            [
                'error' => [
                    'code' => $statusCode,
                    'message' => $errorMessage
                ]
            ], 
            $statusCode, 
            $e instanceof HttpException ? $e->getHeaders() : []
        );
    }
}
