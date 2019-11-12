@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                {{__('Projekt')}}  "{{$project->name}}" {{__('bearbeiten')}}
            </h5>
        </div>

        <div class="card-body">
            <form action="{{url("/projects/$project->id")}}" method="post" class="form form-horizontal" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>{{__('Name des Projekts')}}</label>
                            <input type="text" class="form-control border-input"  name="name" value="{{ old('name', $project->name)}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('Projektbeschreibung')}}</label>
                            <textarea class="form-control border-input" name="description">
                            {{old('description', $project->description)}}
                        </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">
                                            {{__('Projektbild')}}
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                                <input type="file"  name="files" id="customFile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                            {{__('Projekt speichern')}}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@push('css')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>

    <script src="{{asset('js/plugins/tinymce/jquery.tinymce.min.js')}}"></script>
    <script src="{{asset('js/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('js/plugins/tinymce/langs/de.js')}}"></script>
    <script>tinymce.init({
            selector: 'textarea',
            lang:'de',
            height: 500,
            menubar: true,
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | ',
        });</script>



    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
        wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
        This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for
        HTML files. This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- popper.min.js below is needed if you use bootstrap 4.x (for popover and tooltips). You can also use the bootstrap js
       3.3.x versions without popper.min.js. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/fileinput.min.js"></script>
    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/fas/theme.min.js"></script>

    <script>
        // initialize with defaults

        $("#customFile").fileinput({
            'showUpload':false,
            'previewFileType':'any',
            maxFileSize: @if(auth()->user()->can('upload great files')) 300000 @else 3000 @endif ,
            'theme': "fas",
        });
    </script>


@endpush