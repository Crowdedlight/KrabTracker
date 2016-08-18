<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand brand-logo" href="<?= URL::route('home') ?>">
                <img alt="Brand" src="<?= URL::asset('/img/logo.png') ?>" height="60px">
            </a>
            <a class="navbar-brand" href="<?= URL::route('home') ?>">
                <span class="pull-left">KrabTracker</span>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                @if(Auth::check())

                    <li>
                        {{--<a href="{{ URL::route('post.new') }}">New Post</a>--}}
                    </li>

                @endif
            </ul>

            @if(Auth::check())
                <p class="navbar-text navbar-right">
                    Signed in as <strong><?= Auth::user()->name; ?></strong>
                    (<a href="<?=URL::route('auth.logout'); ?>" class="navbar-link">Logout</a>)
                </p>
            @else
                <p class="navbar-text navbar-right">
                    <a href="<?= URL::route('auth.login') ?>">Login</a>
                </p>
            @endif

            @if(isset($eve_time))
                @if($eve_time)
                    <p class="navbar-text navbar-right"><strong class="text-success">CREST ONLINE</strong></p>
                @else
                    <p class="navbar-text navbar-right"><strong class="text-danger">CREST OFFLINE</strong></p>
                @endif
            @endif

        </div>
    </div>
</div>