@extends('app')
@section('title', trans_choice('common.pirep', 2))

@section('content')
  <div id="content" class="w-full flex gap-8">
    <div class="w-9/12 flex flex-col self-start">
      <div id="flights" class="bg-white shadow-sm">
        <div id="flights__head" class="p-4 border-b border-gray-100">
          <h2 class="text-xl font-medium">{{ trans_choice('pireps.pilotreport', 2) }}</h2>
          <h6 class="text-sm text-gray-500">Flights you've flown</h6>
        </div>
        <div id="flights__body">
          <table class="table-auto w-full">
            <thead class="bg-blue-900">
            <th class="text-base text-white text-left font-medium px-4 py-3">Flight Number</th>
            <th class="text-base text-white text-left font-medium px-4 py-3">Departure</th>
            <th class="text-base text-white text-left font-medium px-4 py-3">Arrival</th>
            <th class="text-base text-white text-center font-medium px-4 py-3">Aircraft</th>
            <th class="text-base text-white text-center font-medium px-4 py-3">Flight Time</th>
            <th class="text-base text-white text-center font-medium px-4 py-3">Status</th>
            <th class="text-base text-white text-center font-medium px-4 py-3">Submitted</th>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @include('pireps.table')
            </tbody>
          </table>
        </div>
        <div id="flights__footer">
          {{ $pireps->withQueryString()->links('pagination.default') }}
        </div>
      </div>
    </div>
    <div class="w-3/12 flex flex-col self-start">
      <div id="flightSearch" class="bg-white shadow-sm">
        <div id="flightSearch__head" class="p-4 border-b border-gray-100">
          <h2 class="text-xl font-medium">Search</h2>
          <h6 class="text-sm text-gray-500">Search for specific flights</h6>
        </div>
        <div id="flightSearch__body">
          
        </div>
      </div>
    </div>
  </div>
@endsection

@section('keep_for_ref')
  <div class="row">
    <div class="col-md-12">
      <div style="float:right;">
        <a class="btn btn-outline-info pull-right btn-lg"
           style="margin-top: -10px;margin-bottom: 5px"
           href="{{ route('frontend.pireps.create') }}">@lang('pireps.filenewpirep')</a>
      </div>
      <h2></h2>
      @include('flash::message')
      
    </div>
  </div>
  <div class="row">
    <div class="col-12 text-center">
      {{ $pireps->withQueryString()->links('pagination.default') }}
    </div>
  </div>
@endsection

