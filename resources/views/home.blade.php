<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/css/fileinput.min.css" rel="stylesheet">

        <title>{{ env('APP_NAME') }}</title>
    </head>
    <body>
        <header>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container d-flex justify-content-between">
                    <a href="#" class="navbar-brand d-flex align-items-center">
                        <strong>{{ env('APP_NAME') }}</strong>
                    </a>
                </div>
            </div>
        </header>
        <main>
            <section class="pt-md-5 pb-md-4 mx-auto text-center">
                <div class="container">
                    <div class="file-loading">
                        <input id="image-input" name="image" type="file" accept="image/*" multiple>
                    </div>
                    <div class="text-left my-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="nsfw">
                            <label class="custom-control-label" for="nsfw">NSFW (Not Safe For Work)</label>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <ul id="navTab" class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#urlcodes" data-toggle="tab">URL</a></li>
                        <li class="nav-item"><a class="nav-link" href="#htmlcodes" data-toggle="tab">HTML</a></li>
                        <li class="nav-item"><a class="nav-link" href="#bbcodes" data-toggle="tab">BBCode</a></li>
                        <li class="nav-item"><a class="nav-link" href="#markdowncodes" data-toggle="tab">Markdown</a></li>
                        <li class="nav-item"><a class="nav-link" href="#markdowncodes2" data-toggle="tab">Markdown with Link</a></li>
                        <li class="nav-item"><a class="nav-link" href="#deletepanel" data-toggle="tab">Delete Link</a></li>
                    </ul>
                    <div id="navTabContent" class="tab-content">
                        <div class="tab-pane fade in active show text-left" id="urlcodes">
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
            </section>
        </main>
        <footer class="footer" style="width: 100%; line-height: 60px; background-color: #f5f5f5;">
            <div class="container">
                <span class="text-muted">Copyright Ⓒ 2018. All rights reserved.</span>
            </div>
        </footer>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/themes/fa/theme.min.js"></script>

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

            $('#image-input').on('fileuploaded', function(event, data, previewId, index) {
                var response = data.response;
                var imageDetails = response.data;
                if (response.success === true) {
                    $('#urlcode').append(imageDetails.link + "\n");
                    $('#htmlcode').append("&lt;img src=\""+ imageDetails.link +"\" alt=\""+ imageDetails.name +"\" title=\""+ imageDetails.name +"\" /&gt;" + "\n");
                    $('#bbcode').append("[img]"+ imageDetails.link +"[/img]" + "\n");
                    $('#markdown').append("!["+ imageDetails.name +"](" + imageDetails.link + ")" + "\n");
                    $('#markdownlinks').append("[!["+ imageDetails.name +"](" + imageDetails.link + ")]" +"(" + imageDetails.link + ")" + "\n");
                    $('#deletecode').append(imageDetails.deleteLink + "\n");
                }
            });
        </script>
    </body>
</html>
