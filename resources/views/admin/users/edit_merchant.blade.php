@extends('layouts.adminlayout')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Edit Merchant</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Merchant</li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
        
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
          @endif
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit Merchant</h3>
            </div>
            <div class="card-body">
              {!! Form::open(['url'=>'/admin/edit-merchant/'.$userDetails->id, 'class'=>'form']) !!}
                <div class="form-group has-feedback">
                  {!! Form::label('Merchant Name') !!}
                  {!! Form::text('name', $userDetails->name, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group has-feedback">
                  {!! Form::label('Merchant Description') !!}
                  {!! Form::email('email', $userDetails->email, ['class'=>'form-control']) !!}
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
        </div>
    </div>
  </section>
</div>
@endsection