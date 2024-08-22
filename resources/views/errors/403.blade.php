@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
    {!! __('Looks like you\'re trying to do something you\'re not allowed to. <a href=":link" target="_blank">Maybe contact the nerds about this?</a>', ['link' => 'mailto:garion@mphaus.com']) !!}
@endsection
