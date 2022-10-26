@extends('layouts.admin')

@section('in_content')

    <div class="page-wrapper" style="background: #f2f7f8;">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8" style="padding-left: 0px">
                        <form action="/news" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Заголовок</label>
                                <input  value="{{ old('news_name') }}" type="text" class="form-control" name="news_name" >
                                @if ($errors->has('news_name'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('news_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Категория</label>

                                <select class="custom-select form-control required" name="category_id">
                                    <option value="1" @if(old('category_id') == 1) selected @endif>Общее</option>
                                    <option value="2" @if(old('category_id') == 2) selected @endif>Кабинет</option>
                                </select>

                                @if ($errors->has('category_id'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('category_id') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Текст</label>
                                <textarea  name="news_text" class="form-control">{{ old('news_text') }}</textarea>
                                @if ($errors->has('news_text'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('news_text') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Краткое описание</label>
                                <textarea name="news_desc" class="form-control">{{ old('news_desc') }}</textarea>
                                @if ($errors->has('news_desc'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('news_desc') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="file" name="news_image" class="form-control form-control-line">

                                @if ($errors->has('news_image'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('news_image') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Дата</label>
                                <input  type="date" class="form-control datetimepicker-input" value="{{ old('news_date') }}" name="news_date" >
                                @if ($errors->has('news_date'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('news_date') }}
                                    </div>
                                @endif
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    import Options
        from "../../../public/monster_admin/assets/plugins/select2/docs/_includes/options/core/options.html";
    export default {
        components: {Options}
    }
</script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'image code',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

            // without images_upload_url set, Upload tab won't show up
            images_upload_url: '/upload.php',
            convert_urls: false,
            // override default upload handler to simulate successful upload
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/upload.php');

                xhr.onload = function() {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            },
        });
    </script>
@endpush



