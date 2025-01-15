@extends('admin.layouts.app')
@section('title', 'Users List')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="card-title">Users List</h1>
            @can('create-users')
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="ti-plus"></i> Create New User
            </a>
            @endcan
        </div>
        <div class="card-body">
            <table id="usersTable" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    @php
                                        $badgeClass = match($role->group) {
                                            'system' => 'badge-danger',
                                            'user' => 'badge-primary',
                                            default => 'badge-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $role->display_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div role="group">
                                    @can('edit-users')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    @endcan
                                    @can('delete-users')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#usersTable').DataTable({
                responsive: true,
                processing: true,
                order: [[0, 'desc']],
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    }
                ],
                language: {
                    search: "Search:",
                    lengthMenu: "_MENU_ records per page",
                }
            });

            // Add delete confirmation
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                    this.submit();
                }
            });
        });
    </script>
    @endpush
@endsection
