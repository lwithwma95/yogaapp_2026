<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Registrations by SHG</title>

    @include('block.includes.header')
</head>

<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('block.includes.navbar')

        @include('block.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Registrations by SHG</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('block.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">View Registrations by SHG</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <section class="content">

                <div class="container-fluid">

                    <div class="card card-dark">

                        <div class="card-header">

                            <h3 class="card-title">
                                Select GP/VCDC->Village->SHG
                            </h3>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                {{-- GP --}}

                                <div class="col-md-4">

                                    <label>
                                        GP / VCDC
                                    </label>

                                    <select class="form-control select2ajax" id="gp">

                                        <option value="">
                                            -- Select GP --
                                        </option>

                                    </select>

                                </div>

                                {{-- VILLAGE --}}

                                <div class="col-md-4">

                                    <label>
                                        Village
                                    </label>

                                    <select class="form-control select2ajax" id="village">

                                        <option value="">
                                            -- Select Village --
                                        </option>

                                    </select>

                                </div>

                                {{-- SHG --}}

                                <div class="col-md-4">

                                    <label>
                                        SHG
                                    </label>

                                    <select class="form-control select2ajax" id="shg">

                                        <option value="">
                                            -- Select SHG --
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- MEMBER TABLE --}}

                    <div id="memberTableDiv">

                    </div>

                </div>

            </section>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('block.includes.footer')
        <script>

            $(document).ready(function () {

                $('.select2ajax').select2({

                    theme: 'classic',
                    width: '100%'

                });

                // LOAD GP OF LOGGED BLOCK

                $.ajax({

                    url: '/get-gps/{{ auth()->user()->block }}',
                    type: 'GET',

                    success: function (data) {

                        let options = `
                    
                    <option value="">
                        -- Select GP --
                    </option>
                    `;

                        $.each(data, function (key, item) {

                            options += `
                        
                        <option value="${item.gp_id}">
                            ${item.gp_name}
                        </option>
                        `;
                        });

                        $('#gp').html(options);

                    }

                });

                // GP -> VILLAGE

                $('#gp').on('change', function () {

                    let gp_id = $(this).val();

                    $('#village').html(`
                
                <option value="">
                    Loading...
                </option>
                `);

                    $('#shg').html(`
                
                <option value="">
                    -- Select SHG --
                </option>
                `);

                    $.ajax({

                        url: '/get-villages/' + gp_id,
                        type: 'GET',

                        success: function (data) {

                            let options = `
                        
                        <option value="">
                            -- Select Village --
                        </option>
                        `;

                            $.each(data, function (key, item) {

                                options += `
                            
                            <option value="${item.vill_id}">
                                ${item.vill_name}
                            </option>
                            `;
                            });

                            $('#village').html(options);

                        }

                    });

                });

                // VILLAGE -> SHG
                $('#village').on('change', function () {
                    let vill_id = $(this).val();
                    $('#shg').html(`
                <option value="">
                    Loading...
                </option>
                `);
                    $.ajax({
                        url: '/get-shgs/' + vill_id,
                        type: 'GET',
                        success: function (data) {

                            let options = `
                        
                        <option value="">
                            -- Select SHG --
                        </option>
                        `;

                            $.each(data, function (key, item) {

                                options += `
                            
                            <option value="${item.shg_code}">
                                ${item.shg_name}
                                (${item.shg_code})
                            </option>
                            `;
                            });

                            $('#shg').html(options);

                        }

                    });

                });

                // SHG -> MEMBERS

                $('#shg').on('change', function () {

                    let shg_code = $(this).val();

                    $('#memberTableDiv').html(`
                
                <div class="text-center mt-4">

                    <div class="spinner-border text-primary">

                    </div>

                    <p class="mt-2">
                        Loading Members...
                    </p>

                </div>
                `);

                    $.ajax({

                        url: '/get-members/' + shg_code,
                        type: 'GET',

                        success: function (data) {

                            let html = '';

                            html += `
                        
                        <div class="card">

                            

                            <div class="card-body table-responsive p-0"
                                style="max-height:600px;">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="sticky-top bg-dark">
                                        <tr>
                                            <th width="10%">
                                                Sl No
                                            </th>
                                            <th>
                                                Member Details
                                            </th>
                                            <th width="20%">
                                                Status
                                            </th>
                                            <th width="20%">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                            $.each(data, function (index, member) {
                                let status = '';

                                if (member.yoga2026_registration == 1) {
                                    status = `
                                <span class="badge badge-success">
                                    Registered
                                </span>
                                `;
                                } else {

                                    status = `
                                
                                <span class="badge badge-danger">

                                    Not Registered

                                </span>
                                `;
                                }

                                html += `
                            
                            <tr>

                                <td>

                                    ${index + 1}

                                </td>

                                <td>

                                    <strong>
                                        ${member.mem_name}
                                    </strong>

                                    (${member.mem_code})

                                </td>

                                <td>

                                    ${status}

                                </td>
                                <td>
                                    ${member.yoga2026_registration == 1? `
                                    <a href="/block/member/${member.mem_uid}" 
                                    class="btn btn-sm btn-success">View Certificate</a>`
                                    : `<span class="badge badge-danger">Not Attended</span>`
                                    }
                                </td>

                            </tr>
                            `;
                            });

                            html += `
                                    
                                    </tbody>

                                </table>

                            </div>

                        </div>
                        `;

                            $('#memberTableDiv').html(html);

                        }

                    });

                });

            });

        </script>
</body>

</html>