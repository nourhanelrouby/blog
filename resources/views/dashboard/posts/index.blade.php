@extends('dashboard.layouts.main')
@section('title', $title)

@section('content')

<div class="container">

    <h3>{{ __('main-words.posts') }}</h3>

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('dashboard.posts.create') }}" class="btn btn-success">
            {{ __('main-words.add_post') }}
        </a>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>{{ __('main-words.title') }}</th>
                <th>{{ __('main-words.small_description') }}</th>
                <th>{{ __('main-words.image') }}</th>
                <th>{{ __('main-words.category') }}</th>
                <th>{{ __('main-words.user') }}</th>
                <th>{{ __('main-words.tags') }}</th>
                <th width="150px">{{ __('main-words.action') }}</th>
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
        ajax: "{{ route('dashboard.posts.ajax') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'small_description', name: 'small_description'},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'category', name: 'category.name'},
            {data: 'user', name: 'user.name'},
            {data: 'tags', name: 'tags', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Handle Delete button click
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var postId = $(this).data('id');

        if(confirm('{{ __("main-words.confirm_delete_post") }}')) {
            $.ajax({
                url: '/dashboard/posts/' + postId,
                type: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    alert(response.message || 'Post deleted successfully');
                },
                error: function(xhr) {
                    alert('Error deleting post');
                }
            });
        }
    });
});
</script>
@endsection
