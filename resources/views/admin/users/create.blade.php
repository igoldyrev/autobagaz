@extends('layouts.admin')

@section('title', 'Новый пользователь')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--form">
            <h1>Новый пользователь</h1>

            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.users.store') }}" class="admin-form">
                @csrf
                @include('admin.users._form', ['submitLabel' => 'Создать пользователя'])
            </form>
        </main>
    </div>
@endsection
