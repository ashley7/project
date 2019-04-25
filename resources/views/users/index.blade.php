@extends('layouts.app')
@section('content')
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
         <div class="x_title">
            <h2>Users</h2>
            @can('user-create')
            <a href="{{ route('users.create') }}" class="btn btn-success pull-right">Create New </a>
            @endcan
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
                     <th>Gender</th>
                     <th>email</th>
                     <th>Phone Number</th>
                     <th>Role</th>
                     <th>account status</th>
                     <th>edit</th>
                     <th>delete</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($users as $item)
                  <tr>
                     <td>{{ $item->id }}</td>
                     <td>{{ $item->surname." ".$item->othername }}</td>
                     <td>{{ $item->gender }}</td>
                     <td>{{ $item->email }}</td>
                     <td>{{ $item->phone_number }}</td>
                     <td>
                           @if(!empty($item->getRoleNames()))
                           @foreach($item->getRoleNames() as $v)
                              <label class="badge badge-success">{{ $v }}</label>
                           @endforeach
                         @endif
                     </td>
                     <td>
                           <input type="checkbox" @if ($item->account_status=="Active")
                           checked
                           @endif /> {{ $item->account_status }}
                     </td>
                     <td> 
                           @can('user-edit')
                        <a href="{{ url("/users/$item->id/edit") }}"> <i class="fa fa-pencil"></i> Edit Record</a>
                        @endcan
                     </td>
                   
                     <td> 

                        @can('user-delete')
                           <a href="{{ route('users.destroy', $item->id) }}" class="btn btn-danger btn-xs" onclick="event.preventDefault();document.getElementById('delete-record-{{$item->id}}').submit();">Delete</a>

                           <form id="delete-record-{{$item->id}}" method="POST" action="{{ route('users.destroy', $item->id) }}" style="display: none;">
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