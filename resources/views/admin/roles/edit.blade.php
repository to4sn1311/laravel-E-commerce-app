@extends('admin.layouts.app')
@section('title', 'Edit Role')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="card-title">Edit Role</h1>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
            <i class="ti-back-left"></i> Back to List
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="display_name" class="form-label">Display Name</label>
                <input type="text" class="form-control" id="display_name" name="display_name" value="{{ $role->display_name }}" required>
                @error('display_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="group" class="form-label">Group</label>
                <select class="form-control" id="group" name="group" required>
                    <option value="">Select group</option>
                    <option value="system" {{ $role->group === 'system' ? 'selected' : '' }}>System</option>
                    <option value="user" {{ $role->group === 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('group')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <div class="row">
                    @foreach($permissions as $group => $items)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="form-check">
                                        <input class="form-check-input group-checkbox" type="checkbox" id="group_{{ $group }}">
                                        <label class="form-check-label fw-bold" for="group_{{ $group }}">
                                            {{ $group }}
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($items as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox"
                                                  type="checkbox"
                                                  id="permission_{{ $permission->id }}"
                                                  name="permissions[]"
                                                  value="{{ $permission->name }}"
                                                  {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('permissions')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Check group checkboxes based on initial state
        $('.card').each(function() {
            var totalPermissions = $(this).find('.permission-checkbox').length;
            var checkedPermissions = $(this).find('.permission-checkbox:checked').length;
            $(this).find('.group-checkbox').prop('checked', totalPermissions === checkedPermissions);
        });

        // Handle group checkbox
        $('.group-checkbox').change(function() {
            $(this).closest('.card')
                   .find('.permission-checkbox')
                   .prop('checked', $(this).is(':checked'));
        });

        // Handle individual permissions
        $('.permission-checkbox').change(function() {
            var groupCard = $(this).closest('.card');
            var totalPermissions = groupCard.find('.permission-checkbox').length;
            var checkedPermissions = groupCard.find('.permission-checkbox:checked').length;

            groupCard.find('.group-checkbox')
                    .prop('checked', totalPermissions === checkedPermissions);
        });
    });
</script>
@endpush
@endsection
