<?php
$ownSigs = Auth::user()->ownSigs();
?>

<div class="row" id="ownSigROW">
    <div class="col-md-9">
        <div class="jumbotron">
            <h2>Your Signatures</h2>
            <ul class="list-group">
                <table id="ownSigsTable" class="table table-striped">
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
                    @foreach($ownSigs as $sig)
                        {{ $className = "" }}
                        @if($sig->circular)
                            {{ $className = "bg-warning" }}
                        @endif
                        @if($sig->carrier)
                            {{ $className = "bg-danger" }}
                        @endif

                        <tr class="{{ $className  }}" id="{{$sig->id}}" >
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
                                @if ($sig->status === 'running')
                                    <button type="button" class="btn btn-warning finishSiteBtn">Finished</button>
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

