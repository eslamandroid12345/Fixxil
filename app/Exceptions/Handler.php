<?php

namespace App\Exceptions;

use App\Http\Helpers\Http;
use App\Http\Traits\Responser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Twilio\Exceptions\RestException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    use Responser;

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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return $this->responseFail(status: $e->getStatusCode(), message: __('messages.No data found'));
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return mixed
     * @throws Throwable
     */
    public function render($request, Throwable $e): mixed
    {
        if ($e instanceof TokenExpiredException) {
            return $this->responseFail(status: Http::UNAUTHORIZED, message: 'Token expired');
        }
        if ($e instanceof  RestException ) {
            return $this->responseFail(status: 422, message: __('messages.The entered number is incorrect. Check the number.'));
        }
        if ($e instanceof TokenBlacklistedException) {
            return $this->responseFail(status: Http::UNAUTHORIZED, message: 'Token blacklisted');
        }
        if ($e instanceof TokenInvalidException) {
            return $this->responseFail(status: Http::UNAUTHORIZED, message: 'Token invalid');
        }
        if ($e instanceof JWTException) {
            return $this->responseFail(status: Http::UNAUTHORIZED, message: 'JWT error');
        }
        if ($e instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return $this->responseFail(status: Http::UNAUTHORIZED, message: __('messages.Unauthenticated'));
            }
            else {
                return redirect()->route('home');
            }
        }

        return parent::render($request, $e);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->all();
        if ($this->isFrontend($request)) {
            return $request->ajax() ? response()->json($errors, Http::UNPROCESSABLE_ENTITY) : redirect()->back()->withInput()->withErrors($errors);
        }

        return $this->responseFail(message: 'Validation error', data: $errors);
    }

    private function isFrontend($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
