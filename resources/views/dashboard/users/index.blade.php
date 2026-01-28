@extends('dashboard.layouts.main')
@section('title',$title)

@section('content')

<div class="container">

    <h3>{{__('main-words.users')}}</h3>

   <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-success">
            {{__('main-words.add_user')}}
        </a>
        <a href="{{ route('dashboard.users.archive') }}" class="btn btn-secondary">
            {{__('main-words.archive')}}
        </a>
    </div>


    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined At</th>
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
        ajax: "{{ route('dashboard.users.ajax') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name: 'name', title: "{{ __('main-words.name') }}" },
            {data: 'email', name: 'email' ,title: "{{ __('main-words.email') }}"},
            {data: 'role', name: 'role', title:"{{ __('main-words.role') }}"},
            {data: 'created_at', name: 'created_at', title: "{{ __('main-words.joined_at') }}"},
            {data: 'action', name: 'action', title:"{{ __('main-words.action') }}" , orderable: false, searchable: false},
        ]
    });

    // Handle Delete button click
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');

        if(confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '/dashboard/users/' + userId,
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
