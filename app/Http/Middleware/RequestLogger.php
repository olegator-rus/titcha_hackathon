<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Request as RequestLog;

class RequestLogger
{

    // Флаг активации логгирования
    private $activate = true;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) : Response | JsonResponse
    {
        return $next($request);
    }

    public function terminate(Request $request) : void
    {
        if($this->activate == false) return;

        try
        {
            // Записываем их в БД
            $log = new RequestLog();
            $log->ip = $request->ip();
            $log->url = $request->url();
            $log->method = $request->method();
            $log->user_agent = $request->server('HTTP_USER_AGENT');
            $log->params = json_encode($request->all());
            $log->user_id = Auth::check() ? Auth::user()->id : null;
            $log->time = Carbon::now();
            $log->execute_time = microtime(true) - LARAVEL_START;
            $log->save();
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }
}
