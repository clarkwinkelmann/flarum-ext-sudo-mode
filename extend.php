<?php

namespace ClarkWinkelmann\SudoMode;

use Flarum\Admin\Middleware\RequireAdministrateAbility;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Api\Serializer\UserSerializer;
use Flarum\Extend;
use Flarum\Group\Group;
use Flarum\Http\Middleware\AuthenticateWithHeader;
use Flarum\Http\Middleware\AuthenticateWithSession;
use Flarum\Http\Middleware\CheckCsrfToken;
use Flarum\Http\Middleware\ShareErrorsFromSession;
use Flarum\Tags\Tag;
use Flarum\User\User;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js'),

    (new Extend\Routes('api'))
        ->post('/sudo-mode', 'sudo-mode', SudoController::class),

    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\View())
        ->namespace('sudo-mode', __DIR__ . '/views'),

    (new Extend\Policy())
        ->modelPolicy(Group::class, Policy\GroupPolicy::class)
        ->modelPolicy(Tag::class, Policy\TagPolicy::class)
        ->modelPolicy(User::class, Policy\UserPolicy::class)
        ->globalPolicy(Policy\GlobalPolicy::class),

    (new Extend\Middleware('api'))
        ->insertAfter(AuthenticateWithHeader::class, Middleware\RetrieveSudoMiddleware::class),

    (new Extend\Middleware('forum'))
        ->insertAfter(AuthenticateWithSession::class, Middleware\RetrieveSudoMiddleware::class),

    (new Extend\Middleware('admin'))
        // TODO: check that another extension didn't already add ShareErrorsFromSession
        // If 2 extensions do it, the second call will override the existing bag with an empty one
        ->insertAfter(CheckCsrfToken::class, ShareErrorsFromSession::class)
        ->insertBefore(RequireAdministrateAbility::class, Middleware\AdminMiddleware::class)
        ->insertAfter(AuthenticateWithSession::class, Middleware\RetrieveSudoMiddleware::class),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(function (): array {
            if (SudoGate::canUseAdminFeatures()) {
                return [
                    'sudoModeExpires' => SudoGate::expectedExpirationTimestamp(),
                ];
            }

            return [];
        }),

    (new Extend\ApiSerializer(UserSerializer::class))
        ->attributes(function (UserSerializer $serializer, User $user): array {
            $actor = $serializer->getActor();
            $moreWithSudo = false;
            $attributes = [];

            // Replicate logic from UserPolicy to know if those actions will be available once sudo is enabled
            if ($actor->hasPermission('user.editCredentials') && (!$user->isAdmin() || !$actor->isAdmin())) {
                $moreWithSudo = true;
                // Also set the original attribute so the buttons show up in Flarum UI
                $attributes['canEditCredentials'] = true;
            }

            if ($actor->hasPermission('user.editGroups')) {
                $moreWithSudo = true;
                $attributes['canEditGroups'] = true;
            }

            if ($actor->hasPermission('user.delete')) {
                $moreWithSudo = true;
                $attributes['canDelete'] = true;
            }

            if ($moreWithSudo) {
                return $attributes + [
                        'couldEditWithSudo' => true,
                    ];
            }

            return [];
        }),
];
