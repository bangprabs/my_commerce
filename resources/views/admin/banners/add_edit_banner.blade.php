@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Front Area</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Front Area</a></li>
                        <li class="breadcrumb-item active">Banner Image</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger mt-2 mr-3 ml-3" alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                    @endforeach
                </div>
                @endif

                @if (Session::has('success_message'))
                <div class="mt-2 mr-3 ml-3" style="margin-bottom: -10px">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif

                <form @if (empty($bannerdata['id'])) action="{{ url('admin/add-edit-banner')}}" @else
                    action="{{ url('admin/add-edit-banner/'.$bannerdata['id'])}}" @endif enctype="multipart/form-data"
                    name="bannerForm" id="bannerForm" method="post">@csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="link">Banner Link</label>
                                    <input class="form-control" id="link" name="link" placeholder="Enter Banner Link"
                                        @if (!empty($bannerdata['link'])) { value="{{ $bannerdata['link'] }}" } @else
                                        { value="{{ old('link') }}" } @endif>
                                </div>
                                <div class="form-group">
                                    <label for="title">Banner Title</label>
                                    <input class="form-control" id="title" name="title" placeholder="Enter Banner Title"
                                        @if (!empty($bannerdata['title'])) { value="{{ $bannerdata['title'] }}" } @else
                                        { value="{{ old('title') }}" } @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alt">Banner Alternate Text</label>
                                    <input class="form-control" id="alt" name="alt" placeholder="Enter Banner Alternate Text"
                                        @if (!empty($bannerdata['alt'])) { value="{{ $bannerdata['alt'] }}" } @else
                                        { value="{{ old('alt') }}" } @endif>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="image">Banner Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image"
                                                        name="image">
                                                    <label class="custom-file-label" for="image">
                                                        @if (!empty($bannerdata['image']))
                                                        {{$bannerdata['image']}}
                                                        @else
                                                        Choose file
                                                        @endif
                                                    </label>
                                                </div>
                                                @if (!empty($bannerdata['image']))
                                                <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                                                    data-target="#exampleModalCenter">
                                                    View Image
                                                </button>
                                                @endif
                                            </div>
                                            <div class="font-smaller">Recommended Image Size = <b>Width : 1170px</b> |
                                                <b>Height: 480px</b></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Images -->
                    @if (!empty($bannerdata['image']))
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Images</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img class="img-thumbnail rounded mx-auto d-block"
                                        src="{{ asset('images/banner_images/' . $bannerdata['image']) }}">
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0)" record="banner-image"
                                        recordid="{{ $bannerdata['id'] }}" class="confirmDelete btn btn-danger">Delete
                                        Image</a>
                                    {{-- <a href="{{ url('admin/delete-banner-image/'.$bannerdata['id']) }}"
                                    class="btn btn-danger">Delete Image</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </div>
            </form>
        </div>
</div>
</section>
</div>
@endsection
