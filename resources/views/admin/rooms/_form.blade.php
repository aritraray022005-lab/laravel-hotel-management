@csrf

<div class="form-group">
    <label for="title">Title</label>
    <input id="title" type="text" name="title" class="form-control" value="{{ old('title', $room->title) }}" required>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="5" class="form-control" required>{{ old('description', $room->description) }}</textarea>
</div>

<div class="form-group">
    <label for="price">Price per night ({{ config('hotel.currency') }})</label>
    <input id="price" type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $room->price) }}" required>
</div>

<div class="form-group">
    <label for="type">Room type</label>
    <select id="type" name="type" class="form-control">
        @foreach (\App\Models\Room::TYPES as $value => $label)
            <option value="{{ $value }}" @selected(old('type', $room->type) === $value)>{{ $label }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="has_wifi">Free Wi-Fi</label>
    <select id="has_wifi" name="has_wifi" class="form-control">
        <option value="1" @selected((string) old('has_wifi', (int) $room->has_wifi) === '1')>Yes</option>
        <option value="0" @selected((string) old('has_wifi', (int) $room->has_wifi) === '0')>No</option>
    </select>
</div>

<div class="form-group">
    <label for="image">Photo (JPG, PNG or WebP, max 4 MB)</label>
    @if ($room->image)
        <div class="mb-2"><img src="{{ $room->image_url }}" alt="" width="160"></div>
    @endif
    <input id="image" type="file" name="image" accept="image/*" class="form-control-file">
</div>

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
