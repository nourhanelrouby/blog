@extends('dashboard.layouts.main')
@section('title', $title)

@section('content')

<div class="container">

    <h3>{{ __('main-words.archive') }}</h3>

    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>{{ __('settings.name') }}</th>
                <th>{{ __('main-words.image') }}</th>
                <th width="100px">{{ __('main-words.action') }}</th>
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
        ajax: "{{ route('dashboard.categories.archiveAjax') }}",
        columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name', title: "{{ __('main-words.name') }}"},
            {data: 'image', name: 'image', title: "{{ __('main-words.image') }}", orderable: false, searchable: false},
            {data: 'action', name: 'action', title:"{{ __('main-words.action') }}", orderable: false, searchable: false},
        ]
    });

    // Handle Restore button click
    $(document).on('click', '.restore-btn', function(e) {
        e.preventDefault();
        var categoryId = $(this).data('id');

        if(confirm('Confirm Rstore Category')) {
            $.ajax({
                url: '/dashboard/categories/restore/' + categoryId,
                type: 'PUT',
                success: function(response) {
                    table.ajax.reload();
                    alert('Category Restored Successfully');
                },
                error: function(xhr) {
                    alert('Error Delete Category ');
                }
            });
        }
    });

    // Handle Delete button click (permanent delete)
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var categoryId = $(this).data('id');

        if(confirm('Confirm delete?')) {
            $.ajax({
                url: '/dashboard/categories/delete/' + categoryId,
                type: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    alert('Category Deleted Successfully');
                },
                error: function(xhr) {
                    alert('Error Delete Category');
                }
            });
        }
    });
});
</script>
@endsection
