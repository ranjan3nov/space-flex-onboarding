@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Property
            <a href="{{ route('property.index') }}" class="btn btn-secondary btn-sm float-end">Back to Properties</a>
        </div>
        <div class="card-body">
            <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data">
                @include('property.form', ['regions' => $regions])
                <button type="submit" class="btn btn-primary">
                    {{ isset($property) && $property->id ? 'Update' : 'Create' }}
                </button>
            </form>
        </div>
    </div>
@endsection
