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
                        'action' => 'create',
                    ])
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" @click.prevent="submit()" :disabled="isLoading">Submit</button>
                    <button type="submit" class="btn btn-link" @click.prevent="submit('continue')">Save continue</button>
                </div>
                <!-- /.card-footer -->

            </div>
            <!-- /.card -->

        </form>
    @endcomponent

@endsection

@push('scripts')
    @include("{$alias}::###VIEW###._partials._scripts", [
        'action' => 'create',
        'data' => collect(old()),
        'submitUrl' => route('###ROUTE###.store'),
    ])
@endpush
