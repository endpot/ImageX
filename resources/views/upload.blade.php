@extends('layout')

@section('content')
    <div class="">
        <div class="file-loading">
            <input id="image-input" name="image" type="file" accept="image/jpeg, image/png, image/gif" multiple>
        </div>
        <div class="text-left" style="margin: 5px 0;">
            <div class="btn-group btn-group-sm" data-toggle="buttons">
                <label class="btn btn-sm btn-success active btn-sfw">
                    <input type="radio" name="nsfw" id="sfw" autocomplete="off" checked> SFW
                </label>
                <label class="btn btn-sm btn-danger btn-nsfw">
                    <input type="radio" name="nsfw" id="nsfw" autocomplete="off"> NSFW (Not Safe for Work)
                </label>
            </div>
        </div>
    </div>
    <div>
        <ul id="navTab" class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link" href="#urlcodes" data-toggle="tab">URL</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#htmlcodes" data-toggle="tab">HTML</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#bbcodes" data-toggle="tab">BBCode</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#markdowncodes" data-toggle="tab">Markdown</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#markdowncodes2" data-toggle="tab">Markdown with Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#deletepanel" data-toggle="tab">Delete Link</a>
            </li>
        </ul>
        <div id="navTabContent" class="tab-content">
            <div class="tab-pane fade in active text-left" id="urlcodes">
                <pre style="margin-top: 5px;"><code id="urlcode"></code></pre>
            </div>
            <div class="tab-pane fade text-left" id="htmlcodes">
                <pre style="margin-top: 5px;"><code id="htmlcode"></code></pre>
            </div>
            <div class="tab-pane fade text-left" id="bbcodes">
                <pre style="margin-top: 5px;"><code id="bbcode"></code></pre>
            </div>
            <div class="tab-pane fade text-left" id="markdowncodes">
                <pre style="margin-top: 5px;"><code id="markdown"></code></pre>
            </div>
            <div class="tab-pane fade text-left" id="markdowncodes2">
                <pre style="margin-top: 5px;"><code id="markdownlinks"></code></pre>
            </div>
            <div class="tab-pane fade text-left" id="deletepanel">
                <pre style="margin-top: 5px;"><code id="deletecode"></code></pre>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput@5.0.6/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput@5.0.6/themes/fa/theme.min.js"></script>
    <script>
        $(function () {
            $("#image-input").fileinput({
                theme: 'fa',
                uploadUrl: '/api/upload',
                allowedFileExtensions: ['jpeg', 'jpg', 'png', 'gif', 'bmp'],
                maxFileSize: 5120,
                maxFileCount: 10,
                uploadExtraData: function () {
                    return {
                        'nsfw': $('#nsfw').is(':checked'),
                    };
                }
            });
        });

        $('#image-input').on('fileuploaded', function (event, data, previewId, index) {
            const response = data.response;
            const imageDetails = response.data;
            if (response.success === true) {
                $('#urlcode').append(imageDetails.link + "\n");
                $('#htmlcode').append("&lt;img src=\"" + imageDetails.link + "\" alt=\"" + imageDetails.name +
                    "\" title=\"" + imageDetails.name + "\" /&gt;" + "\n");
                $('#bbcode').append("[img]" + imageDetails.link + "[/img]" + "\n");
                $('#markdown').append("![" + imageDetails.name + "](" + imageDetails.link + ")" + "\n");
                $('#markdownlinks').append("[![" + imageDetails.name + "](" + imageDetails.link + ")]" + "(" +
                    imageDetails.link + ")" + "\n");
                $('#deletecode').append(imageDetails.deleteLink + "\n");
            }
        });
    </script>
@endpush
