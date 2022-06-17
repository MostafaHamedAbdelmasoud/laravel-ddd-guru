@extends('backend.layout')

@section('sub_header')
    @component('backend.components.sub-header')
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @component('backend.components.form-portlet')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Description
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <dl>
                    <dt>ID</dt>
                    <dd>{{$show->id}}</dd>
                    <dt>name</dt>
                    <dd>{{$show->name}}</dd>
                    <dt></dt>
                    <dd>
                        <form method="POST" action="{{route('###ROUTE###.destroy',$show->id)}}">
                            @csrf
                            @method('DELETE')
                            <button>Delete</button>
                        </form>
                    </dd>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
    @endcomponent
@endsection