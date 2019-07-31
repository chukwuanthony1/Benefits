@extends('layouts.benefitlayout')

@section('content')

<section class="flat-row section-product">
   <div class="container">
        <div class="page-bar">
          <ul class="page-breadcrumb">
              <li>
                  <a href="{{ url('/userhome')}}">Home</a>
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  <span>{{$categoryDetails->name}}</span>
                  <i class="fa fa-angle-right"></i>
              </li>
          </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title-section style3 text-left">
                    <h1 class="title">{{$categoryDetails->name}}</h1>
                </div>
            </div>
        </div>
        <div class="wrap-product clearfix">
            @forelse ($products as $product)
               <div class="product">
                  <div class="box-product">
                     <div class="featured-product">
                        <a href="{{ url('product/details/'.$product->alias) }}">
                           <img src="{{asset('images/products/small/') }}/{{$product->productImage}}" alt="">
                        </a>
                     </div>
                     <div class="content-product text-center">
                        <div class="name">
                            <span>{{$product->product_name}}</span>
                        </div>
                        <div class="mount">
                            <span>{{ number_format($product->price, 2)}}% Discount</span>
                        </div>
                        <div class="btn-card">
                            <a href="{{ url('product/details/'.$product->alias) }}" class="flat-button style2">View Details</a>
                        </div>
                    </div>
                  </div>
              </div>
          @empty
              <p>No Product</p>
          @endforelse
      </div>
   </div>
</section>
@endsection
