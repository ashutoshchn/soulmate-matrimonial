@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <form class="" id="download" action="{{ route('download_members_data') }}" method="GET">
                <button class="btn btn-success" >{{translate('Download Members Data')}}</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function download(){
    }
</script>
@endsection
