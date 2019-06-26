@extends('layouts.mainlayout')

@section('content')

   <div class="text-muted">
     <div class="container">
     <h4 class="text-center">Planning de la semaine {{$weeknum}}, du {{$startWeek}} au {{$endWeek}}</h4>
    <table class="table table-bordered">
        <tr>
            <th width="80px">@sortablelink('id')</th>
            <th>@sortablelink('name')</th>
            <th>@sortablelink('details')</th>
            <th>@sortablelink('created_at')</th>
        </tr>
        @if($products->count())
            @foreach($products as $key => $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->details }}</td>
                    <td>{{ $product->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        @endif
    </table>
    {!! $products->appends(\Request::except('page'))->render() !!}
     </div>
   </div>
@endsection