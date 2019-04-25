@extends('layouts.app')
@section('content')
<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Countries</h2>
              <a href="{{ route('countries.create') }}" class="btn btn-success pull-right">Create New </a>
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
                    <th>Name</th>
                    <th>edit</th>
                    <th>delete</th>
                  </tr>
                </thead>


                <tbody>
                  @foreach ($countries as $item)
                  <tr>
                    <td>{{ $item->id }}</td> 
                    <td>{{ $item->name }}</td>
                     <td> <a href=" {{ url("/countries/$item->id/edit") }}"> <i class="fa fa-pencil"></i> Edit Record</a></td>   
                
                    <td> <a href="#" onclick="
                      var result=confirm('are u sure want to delete');
                         if(result){
                             event.preventDefault();
                             document.getElementById('delete-form').submit();
                         }
                      "> <i class="fa fa-trash-o"></i> Delete Record</a>
                       <form id="delete-form" method="post"  action="{{ route('countries.destroy',[$item->id]) }}">
                          <input type="hidden" value="delete" name="_method">
                          {{ csrf_field() }}
                        </form>
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