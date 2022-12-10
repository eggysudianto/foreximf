@extends('layouts.app_admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Member</h1>
    @php
    echo Session::get('pesan');
    @endphp
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div style="text-align: center; margin-bottom: 10px;">
                <a href="{{ route('tree_view') }}" class="btn btn-info">Member TreeView</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Member</th>
                            <th>ID Parent</th>
                            <th>Nama Parent</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nama Member</th>
                            <th>ID Parent</th>
                            <th>Nama Parent</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    	@if($member != NULL)
                    		@foreach($member as $data)	
                    			<tr>
                    				<td>{{ $data->member_id }}</td>
                    				<td>{{ $data->nama_member }}</td>
                                    <td>
                                        @if($data->parent_id!=0)
                                            {{ $data->parent_id }}
                                        @endif
                                    </td>
                                    <td>{{ $data->nama_parent }}</td>
                    				<td>{{ $data->status }}</td>
                    			</tr>
                            </div>
                    		@endforeach
                    	@endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection