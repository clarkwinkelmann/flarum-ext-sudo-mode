<?php

namespace ClarkWinkelmann\SudoMode\Middleware;

use ClarkWinkelmann\SudoMode\SudoGate;
use Flarum\Http\RequestUtil;
use Illuminate\Contracts\View\Factory;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AdminMiddleware implements MiddlewareInterface
{
    protected $view;

    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Let RequireAdministrateAbility throw an authorization error
        if (!RequestUtil::getActor($request)->isAdmin()) {
            return $handler->handle($request);
        }

        if (SudoGate::canUseAdminFeatures()) {
            return $handler->handle($request);
        }

        return new HtmlResponse($this->view->make('sudo-mode::sudo')
            ->with('csrfToken', $request->getAttribute('session')->token())
            ->render());
    }
}
