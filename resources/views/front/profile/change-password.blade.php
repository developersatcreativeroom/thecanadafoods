@extends('front.layouts.app')

@section('content')



<!--my account section-->
<section class="my-account pt-6 pb-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-3">
                @include('front.profile.side')
            </div>
            <div class="col-xl-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active">

                        <div class="change-password bg-white py-5 px-4 mt-4 rounded">
                            <h6 class="mb-4">Change Password</h6>
                            <form class="password-reset-form" action="{{ route('change.password') }}" method="post"
                                enctype='multipart/form-data'>
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row g-4">
                                            <div class="col-sm-12">
                                                <div class="label-input-field">
                                                    <label>Old Password <span class="required">*</span></label>
                                                    <input
                                                        class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}"
                                                        name="old_password" type="password">
                                                    @if($errors->has('old_password'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('old_password') }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="label-input-field">
                                                    <label>New Password <span class="required">*</span></label>
                                                    <input
                                                        class="form-control square {{ $errors->has('new_password') ? ' is-invalid' : '' }}"
                                                        name="new_password" type="password">
                                                    @if($errors->has('new_password'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('new_password') }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="label-input-field">
                                                    <label>Confirm Password <span class="required">*</span></label>
                                                    <input
                                                        class="form-control square {{ $errors->has('confirm_password') ? ' is-invalid' : '' }}"
                                                        name="confirm_password" type="password">
                                                    @if($errors->has('confirm_password'))
                                                    <div class="invalid-feedback">
                                                        <div>{{ $errors->first('confirm_password') }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-6">
                                            Change Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>




                    </div>


                </div>
            </div>
        </div>
    </div>
</section>


@endsection


@push('scripts')
{{-- page specific JS goes here --}}


@endpush