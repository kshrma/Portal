<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
            </x-slot>

            <!-- Container to align button to the right -->
            <div class="d-flex justify-content-end mt-3">
                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add New Member
                </button>
            </div>
            <div class="container mt-5">
                <h3>Members List</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Environments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->username }}</td>
                            <td>{{ $member->role == 0 ? 'Admin' : 'User' }}</td>
                            <td>{{ is_array($member->environments) ? implode(', ', $member->environments) : $member->environments }}</td>
                            <td>
                                <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-primary">Update</a>
                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                                </form>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Member</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding new member -->
                            <form method="POST" action="{{ route('members.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
                                    @error('username')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
            
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    @error('password')
                                        <div class="alert alert-danger" style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
            
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Admin</option>
                                        <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>User</option>
                                    </select>
                                    @error('role')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Environments</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="selectAll" value="selectAll">
                                        <label class="form-check-label" for="selectAll">Select All</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="dev" value="Dev" name="environments[]">
                                        <label class="form-check-label" for="dev">Dev</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="qc" value="QC" name="environments[]">
                                        <label class="form-check-label" for="qc">QC</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="uat" value="UAT" name="environments[]">
                                        <label class="form-check-label" for="uat">UAT</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="production" value="Production" name="environments[]">
                                        <label class="form-check-label" for="production">Production</label>
                                    </div>
                                </div>
                                @error('environments')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
            
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-app-layout>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->any())
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                    keyboard: false
                });
                myModal.show();
            @endif

            // Handle Select All checkbox logic
            $('#selectAll').on('change', function() {
                $('input[name="environments[]"]').prop('checked', $(this).is(':checked'));
            });

            $('input[name="environments[]"]').on('change', function() {
                if (!$(this).is(':checked')) {
                    $('#selectAll').prop('checked', false);
                }
                else if ($('input[name="environments[]"]:checked').length === $('input[name="environments[]"]').length) {
                    $('#selectAll').prop('checked', true);
                }
            });
        });
    </script>
</body>
</html>
