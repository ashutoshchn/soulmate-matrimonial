<form action="{{ route('career.done_new')}}" method="POST"  id="regForm-8">
@csrf
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Career Info')}}</h5>
        <div class="text-right">
            <a onclick="career_add_modal_new('{{$member->id}}');"  href="javascript:void(0);" class="btn btn-sm btn-primary ">
              <i class="las mr-1 la-plus"></i>
              {{translate('Add New')}}
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table aiz-table">
          <tr>
              <th>{{translate('Designation')}}</th>
              <th>{{translate('Company Name')}}</th>
              <!-- <th data-breakpoints="md">{{translate('Start')}}</th>
              <th data-breakpoints="md">{{translate('End')}}</th> -->
              <!-- <th data-breakpoints="md">{{translate('Status')}}</th> -->
              <th class="text-right">{{translate('Options')}}</th>
          </tr>

          @php $careers = \App\Models\Career::where('user_id',$member->id)->get(); @endphp
          @foreach ($careers as $key => $career)
          <tr>
              <td>{{ $career->designation }}</td>
              <td>{{ $career->company }}</td>
              <!-- <td>{{ $career->start }}</td>
              <td>{{ $career->end }}</td> -->
              <!-- <td>
                  <label class="aiz-switch aiz-switch-success mb-0">
                      <input type="checkbox" id="status.{{ $key }}" onchange="update_career_present_status(this)" value="{{ $career->id }}" @if($career->present == 1) checked @endif data-switch="success"/>
                      <span></span>
                  </label>
              </td> -->
              <td class="text-right">
                  <a href="javascript:void(0);" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="career_edit_modal_new('{{$career->id}}');" title="{{ translate('Edit') }}">
                      <i class="las la-edit"></i>
                  </a>
                  <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('career.destroy', $career->id)}}" title="{{ translate('Delete') }}">
                      <i class="las la-trash"></i>
                  </a>
              </td>
          </tr>
          @endforeach

        </table>

    </div>
</div>
</form>