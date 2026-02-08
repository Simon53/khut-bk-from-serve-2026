<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Closure;
use Illuminate\Http\Request;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'pay-via-ajax',
        'success',
        'success*',
        'cancel',
        'cancel*',
        'fail',
        'fail*',
        'ipn',
        'ipn*',
        'checkout/pay',
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get path in multiple formats for reliable matching
        $path = trim($request->path(), '/');
        $uri = $request->getRequestUri();
        $uriPath = trim(parse_url($uri, PHP_URL_PATH), '/');
        $method = $request->method();
        $routeName = $request->route()?->getName();
        
        // ALWAYS log payment route requests
        if (in_array($path, ['success', 'fail', 'cancel', 'ipn', 'checkout/pay']) || 
            str_contains($path, 'success') || str_contains($path, 'fail') || str_contains($path, 'cancel') ||
            str_contains($uri, 'success') || str_contains($uri, 'fail') || str_contains($uri, 'cancel')) {
            \Log::info('=== CSRF MIDDLEWARE HANDLE CALLED ===', [
                'path' => $path,
                'uriPath' => $uriPath,
                'full_uri' => $uri,
                'method' => $method,
                'route_name' => $routeName,
                'is_reading' => $this->isReading($request)
            ]);
        }
        
        // Completely bypass CSRF for payment callback routes BEFORE any checking
        // Check multiple path formats to ensure we catch all redirects
        $isPaymentCallback = 
            // Exact path matches
            in_array($path, ['success', 'fail', 'cancel', 'ipn']) ||
            in_array($uriPath, ['success', 'fail', 'cancel', 'ipn']) ||
            // Path starts with payment routes
            str_starts_with($path, 'success') || 
            str_starts_with($path, 'fail') ||
            str_starts_with($path, 'cancel') ||
            str_starts_with($uriPath, 'success') ||
            str_starts_with($uriPath, 'fail') ||
            str_starts_with($uriPath, 'cancel') ||
            // URI contains payment routes (for query strings)
            str_contains($uri, '/success') ||
            str_contains($uri, '/fail') ||
            str_contains($uri, '/cancel') ||
            // Route name matches
            in_array($routeName, ['payment.success', 'payment.fail', 'payment.cancel']);
        
        if ($isPaymentCallback) {
            \Log::info('CSRF Completely Bypassed - Payment callback', [
                'path' => $path,
                'uriPath' => $uriPath,
                'route_name' => $routeName,
                'method' => $method
            ]);
            return $next($request);
        }
        
        // Bypass checkout/pay
        if ($path === 'checkout/pay' || $uriPath === 'checkout/pay' || $routeName === 'checkout.pay') {
            \Log::info('CSRF Completely Bypassed - Checkout pay', [
                'path' => $path,
                'uriPath' => $uriPath,
                'route_name' => $routeName,
                'method' => $method
            ]);
            return $next($request);
        }
        
        // For all other routes, use parent handler
        return parent::handle($request, $next);
    }
    
    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        // Get paths and route info
        $path = trim($request->path(), '/');
        $uriPath = trim(parse_url($request->getRequestUri(), PHP_URL_PATH), '/');
        $routeName = $request->route()?->getName();
        $method = $request->method();
        $fullUri = $request->getRequestUri();
        
        // ALWAYS log payment route requests for debugging
        if (in_array($path, ['success', 'fail', 'cancel', 'ipn', 'checkout/pay']) || 
            str_contains($path, 'success') || str_contains($path, 'fail') ||
            str_contains($uriPath, 'success') || str_contains($uriPath, 'fail') ||
            str_contains($fullUri, 'success') || str_contains($fullUri, 'fail')) {
            \Log::info('=== CSRF inExceptArray CALLED ===', [
                'path' => $path,
                'uriPath' => $uriPath,
                'routeName' => $routeName,
                'method' => $method,
                'fullUri' => $fullUri
            ]);
        }
        
        // PRIORITY 1: Check route names first (most reliable)
        if (in_array($routeName, ['checkout.pay', 'payment.success', 'payment.fail', 'payment.cancel', 'payment.ipn'])) {
            \Log::info('CSRF Bypassed - Route name', ['routeName' => $routeName]);
            return true;
        }
        
        // PRIORITY 2: Exact path matches (most common case)
        if (in_array($path, ['success', 'fail', 'cancel', 'ipn', 'checkout/pay'])) {
            \Log::info('CSRF Bypassed - Exact path match', ['path' => $path]);
            return true;
        }
        
        if (in_array($uriPath, ['success', 'fail', 'cancel', 'ipn', 'checkout/pay'])) {
            \Log::info('CSRF Bypassed - Exact URI path match', ['uriPath' => $uriPath]);
            return true;
        }
        
        // PRIORITY 3: Path/URI starts with payment routes (handles query strings)
        $paymentRoutes = ['success', 'fail', 'cancel', 'ipn', 'checkout/pay'];
        foreach ($paymentRoutes as $route) {
            if (str_starts_with($path, $route) || str_starts_with($uriPath, $route)) {
                \Log::info('CSRF Bypassed - Path starts with payment route', [
                    'path' => $path,
                    'uriPath' => $uriPath,
                    'route' => $route
                ]);
                return true;
            }
        }
        
        // PRIORITY 4: Check URI contains payment routes (for absolute URLs)
        if (str_contains($fullUri, '/success') || 
            str_contains($fullUri, '/fail') || 
            str_contains($fullUri, '/cancel') ||
            str_contains($fullUri, '/ipn') ||
            str_contains($fullUri, '/checkout/pay')) {
            \Log::info('CSRF Bypassed - URI contains payment route', ['fullUri' => $fullUri]);
            return true;
        }
        
        // PRIORITY 5: Check exception patterns
        foreach ($this->except as $except) {
            $except = trim($except, '/');
            
            // Exact match
            if ($path === $except || $uriPath === $except) {
                \Log::info('CSRF Bypassed - Exception exact match', ['path' => $path, 'except' => $except]);
                return true;
            }
            
            // Pattern match (removes wildcards and checks)
            $exceptPattern = rtrim($except, '*');
            if (!empty($path) && str_starts_with($path, $exceptPattern)) {
                \Log::info('CSRF Bypassed - Exception pattern match', ['path' => $path, 'except' => $except]);
                return true;
            }
            
            if (!empty($uriPath) && str_starts_with($uriPath, $exceptPattern)) {
                \Log::info('CSRF Bypassed - Exception URI pattern match', ['uriPath' => $uriPath, 'except' => $except]);
                return true;
            }
        }
        
        // PRIORITY 6: Laravel's built-in is() method for pattern matching
        if ($request->is('success*') || 
            $request->is('fail*') || 
            $request->is('cancel*') ||
            $request->is('ipn*') ||
            $request->is('checkout/pay')) {
            \Log::info('CSRF Bypassed - Laravel is() pattern match', ['path' => $path, 'method' => $method]);
            return true;
        }
        
        // If we get here, log it for debugging
        if (str_contains($path, 'success') || str_contains($path, 'fail') || 
            str_contains($uriPath, 'success') || str_contains($uriPath, 'fail')) {
            \Log::warning('CSRF Check - Payment route NOT bypassed!', [
                'path' => $path,
                'uriPath' => $uriPath,
                'routeName' => $routeName,
                'method' => $method,
                'fullUri' => $fullUri,
                'exceptions' => $this->except
            ]);
        }
        
        return false;
    }
}
