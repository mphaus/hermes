@extends('errors::minimal')

@php
    $link = 'mailto:' . config('app.mph.notification_mail_address');
@endphp

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    {!! __('Sorry, that page does not exist right now. <a href=":link" target="_blank">Maybe contact the nerds about this?</a>', ['link' => $link]) !!}
@endsection
