@extends('layout')

@section('content')
    <div>
        <div class="page-header">
            <h1>About <small>关于</small></h1>
        </div>

        <div class="alert alert-success" role="alert">
            <p style="font-size: larger;">
                You can do anything you want with our free image hosting service. <b>But, remember to be law-abiding.</b>
            </p>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <span class="label label-primary"><b>ImageX</b></span>
            </div>

            <table class="table table-hover table-striped">
                <tbody>
                <tr>
                    <th>License</th>
                    <td><a href="#">MIT</a></td>
                </tr>
                <tr>
                    <th>Author</th>
                    <td><a href="https://hunterx.xyz" target="_blank">HunterX</a></td>
                </tr>
                <tr>
                    <th>Source Code</th>
                    <td><a href="https://github.com/endpot/ImageX" target="_blank">endpot/ImageX</a></td>
                </tr>
                <tr>
                    <th>Docker Image</th>
                    <td><a href="https://hub.docker.com/r/endpot/imagex" target="_blank">endpot/imagex</a></td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>You would find me, if you want.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
