@extends('admin.layouts.app')
@section('title', 'Create User')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="card-title">Create User</h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="ti-back-left"></i> Back to List
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" onchange="previewImage(this)">
                @error('avatar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="mt-2">
                    <img id="avatar-preview" src="#" alt="Avatar preview" style="max-width: 200px; display: none;" class="img-thumbnail">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Roles</label>
                <div class="row">
                    @foreach($roles as $role)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->name }}"
                                    id="role_{{ $role->id }}"
                                    {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->display_name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('roles')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('avatar-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
