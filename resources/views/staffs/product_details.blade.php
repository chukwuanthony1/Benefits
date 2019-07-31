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
              <span>{{$productDetails->product_name}}</span>
              <i class="fa fa-angle-right"></i>
          </li>
          <li>
              <span>Details</span>
          </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
          <div class="title-section style3 text-left">
              <h1 class="title">{{$productDetails->product_name}}</h1>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="item-wrap">
              <div class="item item-details">
                <div class="featured-item">
                  <div class="flexslider">
                    <ul class="slides">
                      @forelse ($productImages as $pImages)
                        <li>
                          <img src="{{asset('images/products/small/') }}/{{ $pImages->image_path }}" />
                        </li>
                      }@empty
                          <p>No Product</p>
                      @endforelse
                    </ul>
                  </div>
                </div>
                <div class="content-item">
                  <div class="col-md-3">
                    <div class="thumbnail">
                      <img src="{{ asset('images/logos/small/') }}/{{$productDetails->image_path}}">
                    </div>
                    <h2>{{ number_format($productDetails->price,2) }}% Discount</h2>
                  </div>
                  <div class="col-md-9">
                    <h1 class="title-item">{{$productDetails->product_name}}</h1>
                    <p>{!! $productDetails->description !!}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <div class="item-wrap">
              <div class="video-services clearfix">
                  <div class="flat-video float-left">
                      <a class="fancybox" data-type="iframe" href="https://www.youtube.com/embed/2Ge1GGitzLw?autoplay=1"> 
                          <img src="{{asset('images/products/small/') }}/{{ $productImages[0]->image_path }}" alt="image">
                      </a>
                  </div>
                  <div class="wrap-acadion float-left">
                    <h2>Frequently Asked Questions</h2>
                    <div class="flat-accordion">
                      <div class="flat-toggle">
                          <div class="toggle-title active">Is there anything I should bring?</div>
                          <div class="toggle-content" style="display: block;">
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                          </div>
                      </div><!-- /toggle -->
                      <div class="flat-toggle">
                          <div class="toggle-title">Where can I find market research reports?</div>
                          <div class="toggle-content">
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                          </div>
                      </div><!-- /toggle -->
                      <div class="flat-toggle">
                          <div class="toggle-title">Where can I find the Wall Street Journal ?</div>
                          <div class="toggle-content">
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                          </div>
                      </div><!-- /toggle -->
                    </div><!-- /.accordion -->                    
                  </div>
              </div><!-- /.video-services -->
              <div class="alert alert-danger" style="display:flex;">
                <div class="col-md-1">
                  <i class="fa fa-info-circle fa-5x" style="padding: 30px 0px;"></i>
                </div>
                <div class="col-md-11">
                  <p>
                    Please note that this offer is a confidential matter of the company. If these confidential terms and conditions become known externally, the provider will close down the offer. Please do not print this offer and treat all kinds of information included herein as strictly confidential.
                  </p>
                </div>
              </div>
            </div><!-- /.item-wrap -->  
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="box">
          <div class="panel panel-default">
            <div class="panel-body">
              <h4>Take Offer</h4>
              <p>Get your coupon now and redeem it in the online shop.</p>
              <br/>
              <div class="form-group cbg3-warning alert alert-danger">
                No codes exist for this product/merchant. Please consult our Support.
              </div>
              <br/>
              <div class="form-group couponGroup">
                <h4><label>Coupon</label></h4>
                <input type="text" class="couponCode form-control" id="couponCode" value="">
              </div>
              <button class="btn btn-danger form-control" id='getCoupon' data-marchantid="{{ $productDetails->merchant_id }}">
                <span>Get your coupon now</span>
              </button>
              <div class="clearfix"></div>
              <br/>
              <a id="shopOnline" class="btn btn-warning form-control" data-marchanturl="{{ $productDetails->site_url }}">
                <span>Online shop</span>
              </a>
              <hr/>
              <h3>Customer care</h3>
              <p>Please do not hesitate to contact the Shell team with any questions you may have concerning this offer, via e-mail at {{ $productDetails->email }} or by phone at +2348100000 (Mon – Fri, 7:00 am – 6:00 pm). </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(window).load(function() {
    $('.flexslider').flexslider({
      animation: "fade"
    });
  });

  $(document).on('click', '#shopOnline',function(){

    var merchanturl = $(this).data('marchanturl');

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false,
    })

    swalWithBootstrapButtons.fire({
      title: '',
      text: "You will be redirected to the merchant site",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'Cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
        window.open(merchanturl);
      }
    })
  });

  $('.couponGroup').hide();
  $('.cbg3-warning').hide();

  $(document).on('click', '#getCoupon',function(){
    var merchant_id = $(this).data('marchantid');
    var token = '{{ csrf_token() }}';
    $.ajax({
        type: 'POST',
        url:'{!! route('merchant.coupon') !!}',
        data: {
          '_token': token,
          'merchant_id': merchant_id,
        },
        success: function(data){
          console.log(data);
          if(data.code == null){
            $('.cbg3-warning').show();
            $('#getCoupon').hide();
            $('.couponGroup').hide();
          }else{
            $('.couponGroup').show();
            $('#getCoupon').hide();
            $('#couponCode').val(data.code);
          }
        }
    });
  });
</script>
@endsection
