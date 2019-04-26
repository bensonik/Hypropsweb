@extends('layouts.temp_app')

@section('content')

    @include('project.page',['item'=>$item,'mainData'=>$mainData])

@endsection