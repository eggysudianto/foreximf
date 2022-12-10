@extends('layouts.app_admin')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    ::placeholder {
       text-align: center; 
    }

    /* or, for legacy browsers */

    ::-webkit-input-placeholder {
       text-align: center;
    }

    :-moz-placeholder { /* Firefox 18- */
       text-align: center;  
    }

    ::-moz-placeholder {  /* Firefox 19+ */
       text-align: center;  
    }

    :-ms-input-placeholder {  
       text-align: center; 
    }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Panel</h1>
    @php
    echo Session::get('pesan');
    @endphp
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div style="text-align: center; margin-bottom: 10px;">
                <a href="{{ route('tree_view') }}" class="btn btn-info">Member TreeView</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    Perhitungan Bonus
                </div>
                <div class="col-md-3">
                    <select name="select_member_hitung" id="select_member_hitung" class="select2" required onchange="getLevel(this.value)">
                        <option value="-">Select Member ID</option>
                        @if($member != NULL)
                            @foreach($member as $data)   
                                <option value="{{ $data->member_id }}">{{ $data->member_id." - ".$data->nama_member }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="select_level" id="select_level" class="select2" required>
                        <option value='-'>Pilih Level</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="button" class="btn btn-primary" style="width: 100%" value="Calculate = " onclick="calculate()">
                </div>
                <div class="col-md-3">
                    <input type="text" id="hasil_calculate" placeholder="$$$" readonly disabled>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    Registrasi ID Member Baru
                </div>
                <div class="col-md-3">
                    <input type="text" name="inisial_member_baru" id="inisial_member_baru" placeholder="Inisial Member Baru" class="form-control">
                </div>
                <div class="col-md-3">
                    <select name="select_parent_member_baru" id="select_parent_member_baru" class="select2" required>
                        <option value='-'>Pilih Parent</option>
                        <option value='tanpaparent'>Tanpa Parent</option>
                        @if($member != NULL)
                            @foreach($member as $data)   
                                <option value="{{ $data->member_id }}">{{ $data->member_id." - ".$data->nama_member }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="button" class="btn btn-primary" style="width: 100%" value="Register" onclick="register()">
                </div>
                <div class="col-md-3">
                    <input type="text" id="member_id_baru" placeholder="Member ID" readonly disabled>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    Migrasi member / Pindah parent
                </div>
                <div class="col-md-3">
                    <select name="select_member_migrasi" id="select_member_migrasi" class="select2" required onchange="getParent(this.value)">
                        <option value="-">Select Member ID</option>
                        @if($member != NULL)
                            @foreach($member as $data)   
                                <option value="{{ $data->member_id }}">{{ $data->member_id." - ".$data->nama_member }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="select_parent_migrasi" id="select_parent_migrasi" class="select2" required>
                        <option value='-'>Pilih Parent</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="button" class="btn btn-primary" style="width: 100%" value="Migrate" onclick="migrate()">
                </div>
                <div class="col-md-3">
                    <input type="text" id="member_id_baru_migrate" placeholder="New Member ID" readonly disabled>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $(document).ready(function() {
       $('.select2').select2({ width: '100%' });
    });

    function getLevel(id_member){
        $.ajax({
            url     : "{{ route('get_recursive_child') }}",
            type : 'post',
            dataType    : 'json',
            data :{
                id_member : id_member,
                status : "getlevel"
            },
            success: function(data){
                if(data.code==1){   
                    $("#select_level").find('option').remove().end();
                    $("#select_level").append('<option value="-">Pilih Level</option>');
                    $.each(data.data, function(i, field){
                        $("#select_level").append('<option value=' + field.LEVEL + '>' + field.LEVEL + '</option>');
                    });
                }else{
                    alert("error");
                }
            },
            error: function(msg, status, obj){
                console.log("Failure");
            }
        });
    }

    function calculate(){
        var id_member = $("#select_member_hitung").val();
        var level = $("#select_level").val();

        if(id_member=="-"){
            alert("Silakan pilih Member ID");
        }else if(level=="-"){
            alert("Silakan pilih level");
        }else{
            $.ajax({
                url     : "{{ route('get_recursive_child') }}",
                type : 'post',
                dataType    : 'json',
                data :{
                    id_member : id_member,
                    level : level,
                    status : "calculate"
                },
                success: function(data){
                    if(data.code==1){   
                        $("#hasil_calculate").val("$"+data.data[0].jumlah);
                    }else{
                        alert("Tidak memiliki downline");
                    }
                },
                error: function(msg, status, obj){
                    console.log("Failure");
                }
            });
        }
    }

    function register(){
        var inisial_member_baru = $("#inisial_member_baru").val();
        var parent = $("#select_parent_member_baru").val();

        if(inisial_member_baru==null){
            alert("Silakan masukkan inisial member baru");
        }else if(parent=="-"){
            alert("Silakan pilih parent");
        }else{
            $.ajax({
                url     : "{{ route('register_member_baru') }}",
                type : 'post',
                dataType    : 'json',
                data :{
                    inisial_member_baru : inisial_member_baru,
                    parent : parent,
                },
                success: function(data){
                    $("#member_id_baru").val(data);
                },
                error: function(msg, status, obj){
                    console.log("Failure");
                }
            });
        }
    }

    function getParent(id_member){
        $.ajax({
            url     : "{{ route('get_parent') }}",
            type : 'post',
            dataType    : 'json',
            data :{
                id_member : id_member,
            },
            success: function(data){
                if(data.code==1){   
                    $("#select_parent_migrasi").find('option').remove().end();
                    $("#select_parent_migrasi").append('<option value="-">Pilih Level</option>');
                    $("#select_parent_migrasi").append('<option value="tanpaparent">Tanpa Parent</option>');
                    $.each(data.data, function(i, field){
                        $("#select_parent_migrasi").append('<option value=' + field.id + '>' + field.id + ' - ' + field.nama + '</option>');
                    });
                }else{
                    alert("error");
                }
            },
            error: function(msg, status, obj){
                console.log("Failure");
            }
        });
    }

    function migrate(){
        var select_member_migrasi = $("#select_member_migrasi").val();
        var select_parent_migrasi = $("#select_parent_migrasi").val();        

        $.ajax({
            url     : "{{ route('migrasi') }}",
            type : 'post',
            dataType    : 'json',
            data :{
                select_member_migrasi : select_member_migrasi,
                select_parent_migrasi : select_parent_migrasi,
            },
            success: function(data){
                $("#member_id_baru_migrate").val(data);
            },
            error: function(msg, status, obj){
                console.log("Failure");
            }
        });
    }
</script>
@endsection