
<nav>
    <div class="nav-container">
        <a href="/dashboard">
            <img src="/img/logo.svg" alt="" class="logo">
        </a>
        <ul>
            <li><a {{ (Request::is('dashboard') ? 'class=active' : '') }} href="/dashboard">Dashboard</a></li>
            <li><a {{ (Request::is('leaderboard') ? 'class=active' : '') }} href="/leaderboard">Leaderboard</a></li>
        </ul>
        <a class="profile-nav-link" href="/user"><img src="{{ $user->avatar }}" alt="{{ $user->id }}" class="profile-nav"></a>
    </div>
</nav>
