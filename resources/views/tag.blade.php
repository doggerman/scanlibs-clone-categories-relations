@extends('index')

@section('content')
  <div class="container">

        <div class="row">

          <div class="col-sm-10 blog-main">

  <div class="page-header"><h1>Tag: "{{ $tag->name }}"</h1></div>

<div class="page-header"><h1>"Categories block"</h1>
          <div class="panel-body">
            <div class="pull-right">
              <div class="btn-group">
                    @foreach ($categorylist as $category)              
                <button type="button" class="btn btn-category-{{ $category->id }} btn-filter" data-target="category-{{ $category->id }}">{{ $category->name }}</button>
                    @endforeach                
                <button type="button" class="btn btn-default btn-filter" data-target="all">All Categories</button>                    
              </div>
            </div>  
          </div>  
</div>  


<div class="own_table">
      <h1>Table Filter</h1>

<div class="bs-example" data-example-id="hoverable-table">
    <table class="table table-hover table-filter">
        <thead>
            <tr>
                <th></th>
                <th>Check</th>                
                <th></th>
                <th></th>                
                <th>Title</th>

            </tr>
        </thead>
        <tbody>
                    @foreach ($posts as $key=>$post)
            <tr data-status="@foreach ($post['4'] as $category)category-{{ $category->id }}@endforeach"
              @if ($post['2'] == 'Y') 
                class="selected" 
              @endif>
                <td>{{++$key}}</td>
                <td>
                      <div class="ckbox">
                        <input type="checkbox" id="checkbox-{{$post['0']}}" @if ($post['2'] == 'Y') checked @endif>
                        <label for="checkbox-{{$post['0']}}" id="checkbox-{{$post['0']}}"></label>
                      </div>                  
                </td>
                <td>
                      <a href="javascript:;" class="star 
                        @if ($post['3'] == 'Y') 
                          star-checked 
                        @endif">
                        <i class="glyphicon glyphicon-star" id="star-{{$post['0']}}"></i>
                      </a>                  
                </td>                                
<td>
                        <a href="#" class="pull-left ">
                            <i class="fa fa-book fa-icon "></i>
                        </a>  
</td>
<td>
                      <div class="media">
                        <div class="">
                          <h4 class="title">
                            <span class="pull-right">

                    @foreach ($post['4'] as $category)
                        <span class="category-{{ $category->id }}">({{ $category->name }})</span> &nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                            
                            
                            </span>
                          </h4>
                          <p class="summary">{{ $post['1'] }}</p>
                        </div>
                      </div>
                    </td>
            </tr>
                   @endforeach            
        </tbody>
    </table>
</div>

</div>  

          </div><!-- /.blog-main -->


          <div class="col-sm-2">
            <div class="page-header"><h1>"Tags"</h1>
            <p class="lead blog-description">
                              @foreach ($taglist as $tag)
                                  <a href="/tag/{{ $tag->id }}">{{ $tag->name }}</a>&nbsp;&nbsp;&nbsp;&nbsp;
                              @endforeach
            </p>
            </div>

          </div>

        </div><!-- /.row -->

      </div><!-- /.container -->

          <div class="footer">
              &copy; 2016 <a href="/">"Scanlibs.clone"</a>
          </div>
@endsection

