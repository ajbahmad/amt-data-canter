@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Dashboard',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
    ]
])


@endsection
