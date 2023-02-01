<h1> Buddhist and Pali University of SriLanka </h1>
<h3> Fixed Asset - supplier details</h3>
<h5>Division :{{$divisionNam == '-1' ? 'All' : $divisionNam}} ,
  Category : {{$maincategoryName == '-1' ? 'All' : $maincategoryName}} ,
      Period From : {{ $fromDate == '-1' || $fromDate == 'All' ? 'All' : $fromDate}},
         to : {{$toDate == '-1' || $toDate == 'All' ? 'All' : $toDate}} </h5>
<br />
<div class="col-md-12 text-right">
  <a href="{{url('/fixedAssets/suplier/view/excel/'.($fxItem == null ? '-1' : $fxItem).
      '/'.$divisionNam.'/'.$maincategoryName.'/'.($fromDate == '-1' || $fromDate == 'All' ? 'All' : $fromDate).
          '/'.($toDate == '-1' || $toDate == 'All' ? 'All' : $toDate))}}" class="btn btn-success">
      Convert Into Excel</a>
</div>
<div class="row text-left">
    <div class="col-md-12">
        <div><b><u>{{$categorydescription}}</u></b> </div>
    </div>
    </div>
    <div class="row">
    <div class="col-md-12 pl-5 mt-5" style='text-align:left'>
            <div class="table-responsive">
              @if( $supplier->isNotEmpty() && $supplier->count()>0 )
                <table class="table table-striped ">
                    <thead class="thead-dark">
                            <th>GRN No</th>
                            <th>Fixed Assest No</th>
 z                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else($supplier->Empty())
                  <div class="alert alert-danger" role="alert">
                    Data Unavailable !
                  </div>
            @endif   
            </div>
        </div>
    </div>
</div>
