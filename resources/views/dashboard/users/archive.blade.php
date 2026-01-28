@extends('dashboard.layouts.main')
@section('title',$title)

@section('content')

<div class="container">

    <h3>{{__('main-words.archive')}}</h3>

    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th width="100px">Action</th>
            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>

</div>

@endsection

@section('scripts')
<script type="text/javascript">
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dashboard.users.archiveAjax') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name: 'name', title: "{{ __('main-words.name') }}" },
            {data: 'email', name: 'email' ,title: "{{ __('main-words.email') }}"},
            {data: 'role', name: 'role', title:"{{ __('main-words.role') }}"},
            {data: 'status', name: 'status', title: "{{ __('main-words.status') }}"},
            {data: 'action', name: 'action', title:"{{ __('main-words.action') }}" , orderable: false, searchable: false},
        ]
    });

     // Handle Delete restore click
    $(document).on('click', '.restore-btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');

        if(confirm('Are you sure you want to restore this user?')) {
            $.ajax({
                url: '/dashboard/users/restore/' + userId,
                type: 'PUT',
                success: function(response) {
                    table.ajax.reload();
                    alert('User restored successfully');
                },
                error: function(xhr) {
                    alert('Error restoring user');
                }
            });
        }
    });

    // Handle Delete button click
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');

        if(confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '/dashboard/users/delete/' + userId,
                type: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    alert('User deleted successfully');
                },
                error: function(xhr) {
                    alert('Error deleting user');
                }
            });
        }
    });
});
</script>
@endsection
