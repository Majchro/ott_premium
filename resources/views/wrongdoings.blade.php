@extends('layouts.app')

@section('content')
<div class="bg-white m-4">
  <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Co było źle zrobione w railsowym żółwiu?</h3>
  </div>
  <div class="px-4 py-5 sm:px-6">
    <ul class="list-disc">
      <li>model był traktowany jako serwis</li>
      <li>dane były wyciągane z bazy dla każdego dnia osobno :poggies:</li>
      <li>przypisywanie danych mogłoby być bardziej rozstrzelone na funkcje</li>
      <li>OGROM LOGIKI W WIDOKU</li>
      <li>widok nie rozdzielony na partiale</li>
    </ul>
  </div>
</div>
@endsection
