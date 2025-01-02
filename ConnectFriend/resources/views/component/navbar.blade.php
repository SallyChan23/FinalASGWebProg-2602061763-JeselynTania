<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Connect Friend</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
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
                            <span class="badge badge-danger">{{ $notificationCount }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .badge-danger {
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
    margin-left: 5px;
}
</style>

<script>
    function updateUnreadCount() {
        fetch("{{ route('notifications.count') }}")
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('unread-count');
                if (data.count > 0) {
                    countElement.style.display = 'inline';
                    countElement.textContent = data.count;
                } else {
                    countElement.style.display = 'none';
                }
            });
    }

    setInterval(updateUnreadCount, 30000); // Update every 30 seconds
    document.addEventListener('DOMContentLoaded', updateUnreadCount);
</script>