<?php

namespace App\Http\Middleware;

use App\Enum\FranchiseType;
use App\Helpers\Helper;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if ($result = $this->authenticate($request, $guards)) {
            Helper::createLog('logout', $result['guard']);

            Auth::guard($result['guard'])->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect($result['route'])->with('error', 'Inactive User!!! Logout!');
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            if (in_array('auth:customer', $request->route()->middleware())) {
                return route('customer.login');
            }
            if (in_array('auth:supplier', $request->route()->middleware())) {
                return route('supplier.login');
            }

            return route('backend.login');
        }

        return null;
    }

    protected function authenticate($request, array $guards): ?array
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                if (in_array($guard, [null, 'web'])) {
                    $user = Auth::guard('web')->user();
                    //                    dd($user);
                    if (!$user->is_active
                        || $user->deleted_at != null
                        || $user->userRole->is_active == 0
                        || $user->franchise->status == FranchiseType::INACTIVE->value) {
                        return ['guard' => 'web', 'route' => route('backend.login')];
                    }
                }

                if ($guard == 'customer') {
                    $user = Auth::guard('customer')->user();
                    if (!$user->is_active
                        || $user->deleted_at != null
                        || $user->userRole->is_active == 0) {
                        return ['guard' => 'customer', 'route' => route('website.login')];
                    }
                }

                if ($guard == 'supplier') {
                    $user = Auth::guard('supplier')->user();
                    if (!$user->is_active
                        || $user->deleted_at != null
                        || $user->userRole->is_active == 0) {
                        return ['guard' => 'supplier', 'route' => route('supplier.login')];
                    }
                }

                $this->auth->shouldUse($guard);

                return null;
            }
        }

        $this->unauthenticated($request, $guards);
    }
}
