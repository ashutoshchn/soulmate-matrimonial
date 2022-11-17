<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Basic Information')}}</h5>
    </div>
    <div class="card-body">

        <form action="{{ route('member.basic_info_update_new', $member->id) }}" id="regForm-3" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="first_name" >{{translate('First Name')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="first_name" value="{{ $member->first_name }}" class="form-control" placeholder="{{translate('First Name')}}" required>
                    @error('first_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Last Name')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="last_name" value="{{ $member->last_name }}" class="form-control" placeholder="{{translate('Last Name')}}" required>
                    @error('last_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Gender')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" name="gender" required>
                        <option value="">{{translate('Select One')}}</option>

                        <option value="1" @if($member->member->gender ==  1) selected @endif >{{translate('Male')}}</option>
                        <option value="2" @if($member->member->gender ==  2) selected @endif >{{translate('Female')}}</option>
                        @error('gender')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Date Of Birth')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="aiz-date-range form-control" name="date_of_birth"  value="@if(!empty($member->member->birthday)) {{date('Y-m-d', strtotime($member->member->birthday))}} @endif" placeholder="Select Date" data-single="true" data-show-dropdown="true">
                    @error('date_of_birth')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Phone Number')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="phone" value="{{ $member->phone }}" class="form-control" placeholder="{{translate('Phone')}}" readonly>
                    @error('phone')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            <!-- </div>
            <div class="form-group row"> -->
                <div class="col-md-6">
                    <label for="marital_status" >{{translate('Marital Status')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" name="marital_status" data-live-search="true" required>
                        <option value="">{{translate('Select One')}}</option>

                        @foreach ($marital_statuses as $marital_status)
                            <option value="{{$marital_status->id}}" @if($member->member->marital_status_id == $marital_status->id) selected @endif>{{$marital_status->name}}</option>
                        @endforeach
                    </select>
                    @error('marital_status')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- <div class="col-md-6">
                    <label for="first_name" >{{translate('Number Of Children')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="children" value="{{ $member->member->children }}" class="form-control" placeholder="{{translate('Number Of Children')}}" >
                </div> -->
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="photo" >{{translate('Photo')}} <small>(800x800)</small> <small>Accepted file types: jpg, jpeg, png, svg, webp, gif</small></label>
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                        <input type="hidden" name="photo" class="selected-files" value="{{ $member->photo }}">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">Please upload your profile photo here. Please refer to <a href="/faq" target="_blank">FAQ</a> on how to upload your profile photo.</div>
                <!-- <div class="col-md-3 text-right">
                    <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
                </div> -->
            </div>

        </form>
    </div>
</div>
