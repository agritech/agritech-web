@extends('templates.normal')

{{-- Page title --}}
@section('title') Liste des zones de  cultures @endsection

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
<style>
#map
{
  min-height: 600px;
  width:100%;        
}
</style>
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
    
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<script>
// The following example creates complex markers to indicate beaches near
// Sydney, NSW, Australia. Note that the anchor is set to
// (0,32) to correspond to the base of the flagpole.

function initialize() {
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(13.525120, 2.107531)
  }
  var map = new google.maps.Map(document.getElementById('map'),
                                mapOptions);

  setMarkers(map, beaches);
}

/**
 * Data for the markers consisting of a name, a LatLng and a zIndex for
 * the order in which these markers should display on top of each
 * other.
 */
var beaches = [
     @foreach($culturezones as $key => $value)
        ['{{$value->name}}',{{$value->latitude}}, {{$value->longitude}},{{$key+ 1}}],
     @endforeach
];

function setMarkers(map, locations) {
  // Add markers to the map

  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.

  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  var image = {
    url: '{{ URL::to('/') }}/assets/images/cultureFlag.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(32, 32),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(0, 32)
  };
  // Shapes define the clickable region of the icon.
  // The type defines an HTML &lt;area&gt; element 'poly' which
  // traces out a polygon as a series of X,Y points. The final
  // coordinate closes the poly by connecting to the first
  // coordinate.
  var shape = {
      coords: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
  };
  for (var i = 0; i < locations.length; i++) {
    var beach = locations[i];
    var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        shape: shape,
        title: beach[0],
        zIndex: beach[3]
    });
  }
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

@endsection

{{-- Page content --}}

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Zone de Cultures <a href="{{ URL::to('culturezone/new') }}" class="btn btn-success pull-right">Ajouter une zone de culture</a></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des zones de cultures
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
                    
    	              <!-- NEW -->
                      <ul class="nav nav-pills">
    <li class="active"><a href="#info-tab" data-toggle="tab">Liste <i class="fa"></i></a></li>
    <li><a href="#map-tab" data-toggle="tab">Carte <i class="fa"></i></a></li>
</ul>


    <div class="tab-content">
        <div class="tab-pane active" id="info-tab">
             <div class="table-responsive" >
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    
                                    <th>Nom</th>
                                    <th>Coordonnees</th>
                                     <th>Periodes de Culture</th>
                                    <th>Description</th>
                                    <th class="no-sort" style="width:17px;min-width:75px;max-width:75px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($culturezones as $key => $value)
                                <tr>
                                     <td>{{$value->name}}</td>
                                     <td>{{$value->longitude}} <br> {{$value->latitude}} <br><a href="#" data-toggle="tooltip" data-html="true" data-placement="right" title="afficher la carte"><i class="fa fa-map-marker fa-2"></i></a></td>
                                    <td class="col-md-6">
                                        <ul>
                                        @foreach($value->CultureZonePeriods as $periodkey => $periodvalue)
                                           <li><strong>{{$periodvalue->Culture->name}}</strong> &nbsp;&nbsp;&nbsp;&nbsp; [ <strong>{{ date("d M Y",strtotime($periodvalue->from))}}</strong> &agrave; <strong>{{ date("d M Y",strtotime($periodvalue->to))}}</strong>] </li>
                                        @endforeach
                                        </ul>
                                        
                                    </td>
                                    <td>{{$value->description}}</td>
                                    <td nowrap="nowrap">
                                        <a href="{{ URL::to('culturezone/' . $value->id .'/modify') }}" class="btn btn-sm btn-success"> <i class="fa fa-edit"></i> </a>&nbsp;
                                        {{ Form::open(array('url' => 'culturezone/' . $value->id, 'class' => 'pull-right')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        {{ Form::close() }}
                                      </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        </div>

        <div class="tab-pane" id="map-tab">
                    <!-- MAP -->
                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                    <div id="map"></div>
                    <!-- END MAP -->
        </div>
        
    </div>
 

                      <!-- END NEW --> 
                     
                    
                    
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
