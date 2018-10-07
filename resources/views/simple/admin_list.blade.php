@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('description')
{!!$description!!}
@stop

@section('keywords')
{!!$keywords!!}
@stop

@section('appname')
{!!$appname!!}
@stop


@section('content')
	
    
    <div class="content-box">
    	
       {!!$path_url!!}
    	
       <div class="panel panel-success">
  					<div class="panel-heading">{!!$action_name!!}</div>
  					<div class="panel-body">
    					<table class="table table-striped table-bordered table-hover">
                                        	<tr>
                                            	<th>编号</th>
                                                <th>名称</th>
                                                <th>电子邮件</th>
                                                <th>手机号码</th>
                                                <th>角色</th>
                                                <th>相关操作</th>
                                            </tr>
                                        	@foreach($admin_list as $item)
                                        	<tr>
                                            	<td>{!!$item->id!!}</td>
                                                <td>{!!$item->username!!}</td>
                                                <td>{!!$item->email!!}</td>
                                                <td>{!!$item->phone!!}</td>
                                                <td>{!!$item->role_name!!}</td>
                                                <td>
                            <a class="btn" href="{!!url('admin/administrator/'.$item->id.'/edit')!!}"><i class="fa fa-edit"></i>编辑</a>
                            <a class="btn" href="{!!url('admin/administratro/del/'.$item->id)!!}">删除</a>
                                                </td>	
                                            </tr>
                                        	@endforeach
                                        
                                        </table>
  					</div>
				</div>
                
    </div>
@stop