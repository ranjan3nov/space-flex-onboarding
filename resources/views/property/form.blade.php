
@csrf
@if(isset($property) && $property->id)
    <input type="hidden" name="id" value="{{ $property->id }}">
@endif

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $property->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $property->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="type" class="form-label">Type</label>
    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
        <option value="rent" {{ old('type', $property->type ?? '') == 'rent' ? 'selected' : '' }}>Rent</option>
        <option value="sale" {{ old('type', $property->type ?? '') == 'sale' ? 'selected' : '' }}>Sale</option>
    </select>
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" step="0.01" value="{{ old('price', $property->price ?? '') }}" required>
    @error('price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="location" class="form-label">Location</label>
    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $property->location ?? '') }}" required>
    @error('location')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="region_id" class="form-label">Region</label>
    <select class="form-select @error('region_id') is-invalid @enderror" id="region_id" name="region_id" required>
        @foreach($regions as $region)
            <option value="{{ $region->id }}" {{ old('region_id', $property->region_id ?? '') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
        @endforeach
    </select>
    @error('region_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
        <option value="available" {{ old('status', $property->status ?? '') == 'available' ? 'selected' : '' }}>Available</option>
        <option value="pending" {{ old('status', $property->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="sold" {{ old('status', $property->status ?? '') == 'sold' ? 'selected' : '' }}>Sold</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="featured_image" class="form-label">Featured Image</label>
    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
    @error('featured_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
