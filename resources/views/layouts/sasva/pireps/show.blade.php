@extends('app')
@section('title', trans_choice('common.pirep', 1).' '.$pirep->ident)

@section('content')
  <div id="airport__header" class="w-full shadow-sm">
    <div class="flex flex-col bg-white rounded-sm">
      <div id="airportTitle" class="flex border-b border-gray-100 p-4 justify-between">
        <h2 class="text-xl font-medium">Pilot report | {{ $pirep->ident }} - {{ $pirep->dpt_airport_id }} to {{ $pirep->arr_airport_id }}</h2>
        <ul class="flex">
          <li class="bg-green-600 text-white text-xs font-medium px-2 py-1 rounded-sm">
            <a href="">View Simbrief</a>
          </li>
        </ul>
      </div>
      <div id="airportMap" class="flex flex-col divide-x">
        @include('pireps.map')
      </div>
    </div>
  </div>

  <div id="content" class="w-full flex gap-8 mt-8">
    <div class="w-full md:w-8/12 flex flex-col self-start">
      <div id="airport__statistics" class="w-full shadow-sm">
        <div class="flex flex-col bg-white rounded-sm">
          <div id="airportStatsHead" class="flex border-b border-gray-100 p-4">
            <h2 class="text-xl font-medium">Airport Statistics</h2>
          </div>
          <div id="airportStatsBody" class="flex flex-row text-center items-center p-4 divide-x">
            <div class="w-3/12">
              <h2 class="text-2xl">{{ $pirep->dpt_airport_id }}</h2>
              <h6 class="text-base font-medium">Departure Airport</h6>
            </div>
            <div class="w-3/12">
              <h2 class="text-2xl">{{ $pirep->arr_airport_id }}</h2>
              <h6 class="text-base font-medium">Arrival Airport</h6>
            </div>
            <div class="w-3/12">
              <h2 class="text-2xl">0 NM</h2>
              <h6 class="text-base font-medium">Distance Travelled</h6>
            </div>
            <div class="w-3/12">
              <h2 class="text-2xl">00:00</h2>
              <h6 class="text-base font-medium">Block Time</h6>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full flex flex-row gap-8 mt-8">
        <div id="airportInboundFlights" class="w-6/12 bg-white shadow-sm">
          <div id="airportInboundFlights_head" class="p-4 border-b border-gray-100">
            <h2 class="text-xl font-medium">Inbound flights</h2>
            <h6 class="text-sm text-gray-500">Flights flying into</h6>
          </div>
          <div id="airportInboundFlights_body">
            <table class="table-auto w-full">
              <thead class="bg-blue-900">
                <th class="text-base text-white font-medium px-2 py-3">Flight Number</th>
                <th class="text-base text-white font-medium px-2 py-3">Departure Airport</th>
              </thead>
              <tbody class="divide-y divide-gray-100">
                
              </tbody>
            </table>
          </div>
        </div>

        <div id="airportOutboundFlights" class="w-6/12 bg-white shadow-sm">
          <div id="airportOutboundFlights_head" class="p-4 border-b border-gray-100">
            <h2 class="text-xl font-medium">Outbound flights</h2>
            <h6 class="text-sm text-gray-500">Flights flying from </h6>
          </div>
          <div id="airportOutboundFlights_body">
            <table class="table-auto w-full">
              <thead class="bg-blue-900">
                <th class="text-base text-white font-medium px-2 py-3">Flight Number</th>
                <th class="text-base text-white font-medium px-2 py-3">Arrival Airport</th>
              </thead>
              <tbody class="divide-y divide-gray-100">
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>
    <div class="w-4/12 flex flex-col self-start">
      <div id="airportNotes" class="bg-white shadow-sm">
        <div id="airportNotes_head" class="border-b border-gray-100 p-4">
          <h2 class="text-xl font-medium">Airport notes</h2>
        </div>
        <div id="airportNotes_body" class="p-4">
          Test
        </div>
      </div>
      
    </div>
  </div>


  <div class="row">
    <div class="col-sm-8">
      <h2>{{ $pirep->ident }} : {{ $pirep->dpt_airport_id }} to {{ $pirep->arr_airport_id }}</h2>
    </div>

    <div class="col-sm-4">
      {{-- Show the link to edit if it can be edited --}}
      @if (!empty($pirep->simbrief))
        <a href="{{ url(route('frontend.simbrief.briefing', [$pirep->simbrief->id])) }}"
           class="btn btn-outline-info">View SimBrief</a>
      @endif

      @if(!$pirep->read_only && $user && $pirep->user_id === $user->id)
        <div class="float-right" style="margin-bottom: 10px;">
          <form method="get"
                action="{{ route('frontend.pireps.edit', $pirep->id) }}"
                style="display: inline">
            @csrf
            <button class="btn btn-outline-info">@lang('common.edit')</button>
          </form>
          &nbsp;
          <form method="post"
                action="{{ route('frontend.pireps.submit', $pirep->id) }}"
                style="display: inline">
            @csrf
            <button class="btn btn-outline-success">@lang('common.submit')</button>
          </form>
        </div>
      @endif
    </div>
  </div>

  <div class="row">
    <div class="col-8">
      <div class="row">
        {{--
            DEPARTURE INFO
        --}}
        <div class="col-6 text-left">
          <h4>
            {{$pirep->dpt_airport->location}}
          </h4>
          <p>
            <a href="{{route('frontend.airports.show', $pirep->dpt_airport_id)}}">
              {{ $pirep->dpt_airport->full_name }} ({{  $pirep->dpt_airport_id }})</a>
            <br/>
            @if($pirep->block_off_time)
              {{ $pirep->block_off_time->toDayDateTimeString() }}
            @endif
          </p>
        </div>

        {{--
            ARRIVAL INFO
        --}}
        <div class="col-6 text-right">
          <h4>
            {{$pirep->arr_airport->location}}
          </h4>
          <p>
            <a href="{{route('frontend.airports.show', $pirep->arr_airport_id)}}">
              {{ $pirep->arr_airport->full_name }} ({{  $pirep->arr_airport_id }})</a>
            <br/>
            @if($pirep->block_on_time)
              {{ $pirep->block_on_time->toDayDateTimeString() }}
            @endif
          </p>
        </div>
      </div>

      @if(!empty($pirep->distance))
        <div class="row">
          <div class="col-12">
            <div class="progress" style="margin: 20px 0;">
              <div class="progress-bar progress-bar-success" role="progressbar"
                  aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                  style="width: {{$pirep->progress_percent}}%;">
              </div>
            </div>
          </div>
        </div>
      @endif

    {{--

    RIGHT SIDEBAR

    --}}

    <div class="col-4">
      <table class="table table-striped">
        <tr>
          <td width="30%">@lang('common.state')</td>
          <td>
            <div class="badge badge-info">
              {{ PirepState::label($pirep->state) }}
            </div>
          </td>
        </tr>

        @if ($pirep->state !== PirepState::DRAFT)
        <tr>
          <td width="30%">@lang('common.status')</td>
          <td>
            <div class="badge badge-info">
              {{ PirepStatus::label($pirep->status) }}
            </div>
          </td>
        </tr>
        @endif

        <tr>
          <td>@lang('pireps.source')</td>
          <td>{{ PirepSource::label($pirep->source) }}</td>
        </tr>

        <tr>
          <td>@lang('flights.flighttype')</td>
          <td>{{ \App\Models\Enums\FlightType::label($pirep->flight_type) }}</td>
        </tr>

        <tr>
          <td>@lang('pireps.filedroute')</td>
          <td>{{ $pirep->route }}</td>
        </tr>

        <tr>
          <td>{{ trans_choice('common.note', 2) }}</td>
          <td>{{ $pirep->notes }}</td>
        </tr>

        @if($pirep->score && $pirep->landing_rate)
          <tr>
            <td>Score</td>
            <td>{{ $pirep->score }}</td>
          </tr>
          <tr>
            <td>Landing Rate</td>
            <td>{{ number_format($pirep->landing_rate) }}</td>
          </tr>
        @endif

        <tr>
          <td>@lang('pireps.filedon')</td>
          <td>{{ show_datetime($pirep->created_at) }}</td>
        </tr>

      </table>

  @if(!empty($pirep->simbrief))
    <div class="separator"></div>
    <div class="row mt-5">
      <div class="col-12">
        <div class="form-container">
          <h6><i class="fas fa-info-circle"></i>
            &nbsp;OFP
          </h6>
          <div class="form-container-body border border-dark">
            <div class="overflow-auto" style="height: 600px;">
              {!! $pirep->simbrief->xml->text->plan_html !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
