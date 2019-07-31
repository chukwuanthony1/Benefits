@extends('layouts.adminlayout')
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Category</span>
            </li>
            <li>
                <span>New</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                <i class="icon-calendar"></i>&nbsp;
                <span class="thin uppercase hidden-xs"></span>&nbsp;
                <i class="fa fa-angle-down"></i>
            </div>
        </div>
    </div>
    <h3 class="page-title"> New Category
        <small></small>
    </h3>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <div class="row">
      <div class="col-md-6">
        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light bordered">
        <div class="portlet-body">
          {!! Form::open(['url'=>'/admin/categories/new', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
            <div class="form-group has-feedback">
              {!! Form::label('Category Name') !!}
              {!! Form::text('name', null, ['class'=>'form-control', 'required'=> 'required']) !!}
            </div>
            <div class="form-group has-feedback">
              {!! Form::label('Category Description') !!}
              {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group has-feedback">
              {!! Form::label('Image') !!}
              {!! Form::file('image', ['class'=>'form-control']) !!}
            </div>
            <div class="form-group has-feedback">
              {!! Form::label('Parent Category') !!}
              {!! Form::select('parent_id', $categoyList, '0', ['class'=>'form-control', 'placeholder'=>'Select A Category']) !!}
            </div>
            <!--<div class="form-group has-feedback">
              {!! Form::label('Category Image') !!}
              {!! Form::file('image_path', null, ['class'=>'form-control']) !!}
            </div>-->
            <div class="form-group">
              {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
            </div>
          {!! Form::close() !!}
        </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

@endsection