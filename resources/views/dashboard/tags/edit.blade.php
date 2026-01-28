@extends('dashboard.layouts.main')
@section('title', $title)

@section('content')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('main-words.edit_tag') }}</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('dashboard.tags.update', $tag) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                <strong>{{ __('main-words.tags') }}</strong>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <strong>{{ __('main-words.translations') }}</strong>
                                </div>
                                <div class="card-block">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                                        @foreach (config('laravellocalization.supportedLocales') as $key => $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if ($loop->index == 0) active @endif"
                                                    id="{{ $key }}-tab" data-bs-toggle="tab"
                                                    data-bs-target="#{{ $key }}" role="tab"
                                                    aria-controls="{{ $key }}"
                                                    aria-selected="@if ($loop->index == 0) true @else false @endif">{{ $lang['name'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        @foreach (config('laravellocalization.supportedLocales') as $key => $lang)
                                            <div class="tab-pane mt-3 fade @if ($loop->index == 0) show active @endif"
                                                id="{{ $key }}" role="tabpanel"
                                                aria-labelledby="{{ $key }}-tab">
                                                <br>
                                                <div class="form-group mt-3 col-md-12">
                                                    <label>{{ __('settings.title') }} - {{ $lang['name'] }}</label>
                                                    <input type="text" name="{{ $key }}[title]"
                                                        class="form-control" placeholder="{{ __('settings.title') }}"
                                                        value="{{ old($key . '.title', $tag->translate($key)->title ?? '') }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                                        Submit</button>
                                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>
                                        Reset</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>

@endsection
