@foreach($pireps as $pirep)
  <tr class="hover:bg-gray-200">
    <td class="text-base text-left font-medium py-3 px-4">{{ $pirep->ident }}</td>
    <td class="text-base text-center font-medium py-3 px-4">{{ $pirep->dpt_airport->name }}</td>
    <td class="text-base text-center font-medium py-3 px-4">{{ $pirep->arr_airport->name }}</td>
    <td class="text-base text-center font-medium py-3 px-4">
      @if($pirep->aircraft)
        {{ optional($pirep->aircraft)->ident }}
      @else
        -
      @endif
    </td>
    <td class="text-base text-center font-medium py-3 px-4">@minutestotime($pirep->flight_time)</td>
    <td class="text-base text-center font-medium py-3 px-4">
      @php
        $color = 'bg-blue-900';
        if($pirep->state === PirepState::PENDING) {
            $color = 'bg-yellow-600';
        } elseif ($pirep->state === PirepState::ACCEPTED) {
            $color = 'bg-green-600';
        } elseif ($pirep->state === PirepState::REJECTED) {
            $color = 'bg-red-600';
        }
      @endphp
      <div class="{{ $color }} text-white text-xs font-medium px-2 py-1 rounded-sm">{{ PirepState::label($pirep->state) }}</div>
    </td>
    <td class="text-base text-center font-medium py-3 px-4">
      @if(filled($pirep->submitted_at))
        {{ $pirep->submitted_at->diffForHumans() }}
      @endif
    </td>
  </tr>
@endforeach