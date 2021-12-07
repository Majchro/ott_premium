@extends('layouts.app')

@section('content')
<div class="w-full h-full flex flex-col justify-center items-center">
  <img src="/images/icon.png" width="300px" height="300px">
  <form action="{{ route('auth-login') }}" method="POST" class="flex flex-col text-center">
    @csrf
    <span>Powiedz przyjacielu i wejdź</span>
    <input type="hidden" name="email" value="admin@admin.pl">
    <input type="password" name="password" required class="mt-2 appearance-none block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none sm:text-sm @error('password') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @else border-gray-300 placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 @enderror">
    @if ($errors->any())
      <ul>
        @foreach ($errors->all() as $error)
          <li class="mt-2 text-sm text-red-600">{{ $error }}</li>
        @endforeach
      </ul>
    @endif
    <input type="submit" class="mt-2 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer" value="Wejdź"></input>
  </form>
</div>
@endsection
