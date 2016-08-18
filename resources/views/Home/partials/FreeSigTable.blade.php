<div class="row">
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
                        <th></th>
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
                            <th>
                                {{--<input type="text" hidden class="hidden" value="{{$sig->id}}" >--}}
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
                                @if ($sig->status === 'free')
                                    <button type="button" class="btn btn-success runSiteBtn">Run Site</button>
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

