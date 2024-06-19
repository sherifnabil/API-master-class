<?php

namespace App\Exceptions;

use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponses;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $handlers = [
        ModelNotFoundException::class => 'handleModelNotFound',
        ValidationException::class => 'handleValidation',
        AuthorizationException::class => 'handleAuthorization',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });


        /* Defining a custom exception handler for handling NotFoundHttpException */
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Entity not found.',
                    'status'   => 404,
                ], 404);

            }
        });

        /* Defining a custom exception handler for handling AuthorizationException & AccessDeniedHttpException */
        $this->renderable(function (AuthorizationException|AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'You are not authorized.',
                    'status'   => 401,
                ], 401);

            }
        });

    }

    public function render($request, Throwable $e) {
        $className = get_class($e);
        $index = strpos($className, '\\');

        if(array_key_exists($className, $this->handlers)) {
            $method = $this->handlers[$className];
            $this->error($this->$method($e));
        }

        return $this->error([
            [
                'type'  =>  substr($className, $index+1),
                'status' => 0,
                'message' => $e->getMessage(),
                'source' => 'Line: ' . $e->getLine() . ': ' . $e->getFile() // For The Sake of this example only
            ]
        ], 422);
    }

    private function handleModelNotFound(ModelNotFoundException $e)
    {
        return [
            [
                'status' => 404,
                'message' => 'the resource cannot be found.',
                'source' => $e->getModel() // For The Sake of this example only
            ]
        ];
    }

    private function handleAuthorization(AuthorizationException $e)
    {
        return [
            [
                'status' => 401,
                'message' => 'Unauthorized.',
                'source' => ''
            ]
        ];
    }

    private function handleValidation(ValidationException $e)
    {
        $errors = [];
        foreach ($e->errors() as $key => $value) {
            foreach ($value as $message) {
                $errors[] = [
                    'status' => 422,
                    'message' => $message,
                    'source' => $key
                ];
            }
        }
        return $errors;
    }
}
