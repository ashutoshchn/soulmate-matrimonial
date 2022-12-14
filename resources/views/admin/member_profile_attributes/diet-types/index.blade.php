@extends('admin.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-4">

    <div class="row align-items-center">

        <div class="col-md-6">

            <h1 class="h3">{{translate('Diet Types')}}</h1> 

        </div>

    </div>

</div>

<div class="row">

    <div class="@if(auth()->user()->can('add_diet_type')) col-lg-7 @else col-lg-12 @endif">

        <div class="card">

            <div class="card-header row gutters-5">

                <div class="col text-center text-md-left">

                    <h5 class="mb-md-0 h6">{{ translate('All Diet Type') }}</h5>

                </div>

                <div class="col-md-4">

                    <form class="" id="sort_diet_type" action="" method="GET">

                        <div class="input-group input-group-sm">

                            <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">

                        </div>

                    </form>

                </div>

            </div>

            <div class="card-body">

                <table class="table aiz-table mb-0">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>{{translate('Name')}}</th>

                            <th class="text-right" width="20%">{{translate('Options')}}</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($diet_types as $key => $diet_type)

                            <tr>

                                <td>{{ ($key+1) + ($diet_types->currentPage() - 1)*$diet_types->perPage() }}</td>

                                <td>{{$diet_type->name}}</td>

                                <td class="text-right">

                                    @can('edit_diet_type')

                                        <a href="javascript:void(0);" onclick="diet_type_modal('{{ route('diet-types.edit', encrypt($diet_type->id)) }}')" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Edit') }}">

                                            <i class="las la-edit"></i>

                                        </a>

                                    @endcan

                                    @can('delete_diet_type')

                                        <a href="javascript:void(0);" data-href="{{route('diet-types.destroy', $diet_type->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">

                                            <i class="las la-trash"></i>

                                        </a>

                                    @endcan

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <div class="aiz-pagination">

                    {{ $diet_types->appends(request()->input())->links() }}

                </div>

            </div>

        </div>

    </div>

    @can('add_diet_type')

    <div class="col-lg-5">

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0 h6">{{translate('Add New Diet Type')}}</h5>

            </div>

            <div class="card-body">

                <form action="{{ route('diet-types.store') }}" method="POST" >

                    @csrf

                    <div class="form-group mb-3">

                        <label for="name">{{translate('Name')}}</label>

                        <input type="text" id="name" name="name" placeholder="{{ translate('Name') }}"

                               class="form-control" required>

                       @error('name')

                           <small class="form-text text-danger">{{ $message }}</small>

                       @enderror

                    </div>

                    <div class="form-group mb-3 text-right">

                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @endcan

</div>

@endsection

@section('modal')

    @include('modals.create_edit_modal')

    @include('modals.delete_modal')

@endsection



@section('script')

<script>

    function sort_diet_type(el){

      $('#sort_diet_type').submit();

    }

    function diet_type_modal(url){

        $.get(url, function(data){

            $('.create_edit_modal_content').html(data);

            $('.create_edit_modal').modal('show');

        });

    }

</script>

@endsection

