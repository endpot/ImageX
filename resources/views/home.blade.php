@extends('layout')

@section('content')
    <div>
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-image"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Images</span>
                        <span class="info-box-number">{{ $summary['total_count'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-eye"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Views</span>
                        <span class="info-box-number">{{ $summary['total_views'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-upload"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">New</span>
                        <span class="info-box-number">{{ $summary['new_image_count'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">UPLOADERS</span>
                        <span class="info-box-number">{{ $summary['uploader_count'] }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <ol class="breadcrumb">
            <li><b>Random Pictures</b></li>
        </ol>

        <div class="row">
            @foreach($images as $image)
                <div class="col-sm-3">
                    <a href="{{ route('showImage', [ 'code' => $image->code, 'name' => $image->name ]) }}" class="thumbnail" data-toggle="lightbox">
                        <img src="{{ route('showImage', [ 'code' => $image->code, 'name' => $image->name ]) }}" alt="{{ $image->name }}">
                    </a>
                </div>
            @endforeach
        </div>
        <!-- /.row -->
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.bootcss.com/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <script src="https://cdn.bootcss.com/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endpush
