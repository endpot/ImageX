@extends('layout')

@section('content')
    <div>
        <div class="page-header">
            <h1>API Doc <small>图片上传 API</small></h1>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <span class="label label-danger">POST</span>
                <span class="label label-primary">
                    {{ trim(config('app.url'), '/') }}/api/upload
                </span>
            </div>

            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Param</th>
                    <th>Type</th>
                    <th>Required</th>
                    <th>Example</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>image</td>
                    <td>File</td>
                    <td>Yes</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>nsfw</td>
                    <td>Boolean</td>
                    <td>No</td>
                    <td>True</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <span class="label label-danger">Response</span>
            </div>

            <div class="panel-body">
                <pre>
// Success Response Example
{
    "success": true,
    "data": {
        "name": "猎人杂货铺.jpg",
        "link": "http://i.endpot.com/image/AAZ90/%E7%8C%8E%E4%BA%BA%E6%9D%82%E8%B4%A7%E9%93%BA.jpg",
        "deleteLink": "http://i.endpot.com/delete/AAZ90WIIPN"
    }
}

// Error Response Example
{
    "success": false,
    "data": ""
}
                </pre>
            </div>
        </div>
    </div>
@endsection
