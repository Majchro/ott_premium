<tr class="@if ($row['isWeekend']) bg-red-100 @else @rowBackground($key) @endif">
  <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-800">
    <a href="https://youtu.be/dQw4w9WgXcQ" target="_blank">{{ $row['date'] }}</a>
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['entrance'] }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['exit'] }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ $row['inOfficeSummary'] }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['start'] }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['end'] }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ $row['reportSummary'] }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ $row['paymentFactory'] }}</td>
  @if ($row['isAbsent'])
    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">ABSENT</td>
  @else
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ $row['totalGap'] }}</td>
  @endif
</tr>
