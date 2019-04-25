@extends('layouts.app')
@section('content')
<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Publications</h2>
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
                    <th>topic</th>
                    <th>description</th>
                    <th>Status</th>
                    <th>Published on</th>
                    <th>Published by</th>
                    <th>edit</th>
                    <th>delete</th>
                  </tr>
                </thead>


                <tbody>
                  @foreach ($publications as $item)
                  <tr>
                    <td>{{ $item->id }}</td> 
                    <td>{!! $item->topic !!}</td>
                    <td>{!! $item->description !!}</td>
                    <td>
                        <span class="@if ($item->status=='Draft')
                          label label-danger
                          @elseif($item->status=='Rejected')
                          label label-primary
                        @else
                        label label-success
                        @endif">
                       {{ $item->status }}
                      </span>
                      </td>
                   
                    <td>
                        @php
                        $exdate = explode(",", $item->created_at->format('d M Y, G:i'));
              $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $item->created_at->format('d M Y, G:i');
                  @endphp
                  {{ $time }}
                    </td>
                    <td>{{ $item->user->surname." ".$item->user->othername }}</td>
                  
                     <td>@can('publication-edit')
                        <a href=" {{ url("/dash-publications/$item->id/dash_edit") }}"> <i class="fa fa-pencil"></i> Edit Record</a></td>   
                
                        @endcan
                    <td> 
                      @can('publication-delete')
                      <a href="#" onclick="
                      var result=confirm('are u sure want to delete');
                         if(result){
                             event.preventDefault();
                             document.getElementById('delete-form').submit();
                         }
                      "> <i class="fa fa-trash-o"></i> Delete Record</a>
                       <form id="delete-form" method="post"  action="{{ route('dash-publications-delete',[$item->id]) }}">
                          <input type="hidden" value="delete" name="_method">
                          {{ csrf_field() }}
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