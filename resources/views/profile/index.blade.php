@extends('master')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/profile.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="col">
            <div class="row">
                <div class="col mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="e-profile">
                                <div class="row">
                                    <div class="col-12 col-sm-auto mb-3">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                            class="rounded-circle" width="150">
                                    </div>
                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                            <h4 class="pt-sm-2 pb-1 mb-0 text-start p-1">{{ Auth::user()->usr_username }}
                                            </h4>
                                            <p class="mb-0 text-start p-1">{{ Auth::user()->usr_email }}</p>
                                        </div>
                                        <div class="text-center text-sm-right">
                                            <span class="badge badge-secondary">Ad</span>
                                            <div class="text-muted"><small>Joined
                                                    {{ Auth::user()->created_at->format('d. M. Y') }}</small></div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs mt-3">
                                    <li class="nav-item">
                                        <a href="#profile-tab" class="active nav-link" data-bs-toggle="tab">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#settings-tab" class=" nav-link" data-bs-toggle="tab">Settings</a>
                                    </li>
                                </ul>
                                <div class="tab-content pt-3">
                                    <!-- Profile Tab -->
                                    <div class="tab-pane active" id="profile-tab">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <table class="table user-view-table m-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>Registered:</td>
                                                            <td>{{ Auth::user()->created_at->format('d/m/Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Last seen:
                                                            </td>
                                                            <td>
                                                                {{-- @if (Auth::user()->last_active_at)
                                                                    
                                                                        {{ Auth::user()->last_active_at}}
                                                                    
                                                                @else
                                                                    --
                                                                @endif --}}
                                                                ---
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Verified:</td>
                                                            <td>
                                                                @if (Auth::user()->email_verified)
                                                                    Verified
                                                                @else
                                                                    Unverified
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Role:</td>
                                                            <td>{{ Auth::user()->usr_nama }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Status:</td>
                                                            <td>
                                                                @if (Auth::user()->usr_stat == 1)
                                                                    Active
                                                                @else
                                                                    Inactive
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Settings Tab -->
                                    <div class="tab-pane" id="settings-tab">
                                        <form class="form" method="POST" action="{{ route('update_profile') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Nama</label>
                                                                <input class="form-control" type="text" name="usr_nama"
                                                                    value="{{ Auth::user()->usr_nama }}">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input class="form-control" type="text"
                                                                    name="usr_username"
                                                                    value="{{ Auth::user()->usr_username }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input class="form-control" type="email" name="usr_email"
                                                                    value="{{ Auth::user()->usr_email }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-12 col-md-3 mb-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="px-xl-3">
                                <button class="btn btn-block btn-secondary">
                                    <i class="fa fa-sign-out"></i>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endsection
