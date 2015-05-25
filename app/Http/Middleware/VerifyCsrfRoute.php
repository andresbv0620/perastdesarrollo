<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfRoute extends BaseVerifier {

    private $openRoutes =
        [
            'api/v1/apitest'
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
        if(in_array($request->path(), $this->openRoutes))
            return $next($request);

        return parent::handle($request, $next);

	}

}