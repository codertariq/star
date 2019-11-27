@php
$data['page'] = __('page.user');
$data['route'] = 'admin.user.';
@endphp
<div class="row">
    <div class="col-md-12">
        <h3 class="profile-username">{{$model->full_name}}</h3>
    </div>
    <div class="col-md-6">
        <p><strong>@lang( 'business.email' ): </strong> {{$model->email}}</p>
        <p><strong>@lang( 'user.role' ): </strong> {{$model->role_name}}</p>
        <p><strong>@lang( 'business.username' ): </strong> {{$model->username}}</p>
    </div>
    <div class="col-md-6">
        <p><strong>@lang( 'service.cmmsn_percent' ): </strong> {{$model->cmmsn_percent}}%</p>
        <p><strong>@lang( 'service.status', ['attribute' => $data['page']]):</strong> @if($model->status == 'active') <span class="badge badge-success">@lang('business.is_active')</span> @else <span class="badge badge-danger">@lang('business.inactive')</span> @endif</p>
        <p><strong>@lang( 'service.cmmsn_percent' ): </strong> {{$model->cmmsn_percent}}%</p>
    </div>
    <div class="col-md-12">
        @php
        $selected_contacts = '';
        @endphp
        @if(count($model->contactAccess))
        @php
        $selected_contacts_array = [];
        @endphp
        @foreach($model->contactAccess as $contact)
        @php
        $selected_contacts_array[] = $contact->name;
        @endphp
        @endforeach
        @php
        $selected_contacts = implode(', ', $selected_contacts_array);
        @endphp
        @else
        @php
        $selected_contacts = __('service.all');
        @endphp
        @endif
        <p><strong>@lang( 'service.allowed_contacts' ): </strong> {{$selected_contacts}}</p>
    </div>
</div>
<hr>
@include('admin.user.show_details')
<div class="row text-right">
    <div class="col-md-12">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
    </div>
</div>