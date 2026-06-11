<footer class="main-footer">

    <div class="container">

        <div class="row align-items-center text-center text-lg-start">

            <div class="col-lg-8 mb-3 mb-lg-0">

                <h5 class="footer-title">
                    🧘 International Yoga Day 2026
                </h5>

                <p class="footer-text mb-0">
                    &copy; {{ date('Y') }} Assam State Rural Livelihoods Mission (ASRLM) |
                    Promoting Wellness, Peace &amp; Healthy Living Through Yoga
                </p>

            </div>

            <div class="col-lg-4 text-lg-end">

                <div class="footer-badge">

                    Designed with Peace & Positivity 💚

                </div>

            </div>

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

    $(document).ready(function () {

        $('.select2').select2({

            theme: 'bootstrap-5',

            width: '100%',

            placeholder: '-- Select SHG --',

            allowClear: true

        });

        // =========================
        // DISTRICT -> BLOCK
        // =========================

        $('#district').on('change', function () {

            let district_id = $(this).val();

            $('#block').html('<option value="">Loading...</option>');

            $('#gp').html('<option value="">-- Select GP --</option>');

            $('#village').html('<option value="">-- Select Village --</option>');

            $('#shg').html('<option value="">-- Select SHG --</option>');

            $('#memberTableDiv').html('');

            $.ajax({

                url: '/get-blocks/' + district_id,

                type: 'GET',

                success: function (data) {

                    let options = '<option value="">-- Select Block --</option>';

                    $.each(data, function (key, item) {

                        options += `
                            <option value="${item.block_id}">
                                ${item.block_name}
                            </option>
                        `;
                    });

                    $('#block').html(options);

                }

            });

        });

        // =========================
        // BLOCK -> GP
        // =========================

        $('#block').on('change', function () {

            let block_id = $(this).val();

            $('#gp').html('<option value="">Loading...</option>');

            $('#village').html('<option value="">-- Select Village --</option>');

            $('#shg').html('<option value="">-- Select SHG --</option>');

            $('#memberTableDiv').html('');

            $.ajax({

                url: '/get-gps/' + block_id,

                type: 'GET',

                success: function (data) {

                    let options = '<option value="">-- Select GP --</option>';

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

        });

        // =========================
        // GP -> VILLAGE
        // =========================

        $('#gp').on('change', function () {

            let gp_id = $(this).val();

            $('#village').html('<option value="">Loading...</option>');

            $('#shg').html('<option value="">-- Select SHG --</option>');

            $('#memberTableDiv').html('');

            $.ajax({

                url: '/get-villages/' + gp_id,

                type: 'GET',

                success: function (data) {

                    let options = '<option value="">-- Select Village --</option>';

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

        // =========================
        // VILLAGE -> SHG
        // =========================

        $('#village').on('change', function () {

            let vill_id = $(this).val();

            $('#shg').html('<option value="">Loading...</option>');

            $('#memberTableDiv').html('');

            $.ajax({

                url: '/get-shgs/' + vill_id,

                type: 'GET',

                success: function (data) {

                    let options = '<option value="">-- Select SHG --</option>';

                    $.each(data, function (key, item) {

                        options += `
                            <option value="${item.shg_code}">
                                ${item.shg_name} (${item.shg_code})
                            </option>
                        `;
                    });

                    $('#shg').html(options);

                }

            });

        });

        // =========================
        // SHG -> MEMBERS
        // =========================

        $('#shg').on('change', function () {

            let shg_code = $(this).val();

            $('#memberTableDiv').html(`
                <div class="text-center mt-4">
                    <strong>Loading Members...</strong>
                </div>
            `);

            $.ajax({

                url: '/get-members/' + shg_code,

                type: 'GET',

                success: function (data) {

                    let html = `
                    
                    <div class="table-responsive mt-5">

                        <table class="table table-bordered table-hover align-middle">

                            <thead>

                                <tr>

                                    <th width="10%">
                                        Sl.No
                                    </th>

                                    <th>
                                        Member Name
                                    </th>

                                    <th width="20%">
                                        Action
                                    </th>

                                </tr>

                            </thead>

                            <tbody>
                    `;

                    $.each(data, function (index, member) {

                        let actionBtn = '';

                        if (member.yoga2026_registration == '1') {

                            actionBtn = `
                                <span class="btn btn-success btn-sm">
                                    🧘 Registered
                                </span>
                            `;

                        } else {

                            actionBtn = `
                            
                            <button type="button"
                                class="btn btn-primary btn-sm registerBtn"
                              
                                data-memuid="${member.mem_uid}">

                                🧘 Register Now

                            </button>
                            `;
                        }

                        html += `
                        
                        <tr>

                            <td>
                                ${index + 1}
                            </td>

                            <td>

                                ${member.mem_name}
                                (${member.mem_code})

                            </td>

                            <td>

                                ${actionBtn}

                            </td>

                        </tr> 
                        
                        `;
                    });

                    html += `
                            </tbody>

                        </table>

                    </div>
                    `;

                    $('#memberTableDiv').html(html);

                },

                error: function () {

                    $('#memberTableDiv').html(`
                        <div class="alert alert-danger mt-4">
                            Failed to load members.
                        </div>
                    `);

                }

            });

        });



    });




    $(document).on('click', '.registerBtn', function () {

        let mem_uid = $(this).data('memuid');

        $.ajax({

            url: '/get-member-details/' + mem_uid,

            type: 'GET',

            beforeSend: function () {

                $.blockUI({

                    message: `
                        <div class="text-white">

                            <div class="spinner-border text-light mb-2"></div>

                            <br>

                            Loading Member Details...

                        </div>
                    `,

                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },

                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.6,
                        cursor: 'wait'
                    }

                });

            },

            success: function (member) {

                $('#member_name').text(member.mem_name);

                $('#member_code').text(member.mem_code);

                $('#shg_name').text(
                    member.shg_name + ' (' + member.shg_code + ')'
                );

                $('#guardian_name').text(member.guardian_name);

                $('#village_name').text(member.vill_name);

                $('#gp_name').text(member.gp_name);

                $('#block_name').text(member.block_name);

                $('#district_name').text(member.district_name);

                $('#confirmRegistrationBtn').attr(
                    'href',
                    '/yoga/registration/' + member.mem_uid
                );

                // OPEN MODAL AFTER DATA LOAD

                $('#yogaModal').modal('show');

            },

            complete: function () {

                $.unblockUI();

            },

            error: function () {

                $.unblockUI();

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: 'Unable to load member details.'

                });

            }

        });

    });




</script>
</body>

</html>