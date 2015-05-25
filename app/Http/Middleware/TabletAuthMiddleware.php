<?php namespace App\Http\Middleware;

use App\Tablet;
use Closure;
use Illuminate\Support\Facades\Auth;

class TabletAuthMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        if( Tablet::findOrFail($request->input('tablet_id')) ){
            return $next($request);
        }else{
            return response('Unauthorized.', 401);
        }

	}

}
