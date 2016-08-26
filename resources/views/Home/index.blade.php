@extends('layout.master')

@section('content')

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

    @include('Home.partials.FreeSigTable')

    @include('Home.partials.OwnSigTable')

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

        if(data.update)
        {
            updateAllSigs();
            getLatestTimeUpdate();
        }
    } );

    Channel.bind( 'App\\Events\\SignatureIsGettingRunned', function( data ) {

        var sig = data['sig'];

        var id = "#" + sig.id;

        var tables = $('.dataTable').DataTable();

        var freeTable = tables.table('#freeSigsTable');
        var ownTable = tables.table('#ownSigsTable');

        freeTable.row(id).remove().draw();

        var newRow = {
            "DT_RowId": sig.id,
            "0": sig.sig_id,
            "1": sig.type,
            "2": sig.status,
            "3": (sig.circular) ? "Yes" : "No",
            "4": (sig.carrier) ? "Yes" : "No",
            "5": '<button type="button" class="btn btn-warning finishSiteBtn">Finished</button>'
        };

        var newRowNode = ownTable.row.add(newRow).draw().node();


        //highlight it was added TODO not getting back to black. Why?
        $( newRowNode )
                .css( 'color', 'red' )
                .animate( { color: 'black' }, 1500);

    });

    Channel.bind( 'App\\Events\\SignatureIsFinished', function( data ) {

        var sig = data['sig'];

        var id = "#" + sig.id;

        var tables = $('.dataTable').DataTable();
        var ownTable = tables.table('#ownSigsTable');

        ownTable.row(id).remove().draw();

        var newRow = {
            "DT_RowId": sig.id,
            "DT_RowClass": "bg-warning",
            "0": sig.sig_id,
            "1": sig.type,
            "2": sig.status,
            "3": (sig.circular) ? "Yes" : "No",
            "4": (sig.carrier) ? "Yes" : "No",
            "5": ''
        };

        var newRowNode = ownTable.row.add(newRow).draw().node();

    });
</script>

<script language="JavaScript">
    $(document).ready(function () {

        //make dataTables
        makeDataTables();

        //click binder for run btns
        $(document).on('click', '.runSiteBtn', function() {
            //get element id from hidden field
            var id = $(this).closest('tr').attr('id');
            runSite(id)
        });

        //click binder for finish btns
        $(document).on('click', '.finishSiteBtn', function() {
            //get element id from hidden field
            var id = $(this).closest('tr').attr('id');
            finishSite(id)
        });


        //Last updated time
        getLatestTimeUpdate();
        //update time every 2 min
        window.setInterval(getLatestTimeUpdate, 120000);
    });

    function makeDataTables() {
        $('#freeSigsTable').DataTable( {
            pageLength: 10,
            "lengthMenu": [ 10, 15, 20, 25 ]
        });

        //TODO make sort by status as default
        $('#ownSigsTable').DataTable( {
            pageLength: 10,
            "lengthMenu": [ 10, 15, 20, 25 ]
        });
    }

    function runSite(id)
    {
        //ajax call with db id of sig that is getting runned
        $.post('{{ route('sig.runSite') }}', {sig_id: id});
    }

    function finishSite(id)
    {
        //ajax call with db id of sig that is getting runned
        $.post('{{ route('sig.finishSite') }}', {sig_id: id});
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

            $('#freeSigROW').fadeOut("slow", function() {
                $(this).replaceWith(data.htmlFree);
                $('#freeSigROW').fadeIn("slow");
            });

            $('#ownSigROW').fadeOut("slow", function() {
                $(this).replaceWith(data.htmlOwn);
                $('#ownSigROW').fadeIn("slow");

                //make them to datatables
                makeDataTables();
            });

        });
    }
</script>
@endpush