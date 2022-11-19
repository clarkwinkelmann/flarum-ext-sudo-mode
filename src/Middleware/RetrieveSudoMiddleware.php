<?php

namespace ClarkWinkelmann\SudoMode\Middleware;

use ClarkWinkelmann\SudoMode\SudoGate;
use Illuminate\Contracts\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RetrieveSudoMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /**
         * @var $session Session|null
         */
        $session = $request->getAttribute('session');

        if ($session) {
            $sudo = $session->get('sudo-mode-started-at');

            if ($sudo) {
                SudoGate::setValidSudo($sudo);
            }
        }

        // API keys can always use all sudo features
        if ($request->getAttribute('apiKey')) {
            SudoGate::setValidSudo(time());
        }

        return $handler->handle($request);
    }
}
