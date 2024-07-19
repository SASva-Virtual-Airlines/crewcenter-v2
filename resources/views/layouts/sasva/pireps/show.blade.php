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
          <div id="airportStatsHead" class="flex border-b border-gray-100 p-4 justify-between">
            <h2 class="text-xl font-medium">Pirep Statistics</h2>
            <ul class="flex">
              <li class="bg-blue-900 text-white text-xs font-medium px-2 py-1 rounded-sm">
                Source: {{ PirepSource::label($pirep->source) }}
              </li>
            </ul>
          </div>
          <div id="airportStatsBody" class="flex flex-row text-center items-center p-4 divide-x">
            <div class="w-3/12">
              <h2 class="text-2xl">{{ number_format($pirep->landing_rate) }} fpm</h2>
              <h6 class="text-base font-medium">Landing Rate</h6>
            </div>
            <div class="w-3/12">
              <h2 class="text-2xl">{{ $pirep->score ?? 'N/A' }}</h2>
              <h6 class="text-base font-medium">Score</h6>
            </div>
            <div class="w-3/12">
              <h2 class="text-2xl">{{ $pirep->distance }} NM</h2>
              <h6 class="text-base font-medium">Distance Travelled</h6>
            </div>
            <div class="w-3/12">
              <h2 class="text-2xl">@minutestotime($pirep->flight_time)</h2>
              <h6 class="text-base font-medium">Flight Time</h6>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full flex flex-row gap-8 mt-8">
        <!-- TODO -->
      </div>
      
    </div>
    <div class="w-4/12 flex flex-col self-start">
      <div id="airportNotes" class="bg-white shadow-sm">
        <div id="airportNotes_head" class="border-b border-gray-100 p-4">
          <h2 class="text-xl font-medium">Comments</h2>
        </div>
        <div id="airportNotes_body" class="p-4 divide-y">
          @foreach($pirep->comments as $comment)
              <div>
                <div class="flex flex-row justify-between">
                  <h2 class="text-base font-semibold">{{ $comment->user->name }} - SAS{{ $comment->user->pilot_id }}</h2>
                  <span class="text-base text-gray-500">{{ show_datetime($comment->created_at) }}</span>
                </div>
                <p>{{ $comment->comment }}</p>
              </div>
          @endforeach
        </div>
      </div>
      
    </div>
  </div>

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
