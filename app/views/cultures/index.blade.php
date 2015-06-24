@extends('templates.normal')

{{-- Page title --}}
@section('title') Liste des cultures @endsection

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
<!-- DataTables CSS -->
{{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
{{ HTML::style('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/css/dataTables.tableTools.min.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/js/dataTables.tableTools.min.js') }}
<script>
$(document).ready(function() {
    $('#dataTables-example').dataTable({
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "{{ URL::to('/')}}/assets/js/plugins/dataTables/extensions/TableTools-2.2.3/swf/copy_csv_xls_pdf.swf"
        },
        "language": {
            "url": "{{ URL::to('/')}}/assets/js/plugins/dataTables/French.lang"
        }
    });
});
</script>
@endsection

{{-- Page content --}}

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Cultures <a href="{{ URL::to('culture/new') }}" class="btn btn-success pull-right">Ajouter une culture</a></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des cultures
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- Success-Messages -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ $message }}
                        </div>
                    @endif
                     @foreach($cultures as $key => $value)
                     <div class="col-sm-6 col-md-2">
                           <div class="thumbnail">
                            <a href="{{ URL::to('culture/' . $value->id ) }}" ><img src="{{ URL::to('/') }}/assets/images/{{$value->image}}"  class="img-circle"></a>
                            <div class="caption">
                                <h3 id="thumbnail-label">{{$value->name}}<a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                <p>{{$value->description}}</p>
                                <p><a href="{{ URL::to('culture/' . $value->id .'/modify') }}" class="btn btn-success"> <i class="fa fa-edit"></i> </a>   <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-times"></i>
                                            </button></p>
                                    
                            </div>
                        </div>
                    </div>
                     @endforeach
                     
     
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
    
    
    

</div>
<!-- /#page-wrapper -->

@endsection
