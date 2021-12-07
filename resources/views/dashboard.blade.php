@extends('layouts.app')

@section('content')
<div class="bg-white m-4">
  <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Attendance list</h3>
  </div>
  @include('dashboard.filters')
</div>
<div class="m-4 mt-0">
  @include('dashboard.table')
</div>
@endsection
