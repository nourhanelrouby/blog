@extends('dashboard.layouts.main')
@section('title', $title)
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('auth.Profile') }}</h4>
                </div>
                <div class="card-body">
                    <form id="profileForm" method="POST" action="{{ route('dashboard.profileUpdate') }}">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('main-words.name') }}</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('main-words.email') }}</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Password Section -->
                        <h5 class="mb-3">{{ __('main-words.change_password') }}</h5>
                        <p class="text-muted small">{{ __('main-words.leave_blank_if_no_change') }}</p>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('main-words.current_password') }}</label>
                            <input type="password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password"
                                   name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('main-words.new_password') }}</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('main-words.confirm_password') }}</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation">
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>{{ __('main-words.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let submitBtn = $(this).find('button[type="submit"]');

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>{{ __("main-words.updating") }}');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success(response.message || 'profile_updated_successfully');

                // Clear password fields
                $('#current_password, #password, #password_confirmation').val('');

                // Remove error states
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            },
            error: function(xhr) {
                // Remove previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function(key, value) {
                        let input = $('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                    });

                    toastr.error('{{ __("main-words.please_fix_errors") }}');
                } else {
                    toastr.error('{{ __("main-words.something_went_wrong") }}');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>{{ __("main-words.update") }}');
            }
        });
    });
});
</script>
@endpush
