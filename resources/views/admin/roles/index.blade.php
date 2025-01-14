@extends('admin.layouts.app')
@section('title', 'Roles')
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
            <h1 class="card-title">Roles list</h1>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <i class="ti-plus"></i> Create New Role
            </a>
        </div>
        <div class="card-body">
            <table id="rolesTable" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Group</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>
                                @php
                                    $badgeClass = match($role->group) {
                                        'system' => 'badge-danger',
                                        'user' => 'badge-primary',
                                        default => 'badge-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $role->group }}</span>
                            </td>
                            <td>
                                <div role="group">
                                    <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info btn-sm">Show</a>
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
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
            $('#rolesTable').DataTable({
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
                if (confirm('Are you sure you want to delete this role?')) {
                    this.submit();
                }
            });
        });
    </script>
    @endpush
@endsection
