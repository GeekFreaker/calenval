@extends('layouts.app')
@include('notice')
@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="from-group col-md-12">

        {!! Form::open(['url' => '/date','method' => 'post']) !!}
        <b>{!! Form::label('Select a date:', null, ['class' => 'control-label']) !!}</b>
        <br/>
        {!! Form::date('date', \Carbon\Carbon::now())!!}
        {!! Form::button('<i class="fa fa-calendar"></i> Set a Date.',["class"=>"btn btn-outline-primary","type"=>"submit"])!!}
        {!! Form::close() !!}

        {!! Form::open(['url' => '/event/pdf_download','method' => 'post']) !!}
        {!! Form::button('<i class="fa fa-file"></i> Download a PDF.',["class"=>"btn btn-outline-danger","type"=>"submit"])!!}
        {!! Form::close() !!}

        <br/><br/>
        {!! $calendar->calendar() !!}
        {!! $calendar->script() !!}
      </div>
  </div>
</div>

@endsection
