@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Properties</span>
        <a href="{{ route('property.create') }}" class="btn btn-primary btn-sm">Add Property</a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('property.index') }}" class="mb-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Description</label>
                    <input type="text" name="desc" class="form-control" value="{{ request('desc') }}" placeholder="Description">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="">All</option>
                        <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>Rent</option>
                        <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ request('location') }}" placeholder="Location">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Region</label>
                    <select name="region_id" class="form-select">
                        <option value="">All</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Price Range</label>
                    <div class="input-group">
                        <input type="number" name="price_min" class="form-control" value="{{ request('price_min') }}" placeholder="Min">
                        <input type="number" name="price_max" class="form-control" value="{{ request('price_max') }}" placeholder="Max">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="">Default</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest</option>
                        <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Newest</option>
                        <option value="status_asc" {{ request('sort') == 'status_asc' ? 'selected' : '' }}>Status (A-Z)</option>
                        <option value="status_desc" {{ request('sort') == 'status_desc' ? 'selected' : '' }}>Status (Z-A)</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="checkbox" name="include_deleted" id="include_deleted" value="1" {{ request('include_deleted') ? 'checked' : '' }} onclick="if(this.checked) document.getElementById('only_deleted').checked = false;">
                    <label class="form-label" for="include_deleted">Include Deleted</label>
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="only_deleted" id="only_deleted" value="1" {{ request('only_deleted') ? 'checked' : '' }} onclick="if(this.checked) document.getElementById('include_deleted').checked = false;">
                    <label class="form-label" for="only_deleted">Only Deleted</label>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('property.index') }}" class="btn btn-warning w-100">Reset</a>
                </div>
            </div>
        </form>

        <table id="properties-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Region</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($properties as $property)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $property->description }}</td>
                    <td>{{ $property->type }}</td>
                    <td>{{ $property->price }}</td>
                    <td>{{ $property->location }}</td>
                    <td>{{ $property->region->name }}</td>
                    <td>{{ $property->status }}</td>
                    <td class="text-end">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#imagesModal" data-images='@json($property->images ?? [$property->featured_image])'>
                           <i class='fa fa-eye'></i>
                        </button>

                        <a href="{{ route('property.edit', $property->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        @if($property->trashed())
                            <form action="{{ route('property.restore', $property->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-undo"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('property.destroy', $property->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <!-- Images Modal -->
    <div class="modal fade" id="imagesModal" tabindex="-1" aria-labelledby="imagesModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imagesModalLabel">Property Images</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="imagesCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner" id="carousel-inner">
                <!-- Images will be injected here -->
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#imagesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#imagesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var imagesModal = document.getElementById('imagesModal');
    imagesModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var images = button.getAttribute('data-images');
        images = images ? JSON.parse(images) : [];
        var carouselInner = document.getElementById('carousel-inner');
        carouselInner.innerHTML = '';
        if (images.length === 0) {
            carouselInner.innerHTML = '<div class="carousel-item active"><div class="text-center">No images found.</div></div>';
        } else {
            images.forEach(function (img, idx) {
                var active = idx === 0 ? 'active' : '';
                var imgTag = `<div class="carousel-item ${active}"><img src="/storage/${img}" class="d-block w-100" alt="Property Image"></div>`;
                carouselInner.innerHTML += imgTag;
            });
        }
    });
});
</script>

@endpush
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush
