@extends('layouts.app')

@section('content')

    @include('assump_constraint.change_view_page',['item'=>$item,'mainData'=>$mainData])

@endsection
