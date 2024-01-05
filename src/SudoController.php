<?php

namespace ClarkWinkelmann\SudoMode;

use Flarum\Foundation\Config;
use Flarum\Http\RequestUtil;
use Flarum\Locale\Translator;
use Flarum\User\Exception\NotAuthenticatedException;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\TextResponse;
use Laminas\Diactoros\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SudoController implements RequestHandlerInterface
{
    protected $translator;
    protected $config;

    public function __construct(Translator $translator, Config $config)
    {
        $this->translator = $translator;
        $this->config = $config;
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
        $redirect = $this->sanitizeRedirectUrl((string)Arr::get($request->getParsedBody(), 'redirect'));

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

    protected function sanitizeRedirectUrl(string $url): ?Uri
    {
        if (empty($url)) {
            return null;
        }

        try {
            $parsedUrl = new Uri($url);
        } catch (\InvalidArgumentException $e) {
            return null;
        }

        // We don't need something as fancy as Flarum's logout controller, because it doesn't make sense to go to any non-Flarum page after entering sudo mode
        if ($parsedUrl->getHost() === $this->config->url()->getHost()) {
            return $parsedUrl;
        }

        return null;
    }
}
