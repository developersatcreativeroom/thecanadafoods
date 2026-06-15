@extends('admin.layouts.app')

@section('content')

          <!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Role</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-300 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
										</li>
										<!--end::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">Role</li>
										<!--end::Item-->
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page title-->
								<!--begin::Actions-->
								<div class="d-flex align-items-center py-1">
									<!--begin::Button-->
									<a href="{{route('admin.role.list')}}" class="btn btn-sm btn-primary">List</a>
									<!--end::Button-->
								</div>
								<!--end::Actions-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								<!--begin::Contact-->
								<div class="card">
									<!--begin::Body-->
									<div class="card-body p-lg-17">
										<!--begin::Row-->
										<div class="row mb-3">


                              <!--begin::Col-->
											<div class="col-md-6 pe-lg-10">
												<!--begin::Form-->
												<form class="form mb-15" method="POST" action="{{ url('admin/role-post-data') }}" enctype="multipart/form-data" id="kt_contact_form">
                                       @csrf
													<h1 class="fw-bolder text-dark mb-9">Role Details</h1>
													
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-5 fv-row">
                                          				<!--begin::Label-->
															<label class="fs-5 fw-bold mb-2">Name</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" class="form-control form-control-solid {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="" name="name" value="@if(!empty($role->name)){{$role->name}}@elseif(old('name')!=null){{old('name')}}@endif" />
															<!--end::Input-->
															@if($errors->has('name'))
																<span class="invalid-feedback">
																	{{ $errors->first('name') }}
																</span>
															@endif
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-5 fv-row">
                                          				<!--begin::Label-->
															<label class="fs-5 fw-bold mb-2">Permissions</label>
															<!--end::Label-->
															<!--begin::Input-->
															<div class="my-2">
																<input class="form-check-input" type="checkbox" name="permission[]" value="news" @if(!empty($role->permission) && in_array('news', $role->permission)) checked @endif />
																<label class="form-check-label">
																News
																</label>
															</div>
															
															<div class="my-2">
																<input class="form-check-input" type="checkbox" name="permission[]" value="product" @if(!empty($role->permission) && in_array('product', $role->permission)) checked @endif />
																<label class="form-check-label">
																Product
																</label>
															</div>

															<div class="my-2">
																<input class="form-check-input" type="checkbox" name="permission[]" value="job_opening" @if(!empty($role->permission) && in_array('job_opening', $role->permission)) checked @endif />
																<label class="form-check-label">
																Job Openings
																</label>
															</div>

															<div class="my-2">
																<input class="form-check-input" type="checkbox" name="permission[]" value="banner" @if(!empty($role->permission) && in_array('banner', $role->permission)) checked @endif />
																<label class="form-check-label">
																Banner
																</label>
															</div>

															<div class="my-2">
																<input class="form-check-input" type="checkbox" name="permission[]" value="member" @if(!empty($role->permission) && in_array('member', $role->permission)) checked @endif />
																<label class="form-check-label">
																Member
																</label>
															</div>

															<div class="my-2">
																<input class="form-check-input" type="checkbox" name="permission[]" value="seo" @if(!empty($role->permission) && in_array('seo', $role->permission)) checked @endif />
																<label class="form-check-label">
																SEO
																</label>
															</div>
															
															<div class="my-2">
																<input class="form-check-input" type="checkbox" name="permission[]" value="contact_enquiries" @if(!empty($role->contact_enquiries) && in_array('seo', $role->contact_enquiries)) checked @endif />
																<label class="form-check-label">
																Contact Enquiries
																</label>
															</div>
															
															
															

															<!--end::Input-->
															@if($errors->has('permission'))
																<span class="invalid-feedback">
																	{{ $errors->first('permission') }}
																</span>
															@endif
													</div>
													<!--end::Input group-->
													
													<input type="hidden" name="id" value="@if(!empty($role->id)){{$role->id}}@endif">
													<!--end::Input group-->
													<!--begin::Submit-->
													<button type="submit" class="btn btn-primary" id="kt_contact_submit_button">
														<!--begin::Indicator-->
														<span class="indicator-label">Save</span>
														<span class="indicator-progress">Please wait...
														<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														<!--end::Indicator-->
													</button>
													<!--end::Submit-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Col-->
                              
                                 </div>
                                 <!--end::Row-->
                                 </div>
                                 <!--end::Body-->
                              </div>
                              <!--end::Contact-->
                           </div>
                           <!--end::Container-->
                        </div>
                        <!--end::Post-->
                     </div>
                     <!--end::Content-->
										
                              


@endsection


@push('scripts')
    {{-- page specific JS goes here --}}
    <!-- <script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> -->

	<script>
		CKEDITOR.replace( 'editor' , {
			
		});
	</script>
@endpush



