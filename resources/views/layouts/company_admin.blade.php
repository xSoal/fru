<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico" type="image/svg+xml">

    <meta name="description" content="{{ $meta_decs ?? '' }}">
    
    <link rel="canonical" href="{{ Request::url() }}" />


    <link rel="apple-touch-icon" sizes="180x180" href='/images/favicons/apple-touch-icon.png'>
    <link rel="icon" type="image/png" sizes="32x32" href='/images/favicons/favicon-32x32.png'>
    <link rel="icon" type="image/png" sizes="16x16" href='/images/favicons/favicon-16x16.png'>
    
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"> --}}
    
    {{-- <script src="https://kit.fontawesome.com/5370645651.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="{{asset('js/jquery-ui-1.13.1/jquery-ui.css')}}">
    
    <script src="{{ asset('/js/all.min.js') }}"></script>

    {{-- <link rel="stylesheet" href="{{ asset('/style/css/old_styles.css') }}"> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/style/css/adminClientsCompany.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $meta_title  ?? ''}}</title>
</head>
<body class="site helix-ultimate hu com_sppagebuilder com-sppagebuilder view-page layout-default task-none itemid-101 uk-ua ltr sticky-header layout-fluid offcanvas-init offcanvs-position-right">
    
    @if( count($errors) > 0 )
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if( session('status') )
        <div class="session_stat">
            {{ session('status') }}
        </div>
    @endif


    <div class="body-wrapper">
        <div class="body-innerwrapper">
            <div class="headerTop">
                <div class="headerLogo">
                    <a href="/">
                        <img src="/images/logo.svg" alt="Logo">
                    </a>
                </div>
                <div class="buttonExit">
                    @if(Auth::user()->role !== 3)
                    <button class="logout-link neo-accent-btn settings-button">
                        settings
                    </button>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @if(Auth::user()->role === 3)
                            <a href="/admin" class="back_to_admin logout-link">
                                to admin
                            </a>
                        @endif
                        @csrf

                        <button type="submit" class="logout-link neo-accent-btn  ">
                            exit
                        </button>

                    </form>
                </div>
            </div>
            @if(!Auth::user()->role !== 3)
            <div id="my-modal" title="Accounts user data">
                <form action="{{ Auth::user()->role === 1 ? 
                    route('admin.companyUpdateUserData', ['userId' => Auth::user()->id])
                    : route('admin.clientUpdateUserData', ['userId' => Auth::user()->id]) }}"
                    method="POST" style="display: inline;" 
                >
                    <input type="password" autocomplete="new-password" name="fake_pass" style="display:none;">
            
                    @csrf
                    <div class="header header_modal_message">Data successfully updated</div>
                    {{-- <div class="form_field name">
                        <div class="errors"></div>
                        <p>
                            Company name
                        </p>
                        <p>
                            <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}">
                        </p>
                    </div> --}}
                    <div class="form_field description">
                        <p>
                            Company description
                        </p>
                        <div class="errors"></div>
                        <p>
                            <input type="text" name="description" value="{{ Auth::user()->description ?? '' }}">
                        </p>
                    </div>
                    <div class="form_field phone">
                        <p>
                            Phone
                        </p>
                        <div class="errors"></div>
                        <p>
                            <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                        </p>
                    </div>
                    <div class="form_field email">
                        <p>
                            Email
                        </p>
                        <div class="errors"></div>
                        <p>
                            <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}">
                        </p>
                    </div>
                    <div class="form_field web_page">
                        <p>
                            Web page url
                        </p>
                        <div class="errors"></div>
                        <p>
                            <input type="text" name="web_page" value="{{ Auth::user()->web_page ?? '' }}">
                        </p>
                    </div>
                    <div class="form_field contact_person">
                        <p>
                            Contact person
                        </p>
                        <div class="errors"></div>
                        <p>
                            <input type="text" name="contact_person" value="{{ Auth::user()->contact_person ?? '' }}">
                        </p>
                    </div>
                    <div class="form_field password new_password new_password_confirm">
                        <p>Password change</p>
                        <div class="errors"></div>
                        <p>
                            Old password:
                        </p>
                        <p>
                            <input type="password" name="password">
                        </p>
                        <p>
                            New password:
                        </p>
                        <p>
                            <input type="password" name="new_password">
                        </p>
                        <p>
                            New password confirm:
                        </p>
                        <p>
                            <input type="password" name="new_password_confirm">
                        </p>
                    </div>
                    <div>
                        <button class="save_form_settings" type="submit">Save</button>
                    </div>
                </form>
            </div>
            @endif
            @yield('content')

        </div>
    </div>

    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui-1.13.1/jquery-ui.js')}}"></script>
    <script src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
    <script type="module" src="{{ asset('/js/CompanyClientsAdmin.js') }}"></script>
</body>
</html>