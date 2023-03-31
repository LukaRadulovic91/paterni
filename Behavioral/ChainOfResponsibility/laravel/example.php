<?php

namespace App\Http\Middleware;

use Closure;

class VerifyPayment
{
    public function handle($request, Closure $next)
    {
        // check if payment information is valid
        if (!$request->input('payment_valid')) {
            return response()->json(['message' => 'Invalid payment information'], 400);
        }

        return $next($request);
    }
}

class CheckStock
{
    public function handle($request, Closure $next)
    {
        // check if product is in stock
        if (!$request->input('in_stock')) {
            return response()->json(['message' => 'Product is out of stock'], 400);
        }

        return $next($request);
    }
}

class SendOrderConfirmation
{
    public function handle($request, Closure $next)
    {
        // send order confirmation email
        $customer_email = $request->input('customer_email');
        $order_total = $request->input('order_total');

        // code to send email

        return $next($request);
    }
}

//////////////////

// into app/Http/Kernel.php

protected $routeMiddleware = [
    // other middleware classes
    'verify.payment' => \App\Http\Middleware\VerifyPayment::class,
    'check.stock' => \App\Http\Middleware\CheckStock::class,
    'send.order.confirmation' => \App\Http\Middleware\SendOrderConfirmation::class,
];

//////////////////

// into routes

Route::post('/order', function () {
    // logic for processing order
})->middleware([
    'verify.payment',
    'check.stock',
    'send.order.confirmation',
]);

///////////////////
///             ///
/// WHEN TO USE ///
///             ///
///////////////////

/// Yes, the Chain of Responsibility pattern is commonly used in Laravel with middleware.
///  Middleware in Laravel provides a way to filter incoming HTTP requests and perform actions
///  before and after the request is handled by the application. Middleware can be used
///  to implement a chain of handlers, where each middleware class handles a specific aspect
///  of the request and passes it on to the next middleware class in the chain.
//   Each middleware class can decide whether to handle the request or pass it on to the next
//   middleware in the chain. If a middleware class decides to handle the request, it can modify
//   the request or response as needed before passing it on to the next middleware in the chain.
//   If a middleware class decides not to handle the request, it can return a response or throw an exception,
//   which will stop the middleware chain and prevent the request from being handled by the application.
//   By using the Chain of Responsibility pattern with middleware, you can easily add,
//   remove, or modify middleware classes to handle different parts of the request
//   processing without affecting other parts of the application.