<div class="row">
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
                        <th></th>
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

                        <tr class="{{ $className  }}">
                            <th>
                                <input type="text" hidden class="hidden" value="{{$sig->id}}" >
                                {{$sig->sig_id }}
                            </th>
                            <th>{{$sig->type }}</th>
                            <th>{{$sig->status }}</th>
                            <th>
                                @if ($sig->circular)
                                    Yes
                                @else
                                    No
                                @endif
                            </th>
                            <th>
                                @if ($sig->carrier)
                                    Yes
                                @else
                                    No
                                @endif
                            </th>
                            <th>
                                @if ($sig->status === 'running')
                                    <button type="button" class="btn btn-warning">Finished</button>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </ul>
        </div>
    </div>
</div>
