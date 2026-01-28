@extends('dashboard.layouts.main')
@section('title',$title)
@section('content')
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{__('main-words.Dashboard')}}</li>
        <li class="breadcrumb-item"><a href="#">{{__('main-words.Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item active">{{__('main-words.Dashboard')}}</li>
    </ol>


    <div class="container-fluid">

        <div class="animated fadeIn">
            <form action="{{Route('dashboard.settings.update' , $setting)}}" method="post" enctype="multipart/form-data">
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
                            <strong>{{ __('main-words.Settings') }}</strong>
                        </div>
                        <div class="card-block">

                            <div class="form-group col-md-6">
                                <label>{{ __('settings.logo') }}</label>
                                <img src="{{$setting  ? asset('storage/'.$setting->logo ) : asset('assets/dashboard/img/avatars/7.jpg') }}" alt="LOGO" style="height: 50px">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.favicon') }}</label>
                                <img src="{{ $setting ? asset('storage/'.$setting->favicon) : asset('assets/dashboard/img/avatars/7.jpg') }}" alt="FAV" style="height: 50px">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.logo') }}</label>
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.favicon') }}</label>
                                <input type="file" name="favicon" class="form-control"
                                       placeholder="{{ __('settings.favicon') }}" >
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.facebook') }}</label>
                                <input  type="text" name="facebook" class="form-control"
                                        placeholder="{{ __('settings.facebook') }}" value="{{optional($setting)->facebook}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.instagram') }}</label>
                                <input  type="text" name="instagram" class="form-control"
                                        placeholder="{{ __('settings.instagram') }}" value="{{optional($setting)->instagram }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.twitter') }}</label>
                                <input  type="text" name="twitter" class="form-control"
                                        placeholder="{{ __('settings.twitter') }}" value="{{optional($setting)->twitter}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.linkedin') }}</label>
                                <input  type="text" name="linkedin" class="form-control"
                                        placeholder="{{ __('settings.linkedin') }}" value="{{optional($setting)->linkedin }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.phone') }}</label>
                                <input type="text" name="phone" class="form-control"
                                       placeholder="{{ __('settings.phone') }}" value="{{optional($setting)->phone }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('settings.email') }}</label>
                                <input type="text" name="email" class="form-control"
                                       placeholder="{{ __('settings.email') }}" value="{{optional($setting)->email }}">
                            </div>

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
                                               id="{{$key}}-tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" role="tab"
                                               aria-controls="{{$key}}" aria-selected="@if ($loop->index == 0) true @else false @endif">{{ $lang['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    @foreach (config('laravellocalization.supportedLocales') as $key => $lang)
                                        <div class="tab-pane mt-3 fade @if ($loop->index == 0) show active @endif"
                                             id="{{ $key }}" role="tabpanel" aria-labelledby="{{$key}}-tab">
                                            <br>
                                            <div class="form-group mt-3 col-md-12">
                                                <label>{{ __('settings.name') }} - {{ $lang['name']  }}</label>
                                                <input type="text" name="{{$key}}[name]" class="form-control"
                                                       placeholder="{{ __('settings.name') }}"   value="{{$setting ? $setting->translate($key)->name :'-'}}">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>{{ __('settings.content') }} - {{ $lang['name']  }}</label>
                                                <textarea name="{{$key}}[content]" class="form-control" cols="30" rows="10">{{$setting ? $setting->translate($key)->content :'-'}}</textarea>
                                            </div>


                                            <div class="form-group col-md-12">
                                                <label>{{ __('settings.address') }} - {{ $lang['name']  }}</label>
                                                <input type="text" name="{{$key}}[address]" class="form-control"   value="{{$setting ? $setting->translate($key)->address :'-'}}">
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
            </form>
        </div>
    </div>
@endsection
