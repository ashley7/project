@extends('layouts.app')
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Blogs </small></h2>
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

          <table id="datatable" class="table table-striped table-bordered">
              <thead>
                 <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>title</th>
                    <th>description</th>
                    <th>Blog status</th>
                    <th>Author</th>
                    <th>Featured status</th>
                    <th>Created at</th>
                    <th>edit</th>
                    <th>delete</th>
                 </tr>
              </thead>
              <tbody>
                 @foreach ($blogs as $item)
                 <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        <img style="width: 90px" src="{{ asset('uploads/blog/'.$item->attachment) }}" /> 
                    </td>
                    <td>{{ $item->title }}</td>
                    <td>{!! str_limit($item->description, $limit = 150, $end = '...')  !!}</td>
                     <td>
                        <span class="@if ($item->blog_status=='Draft')
                          label label-danger
                         @elseif($item->blog_status=='Rejected')
                         label label-primary
                        @else
                        label label-success
                        @endif">
                       {{ $item->blog_status }}
                      </span>
                      </td>
                    <td>{{ $item->user->surname." ".$item->user->othername }}</td>
                     <td>
                        <input type="checkbox" @if ($item->featured=='yes')
                        checked
                        @endif /> {{ $item->featured }}
                     </td>
                     <td>
                        @php
                        $exdate = explode(",", $item->created_at->format('d M Y, G:i'));
              $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $item->created_at->format('d M Y, G:i');
                  @endphp
                  {{ $time }}
                    </td>
                     <td>
                       @can('blog-edit')
                          <a href="{{ url("/dash-blog/$item->id/dash_edit") }}"> <i class="fa fa-pencil"></i> Edit Record</a>
                      
                          @endcan
                        </td>
                    <td> 
                         @can('blog-delete') <a href="{{ route('dash_delete_blog', $item->id) }}" class="btn btn-danger btn-xs" onclick="event.preventDefault();document.getElementById('delete-record-{{$item->id}}').submit();">Delete</a>

                          <form id="delete-record-{{$item->id}}" method="POST" action="{{ route('dash_delete_blog', $item->id) }}" style="display: none;">
                             @csrf
                              @method('DELETE')
                          </form>
                         @endcan
                       </td>   
                 </tr>
                 @endforeach
              </tbody>
           </table>

      </div>
    </div>
  </div>
</div>


    
@endsection