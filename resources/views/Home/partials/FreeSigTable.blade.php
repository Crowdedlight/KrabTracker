
<?php
    $freeSigs = Auth::user()->freeSigs();
?>

<div class="row" id="freeSigROW">
    <div class="col-md-9">
        <div class="jumbotron">
            <h2>Current Free Signatures</h2>
            <ul class="list-group">
                <table id="freeSigsTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Sig ID</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Circular</th>
                        <th>Carrier</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($freeSigs as $sig)
                        {{ $className = "" }}
                        @if($sig->circular)
                            {{ $className = "bg-warning" }}
                        @endif
                        @if($sig->carrier)
                            {{ $className = "bg-danger" }}
                        @endif

                        <tr class="{{ $className  }}" id="{{$sig->id}}">
                            <td>
                                {{$sig->sig_id }}
                            </td>
                            <td>{{$sig->type }}</td>
                            <td>{{$sig->status }}</td>
                            <td>
                                @if ($sig->circular)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td>
                                @if ($sig->carrier)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td>
                                @if ($sig->status === 'free')
                                    <button type="button" class="btn btn-success runSiteBtn">Run Site</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </ul>
        </div>
    </div>
</div>

