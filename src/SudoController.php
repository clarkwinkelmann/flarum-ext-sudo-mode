<?php

namespace ClarkWinkelmann\SudoMode;

use Flarum\Http\RequestUtil;
use Flarum\Locale\Translator;
use Flarum\User\Exception\NotAuthenticatedException;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SudoController implements RequestHandlerInterface
{
    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var $session Session|null
         */
        $session = $request->getAttribute('session');

        if (!$session) {
            return new TextResponse($this->translator->trans('clarkwinkelmann-sudo-mode.api.errors.cookieOnly'), 400);
        }

        $actor = RequestUtil::getActor($request);
        $password = (string)Arr::get($request->getParsedBody(), 'password');
        $redirect = (string)Arr::get($request->getParsedBody(), 'redirect');

        if (!$actor->checkPassword($password)) {
            if ($redirect) {
                $session->put('errors', new MessageBag([
                    'password' => $this->translator->trans('clarkwinkelmann-sudo-mode.api.errors.incorrectPassword'),
                ]));

                return new RedirectResponse($redirect);
            }

            throw new NotAuthenticatedException;
        }

        // There's no admin check here, anyone can enter sudo mode
        // It just won't have any use for regular users
        // But it will also be used for some moderation features
        $sudoTime = time();
        $session->put('sudo-mode-started-at', $sudoTime);

        // Just set it so we can compute the expiration below
        SudoGate::setValidSudo($sudoTime);

        if ($redirect) {
            return new RedirectResponse($redirect);
        }

        return new JsonResponse([
            'expires' => SudoGate::expectedExpirationTimestamp(),
        ]);
    }
}
