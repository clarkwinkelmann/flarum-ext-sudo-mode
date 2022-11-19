@extends('flarum.forum::layouts.basic')
@inject('url', 'Flarum\Http\UrlGenerator')

@section('title', $translator->trans('clarkwinkelmann-sudo-mode.lib.sudo.title'))

@section('content')
    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form" method="POST" action="{{ $url->to('api')->route('sudo-mode') }}">
        <input type="hidden" name="csrfToken" value="{{ $csrfToken }}">
        <input type="hidden" name="redirect" value="{{ $url->to('admin')->base() }}">

        <p class="form-group">
            {{ $translator->trans('clarkwinkelmann-sudo-mode.lib.sudo.message') }}
        </p>

        <p class="form-group">
            <input type="password" class="form-control" name="password" autocomplete="current-password"
                   placeholder="{{ $translator->trans('clarkwinkelmann-sudo-mode.lib.sudo.password') }}">
        </p>

        <p class="form-group">
            <button type="submit"
                    class="button">{{ $translator->trans('clarkwinkelmann-sudo-mode.lib.sudo.submit') }}</button>
        </p>
    </form>
@endsection
