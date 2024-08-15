@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    {!! __('Sorry, that page does not exist right now. <a href=":link" target="_blank">Maybe contact the nerds about this?</a>', ['link' => 'mailto:garion@mphaus.com']) !!}
@endsection
