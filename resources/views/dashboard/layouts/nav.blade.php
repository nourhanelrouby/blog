<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">{{__('main-words.Pages')}}</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{__('main-words.Dashboard')}}</li>
      </ol>
      <h6 class="font-weight-bolder mb-0">{{__('main-words.Dashboard')}}</h6>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group">
          <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
          <input type="text" class="form-control" placeholder="Type here...">
        </div>
      </div>
      <ul class="navbar-nav justify-content-end">

        <!-- Language Switcher Dropdown -->
        <li class="nav-item dropdown d-flex align-items-center me-2">
          <a href="javascript:;" class="nav-link text-body font-weight-bold px-0 dropdown-toggle" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-globe me-sm-1"></i>
            <span class="d-sm-inline d-none">{{ strtoupper(LaravelLocalization::getCurrentLocale()) }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="languageDropdown">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              <li>
                <a class="dropdown-item border-radius-md {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'active' : '' }}"
                   hreflang="{{ $localeCode }}"
                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                  <div class="d-flex py-1">
                    <span>{{ $properties['native'] }}</span>
                  </div>
                </a>
              </li>
            @endforeach
          </ul>
        </li>

        <!-- Account Dropdown -->
        <li class="nav-item dropdown d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-body font-weight-bold px-0 dropdown-toggle" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-user me-sm-1"></i>
            <span class="d-sm-inline d-none">{{Auth()->user()->name}}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="accountDropdown">
            <li>
              <a class="dropdown-item border-radius-md" href="{{ route('dashboard.profile') }}">
                <div class="d-flex py-1">
                  <i class="fa fa-id-card me-2"></i>
                  <span>{{__('auth.Profile')}}</span>
                </div>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item border-radius-md" href="{{ route('dashboard.logout') }}">
                <div class="d-flex py-1">
                  <i class="fa fa-sign-out-alt me-2"></i>
                  <span>{{__('auth.Logout')}}</span>
                </div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
