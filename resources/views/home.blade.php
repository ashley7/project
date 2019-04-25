@extends('layouts.app')
@section('content')
<div class="row tile_count">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="count">{{ $users_count }}</div>
          <h3>Total Users</h3>
        </div>
      </div>


      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="count">{{ number_format($blogs_count) }}</div>
            <h3>Total Blogs</h3>
          </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
              <div class="count">{{ number_format($publications_count) }}</div>
              <h3>Total Publications</h3>
            </div>
          </div>

          <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="count">{{ number_format($discussions_count) }}</div>
                <h3>Total Forums</h3>
              </div>
            </div>
  
</div>
<!-- /top tiles -->
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="col-md-6 col-sm-6 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>OnLine activity</h2>
               <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                     <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                     </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
               </ul>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <canvas id="onlineActivity"></canvas>
            </div>
         </div>
      </div>

      {{-- <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel tile fixed_height_320 overflow_hidden">
             <div class="x_title">
                <h2>Blog Categories performance</h2>
                <ul class="nav navbar-right panel_toolbox">
                   <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                   </li>
                   <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                         <li><a href="#">Settings 1</a>
                         </li>
                         <li><a href="#">Settings 2</a>
                         </li>
                      </ul>
                   </li>
                   <li><a class="close-link"><i class="fa fa-close"></i></a>
                   </li>
                </ul>
                <div class="clearfix"></div>
             </div>
             <div class="x_content">
                <table class="" style="width:100%">
                   <tr>
                      <th style="width:37%;">
                         <p>Top 5</p>
                      </th>
                      <th>
                         <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                            <p class="">Device</p>
                         </div>
                         <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <p class="">Progress</p>
                         </div>
                      </th>
                   </tr>
                   <tr>
                      <td>
                         <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                      </td>
                      <td>
                         <table class="tile_info">
                            <tr>
                               <td>
                                  <p><i class="fa fa-square blue"></i>IOS </p>
                               </td>
                               <td>30%</td>
                            </tr>
                            <tr>
                               <td>
                                  <p><i class="fa fa-square green"></i>Android </p>
                               </td>
                               <td>10%</td>
                            </tr>
                            <tr>
                               <td>
                                  <p><i class="fa fa-square purple"></i>Blackberry </p>
                               </td>
                               <td>20%</td>
                            </tr>
                            <tr>
                               <td>
                                  <p><i class="fa fa-square aero"></i>Symbian </p>
                               </td>
                               <td>15%</td>
                            </tr>
                            <tr>
                               <td>
                                  <p><i class="fa fa-square red"></i>Others </p>
                               </td>
                               <td>30%</td>
                            </tr>
                         </table>
                      </td>
                   </tr>
                </table>
             </div>
          </div>
       </div> --}}
   </div>
</div>
<br />
{{-- <div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div>
          <div class="x_title">
            <h2>Recent Registrations</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <ul class="list-unstyled top_profiles scroll-view">
             @foreach ($recent_registrations as $item)
             <li class="media event">
                {{-- <a class="pull-left border-aero profile_thumb">
                  <i class="fa fa-user aero"></i>
                </a> --}}
                {{-- <div class="media-body">
                  <a class="title" href="#">{{ $item->surname." ".$item->othername }}</a>
                  <p><strong> {{ $item->email }} </strong> </p>
                  <p> <small> {{ $item->created_at }}</small>
                  </p>
                </div>
              </li>  
             @endforeach
          
          </ul>
        </div>
      </div> --}}


{{-- </div>  --}}
<script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}"></script>
   
<script>
   $(document).ready(function() {

            var f = document.getElementById("onlineActivity");
            new Chart(f, {
                type: "bar",
                data: {
                    labels: ["News", "Blogs", "Discussion Forum", "Publications"],
                    datasets: [{
                        label: "# Activity Log",
                        backgroundColor: "#26B99A",
                        data: [<?php echo $news_log ?>, <?php echo $blogs_log ?>, <?php echo $discussion_log ?>, <?php echo $publications_log?>]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: !0
                            }
                        }]
                    }
                }
            })
        
   });
   
   
</script>
@endsection