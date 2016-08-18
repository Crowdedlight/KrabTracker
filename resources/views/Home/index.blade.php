@extends('layout.master')

@section('content')

        <?php
        $freeSigs = Auth::user()->freeSigs();
        $ownSigs = Auth::user()->ownSigs();
        ?>

<!-- SIDEBAR -->
<div class="pull-right">
    <div class="jumbotron sidebar-jumbotron">
        <h4 class="text-center">Signatures Last Updated</h4>
        <p class="text-center text-info" id="lastUpdateTime">Never</p>
        <?php echo Modal::named('update_sigs')
                ->withTitle('Update Signatures')
                ->withButton(Button::success('Update Signatures')->addClass(['center-block']))
                ->withBody(view('Home.modals.update_sigs')->render())
        ?>
    </div>
</div>

    @include('Home.partials.FreeSigTable', $freeSigs)

    @include('Home.partials.OwnSigTable', $ownSigs)

@endsection

@push('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
@endpush

@push('javascript')
<script language="JavaScript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>

<script src="//js.pusher.com/2.2/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;
    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: 'eu',
        encrypted: true
    });

    //Subscribe binding
    var Channel = pusher.subscribe( 'sigAction' );

    Channel.bind( 'App\\Events\\SignaturesUpdated', function( data ) {

        console.log(data.update);
        if(data.update)
        {
            updateAllSigs();
            getLatestTimeUpdate();
        }
    } );
</script>

<script language="JavaScript">
    $(document).ready(function () {
        $('#freeSigsTable').DataTable( {
            pageLength: 10,
            "lengthMenu": [ 10, 15, 20, 25 ]
        });

        $('#ownSigsTable').DataTable( {
            pageLength: 10,
            "lengthMenu": [ 10, 15, 20, 25 ]
        });

        //click binder for run btns
        $('.runSiteBtn').on('click', function() {
            //get element id from hidden field
            $id = $(this).closest('tr').attr('id');
            runSite($id)
        });


        //Last updated time
        getLatestTimeUpdate();
        //update time every 2 min
        window.setInterval(getLatestTimeUpdate(), 120000);
    });

    function runSite(id)
    {
        //ajax call with db id of sig that is getting runned
    }

    function getLatestTimeUpdate()
    {
        $.get('{{route('sig.lastUpdate')}}', function(data){
            var time = moment.utc((data[0].value)).fromNow();
            $('#lastUpdateTime').text(time);
        });
    }

    function updateAllSigs()
    {
        $.get('{{route('sig.getUpdatedTables')}}', function(data){
            console.log(data);
        });
    }
</script>
@endpush