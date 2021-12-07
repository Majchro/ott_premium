<form action="{{ route('dashboard.index') }}" method="GET" class="px-4 py-5 sm:px-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
  <div>
    <label class="block text-sm font-medium text-gray-700">Selected user</label>
    <select name="user" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
      @foreach ($users as $user)
        <option value="{{ $user->id }}" @if($user->id == $filters->user) selected @endif>{{ $user->name }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">Selected month</label>
    <input type="month" name="month" value="{{ $filters->month }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
  </div>
  <div class="flex items-center justify-centerleft">
    <input type="submit" value="Submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
  </div>
</form>
