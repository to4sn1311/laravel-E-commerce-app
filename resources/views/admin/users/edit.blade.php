@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="card-title">Edit User</h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="ti-back-left"></i> Back to List
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password (leave blank to keep current)</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                @if($user->avatar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Current avatar" class="img-thumbnail" style="max-width: 200px">
                    </div>
                @endif
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
                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
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

            <button type="submit" class="btn btn-primary">Update User</button>
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
