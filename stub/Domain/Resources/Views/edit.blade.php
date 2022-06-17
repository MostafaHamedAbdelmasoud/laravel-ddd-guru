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

        <form class="kt-form" id="kt_form" action="#" method="get">
                        
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">

                <div class="card-body">
                    @include("{$alias}::###VIEW###._partials._fields", [
                        'action' => 'edit',
                    ])
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" @click.prevent="submit()">Submit</button>
                </div>
                <!-- /.card-footer -->

            </div>
            <!-- /.card -->

        </form>
    @endcomponent

@endsection

@push('scripts')
    @include("{$alias}::###VIEW###._partials._scripts", [
        'action' => 'edit',
        'data' => collect($edit),
        'submitUrl' => route('###ROUTE###.update',$edit->id),
    ])
@endpush
