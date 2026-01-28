@extends('dashboard.layouts.main')
@section('title',$title)

@section('content')

<div class="container">

    <h3>{{__('main-words.tags')}}</h3>

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('dashboard.tags.create') }}" class="btn btn-success">
            {{__('main-words.add_tag')}}
        </a>
    </div>


    <table class="table table-bordered data-table">

        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th width="150px">Action</th>
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
        ajax: "{{ route('dashboard.tags.ajax') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'title', name: 'title', title: "{{ __('main-words.title') }}"},
            {data: 'action', name: 'action', title:"{{ __('main-words.action') }}", orderable: false, searchable: false},
        ]
    });

    // Handle Delete button click (soft delete)
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var categoryId = $(this).data('id');

        if(confirm('Confirm Delete Tag')) {
            $.ajax({
                url: '/dashboard/tags/' + categoryId,
                type: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    alert('Tag deleted successfully');
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
