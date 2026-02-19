@extends('app')
@push('page_title') Edit Result @endpush
@push('page_head') Edit Result @endpush
@push('side_head') Admin @endpush
@section('content')
    @include('component.flash')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.results.update', $result) }}">
                @csrf
                @method('PUT')
                @include('admin.results.partials.form', ['result' => $result])
                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
