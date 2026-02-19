@extends('app')
@push('page_title') Add Result @endpush
@push('page_head') Add Result @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.results.store') }}">
                @csrf
                @include('admin.results.partials.form', ['result' => null])
                <button class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
