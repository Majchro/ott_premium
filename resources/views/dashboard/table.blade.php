<table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-50">
    <tr>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrance</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exit</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">In office summary</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report summary</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment factor</th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total GAP</th>
    </tr>
  </thead>
  <tbody>
    @each('dashboard.row', $tableData['table'], 'row')
    <tr class="@rowBackground($tableData['table']->count())">
      <td colspan="3"></td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold" colspan="3">{{ $tableData['summary']['inOfficeSummary'] }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ $tableData['summary']['reportSummary'] }}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold" colspan="3">{{ $tableData['summary']['paymentFactory'] }}</td>
    </tr>
  </tbody>
</table>
