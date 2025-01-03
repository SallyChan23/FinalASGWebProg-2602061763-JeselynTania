<nav class="navbar navbar-expand-lg" style="background-color: #F5EFE7;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Connect Friend</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.update') }}">Profile</a>
                </li>
                <li class="nav-item">
                    @if(Auth::check())
                        <a class="nav-link" href="{{ route('chat.index', ['receiverId' => Auth::user()->id]) }}">Chat</a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Chat</a>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notifications') }}">
                        Notification
                        @if ($notificationCount > 0)
                            <span class="badge badge-danger notification-count";">{{ $notificationCount }}</span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Language
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('set-locale', ['locale' => 'en']) }}">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('set-locale', ['locale' => 'id']) }}">Bahasa Indonesia</a>
                        </li>
                    </ul>
                </li>
                
                
            </ul>
        </div>
    </div>
</nav>

<style>
    .notification-count {
    color: red;
    font-weight: bold;
    margin-left: 0px; 
}
</style>
