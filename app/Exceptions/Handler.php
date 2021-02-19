<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->renderable(function (NotFoundHttpException $e, $request) {
            dd('11111');
            $apiErrorCode = 'NotFoundException';
            $message = 'Not found.';

            $exception = $e->getPrevious();
            if ($exception instanceof ModelNotFoundException) {
                $modelName = class_basename($exception->getModel());
                $apiErrorCode = $modelName.$apiErrorCode;
                $message = $modelName.' '.$message;
            }

            return response()->json([
                'error' => $apiErrorCode,
                'message' => $message,
            ], 404);
        });

    }
}
