@extends('dashboard.layouts.main')
@section('title', $title)

@section('content')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('main-words.add_post') }}</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('dashboard.posts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <strong>{{ __('main-words.post_details') }}</strong>
                            </div>

                            <div class="card-body">
                                <!-- Image Upload -->
                                <div class="form-group mt-3 col-md-12">
                                    <label>{{ __('main-words.image') }}</label>
                                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                </div>

                                <!-- Category Selection -->
                                <div class="form-group mt-3 col-md-6">
                                    <label>{{ __('main-words.category') }}</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">{{ __('main-words.select_category') }}</option>
                                        @foreach(\App\Models\Category\Category::all() as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- User Selection -->
                                <div class="form-group mt-3 col-md-6">
                                    <label>{{ __('main-words.user') }}</label>
                                    <select name="user_id" class="form-control">
                                        <option value="">{{ __('main-words.select_user') }}</option>
                                        @foreach(\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tags Selection -->
                                <div class="form-group mt-3 col-md-12">
                                    <label>{{ __('main-words.tags') }}</label>
                                    <select name="tags[]" class="form-control" multiple>
                                        @foreach(\App\Models\Tag\Tag::all() as $tag)
                                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                                {{ $tag->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">{{ __('main-words.hold_ctrl_to_select_multiple') }}</small>
                                </div>
                            </div>

                            <!-- Translations Section -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <strong>{{ __('main-words.translations') }}</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach (config('laravellocalization.supportedLocales') as $key => $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if ($loop->index == 0) active @endif"
                                                    id="{{ $key }}-tab" data-bs-toggle="tab"
                                                    data-bs-target="#{{ $key }}" role="tab"
                                                    aria-controls="{{ $key }}"
                                                    aria-selected="@if ($loop->index == 0) true @else false @endif">
                                                    {{ $lang['name'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        @foreach (config('laravellocalization.supportedLocales') as $key => $lang)
                                            <div class="tab-pane mt-3 fade @if ($loop->index == 0) show active @endif"
                                                id="{{ $key }}" role="tabpanel"
                                                aria-labelledby="{{ $key }}-tab">

                                                <!-- Title -->
                                                <div class="form-group mt-3">
                                                    <label>{{ __('main-words.title') }} - {{ $lang['name'] }}</label>
                                                    <input type="text" name="{{ $key }}[title]"
                                                        class="form-control"
                                                        placeholder="{{ __('main-words.title') }}"
                                                        value="{{ old($key . '.title') }}">
                                                </div>

                                                <!-- Small Description -->
                                                <div class="form-group mt-3">
                                                    <label>{{ __('main-words.small_description') }} - {{ $lang['name'] }}</label>
                                                    <textarea name="{{ $key }}[small_description]"
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="{{ __('main-words.small_description') }}">{{ old($key . '.small_description') }}</textarea>
                                                </div>

                                                <!-- Content -->
                                                <div class="form-group mt-3">
                                                    <label>{{ __('main-words.content') }} - {{ $lang['name'] }}</label>
                                                    <textarea name="{{ $key }}[content]"
                                                        id="content_{{ $key }}"
                                                        class="form-control ckeditor-content"
                                                        rows="6"
                                                        placeholder="{{ __('main-words.content') }}">{{ old($key . '.content') }}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-dot-circle-o"></i> {{ __('main-words.submit') }}
                                </button>
                                <button type="reset" class="btn btn-sm btn-danger">
                                    <i class="fa fa-ban"></i> {{ __('main-words.reset') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, initializing CKEditor...');

        // Check if ClassicEditor is available
        if (typeof ClassicEditor === 'undefined') {
            console.error('CKEditor ClassicEditor is not loaded!');
            return;
        }

        // Initialize CKEditor for all content textareas
        const contentTextareas = document.querySelectorAll('.ckeditor-content');
        console.log('Found textareas:', contentTextareas.length);

        contentTextareas.forEach(function(textarea) {
            ClassicEditor
                .create(textarea, {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', '|',
                            'bulletedList', 'numberedList', '|',
                            'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
                    },
                    language: 'en'
                })
                .then(editor => {
                    console.log('CKEditor initialized successfully for:', textarea.id);
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                });
        });
    });
</script>
@endsection
