<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Yoga Photo</title>
    @include('cadre.includes.header')
    <script
        src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
    <style>
        .upload-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .upload-card>.card-header {
            background: linear-gradient(135deg, #1a3c2e 0%, #14532d 60%, #1a6b3c 100%);
            color: #fff;
            padding: 14px 20px;
            border-bottom: none;
        }

        .upload-card>.card-header h5 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
        }

        .venue-info-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
        }

        .venue-info-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #6c757d;
        }

        .venue-info-value {
            font-size: 14px;
            font-weight: 600;
            color: #212529;
            margin-top: 2px;
        }

        .photo-preview-wrap {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            border: 2px dashed #ced4da;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            background: #f8f9fa;
            position: relative;
        }

        #photoPreview {
            max-width: 100%;
            max-height: 280px;
            border-radius: 8px;
            display: none;
        }

        .upload-placeholder {
            color: #adb5bd;
            font-size: 13px;
            padding: 30px 0;
        }

        .upload-placeholder i {
            font-size: 40px;
            display: block;
            margin-bottom: 8px;
        }

        .current-photo-wrap img {
            max-width: 100%;
            max-height: 280px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('cadre.includes.navbar')
        @include('cadre.includes.sidebar')

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Upload Yoga Photo</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('cadre.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Upload Yoga Photo</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if(!$venue)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            No venue has been assigned to you yet. Please contact your Block office.
                        </div>
                    @else

                        {{-- Venue Info --}}
                        <div class="card venue-info-card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                        <div class="venue-info-label">Cadre</div>
                                        <div class="venue-info-value">{{ $memberName ?? auth()->user()->name }}</div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                        <div class="venue-info-label">Venue Name</div>
                                        <div class="venue-info-value">{{ $venue->venue_name }}</div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                                        <div class="venue-info-label">Village</div>
                                        <div class="venue-info-value">{{ optional($venue->village)->vill_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="venue-info-label">Capacity</div>
                                        <div class="venue-info-value">{{ $venue->capacity }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            @if(!$venue || !$venue->photo)
                                {{-- Upload Form — shown only when no photo exists --}}
                                <div class="col-md-6 mb-4">
                                    <div class="card upload-card">
                                        <div class="card-header">
                                            <h5><i class="fas fa-camera mr-2"></i>Upload Yoga Photo</h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted" style="font-size:13px">
                                                Take or upload a clear photo of the Yoga in the Venue as proof of evidence.
                                                Accepted formats: JPG, PNG, HEIC (max 10 MB).
                                            </p>

                                            <form action="{{ route('cadre.upload.venue.photo.store') }}" method="POST"
                                                enctype="multipart/form-data" id="uploadForm">
                                                @csrf

                                                <div class="form-group">
                                                    <label class="font-weight-bold">
                                                        <i class="fas fa-image mr-1 text-success"></i> Select Photo
                                                    </label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="custom-file-input @error('photo') is-invalid @enderror"
                                                            id="photoInput" name="photo" accept=".jpg,.jpeg,.png,.heic,.heif">
                                                        <label class="custom-file-label" for="photoInput">Choose file...</label>
                                                        @error('photo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="photo-preview-wrap" id="previewWrap">
                                                        <div class="upload-placeholder" id="uploadPlaceholder">
                                                            <i class="fas fa-image"></i>
                                                            Photo preview will appear here
                                                        </div>
                                                        <img id="photoPreview" src="" alt="Preview">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-success btn-block" id="submitBtn" disabled>
                                                    <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Photo
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @else
                                {{-- Current Photo — shown only when a photo exists --}}
                                <div class="col-md-6 mb-4">
                                    <div class="card upload-card">
                                        <div class="card-header">
                                            <h5><i class="fas fa-eye mr-2"></i>Current Yoga Photo</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="mb-2">
                                                <span class="badge badge-success px-3 py-2" style="font-size:13px">
                                                    <i class="fas fa-check-circle mr-1"></i> Photo Uploaded
                                                </span>
                                            </div>
                                            <div class="current-photo-wrap">
                                                <img src="{{ Storage::disk('s3')->temporaryUrl($venue->photo, now()->addMinutes(30)) }}"
                                                    alt="Venue Photo">
                                            </div>
                                            <form action="{{ route('cadre.delete.venue.photo') }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mt-2">
                                                    <i class="fas fa-trash mr-1"></i> Delete Photo
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif

                </div>
            </section>

        </div>

        @include('cadre.includes.footer')

    </div>

    <script>
        $(document).ready(function () {

            $('#photoInput').on('change', async function () {
                let file = this.files[0];
                if (!file) return;

                const input = this;
                const ext = file.name.split('.').pop().toLowerCase();

                $(this).next('.custom-file-label').text(file.name);
                $('#heicNote, #compressionInfo').remove();

                if (['heic', 'heif'].includes(ext)) {
                    $('#uploadPlaceholder').html(
                        '<i class="fas fa-info-circle"></i><br>HEIC preview not supported in browser.<br>' +
                        '<small>File selected: ' + file.name + '</small>'
                    ).show();
                    $('#photoPreview').hide();
                    $('#submitBtn').prop('disabled', false);
                    return;
                }

                // Show compressing spinner
                $('#uploadPlaceholder').html(
                    '<i class="fas fa-spinner fa-spin" style="font-size:36px"></i><br><small class="mt-2 d-block">Compressing image…</small>'
                ).show();
                $('#photoPreview').hide();
                $('#submitBtn').prop('disabled', true);

                try {
                    const originalMB = (file.size / 1024 / 1024).toFixed(2);

                    const compressed = await imageCompression(file, {
                        maxSizeMB: 1,
                        maxWidthOrHeight: 1920,
                        useWebWorker: true,
                    });

                    const compressedMB = (compressed.size / 1024 / 1024).toFixed(2);

                    // Replace file in the input so the form submits the compressed version
                    const dt = new DataTransfer();
                    dt.items.add(new File([compressed], file.name, { type: compressed.type }));
                    input.files = dt.files;

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#uploadPlaceholder').hide();
                        $('#photoPreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(compressed);

                    // Show compression result badge
                    const saved = Math.round((1 - compressed.size / file.size) * 100);
                    $('#previewWrap').after(
                        '<div id="compressionInfo" class="text-center mt-2">' +
                        '<small class="text-success">' +
                        '<i class="fas fa-compress-arrows-alt mr-1"></i>' +
                        originalMB + ' MB → ' + compressedMB + ' MB' +
                        ' <span class="badge badge-success">' + saved + '% saved</span>' +
                        '</small></div>'
                    );

                } catch (err) {
                    console.error('Compression error:', err);
                    // Fall back to original file on error
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#uploadPlaceholder').hide();
                        $('#photoPreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                }

                $('#submitBtn').prop('disabled', false);
            });

        });
    </script>

</body>

</html>